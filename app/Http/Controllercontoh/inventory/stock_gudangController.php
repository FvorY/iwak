<?php

namespace App\Http\Controllers\inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;
use App\mMember;
use App\Http\Controllers\logController;
use Carbon\Carbon;
class stock_gudangController extends Controller
{

	 public function stockgudang()
	 {
		 if (!mMember::akses('STOCK GUDANG', 'aktif')) {
			 return redirect('error-404');
		 }
	 	$po = DB::table('d_purchaseorder')->where('po_status','=','F')->get();
	 	return view('inventory/stock_gudang/stockgudang',compact("po"));
	 }
	 public function datatable_stockgudang()
	 {
      $list = DB::table('i_stock_gudang')
                ->leftjoin('m_item', 'i_code', '=', 'sg_iditem')
                ->get();

          // return $list;
      $data = collect($list);

      // for ($i=0; $i <count($data) ; $i++) {
      // 	$check_data_seq = DB::table('d_penerimaan_barang_dt')->where('pbdt_code','=',$data[$i]->pb_code)->get();
      // }

      // return $check_data_seq;
      // return $data;

      return Datatables::of($data)

              ->addColumn('detail', function ($data) {
                        return '<button data-toggle="modal" onclick="detail(this)"  class="btn btn-outline-primary btn-sm">Detail</button>';
              })
              ->rawColumns(['aksi','detail','confirmed','status'])
          ->make(true);
	 }
   public function detail_stockgudang(Request $request)
   {
    $header_nama = DB::table('m_item')->where('i_code','=',$request->id)->first();
		$id = $request->id;
    json_encode($header_nama);
    $data = DB::table('i_stock_mutasi')->leftjoin('m_item','m_item.i_code','=','i_stock_mutasi.sm_item')->where('sm_item','=',$request->id)->get();
    return view('inventory/stock_gudang/detailgudang',compact('data','header_nama', 'id'));
   }

	 public function filterdate(Request $request){
		 $startDate = Carbon::parse($request->startDate)->format('Y-m-d');
		 $endDate = Carbon::parse($request->endDate)->format('Y-m-d');


		 $data = DB::table('i_stock_mutasi')->leftjoin('m_item','m_item.i_code','=','i_stock_mutasi.sm_item')->where('sm_item','=',$request->id)
		 ->whereBetween('sm_insert', [$startDate, $endDate])->get();
		 return response()->json($data);
	 }
}
