<?php

namespace App\Http\Controllers\Inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;
use Validator;
use Carbon\Carbon;
use App\mMember;
use App\Http\Controllers\logController;
class stockbarangController extends Controller
{
  public function index()
 {
   if (!mMember::akses('INPUT STOCK BARANG', 'aktif')) {
     return redirect('error-404');
   }
  $po = DB::table('d_purchaseorder')->where('po_status','=','F')->get();
  $item = DB::table('m_item')
          ->join('d_unit', 'u_id', '=', 'i_unit')
          ->leftjoin('i_stock_gudang', 'sg_iditem', '=', 'i_code')
          ->where('i_active', 'Y')
          ->get();          

  return view('inventory/stockbarang/stockbarang',compact("po", 'item'));
 }
 public function datatable_stockbarang()
 {
     $list = DB::select("SELECT * from i_stock_gudang left join m_item on m_item.i_code = i_stock_gudang.sg_iditem");
         // return $list;
     $data = collect($list);

     // for ($i=0; $i <count($data) ; $i++) {
     // 	$check_data_seq = DB::table('d_penerimaan_barang_dt')->where('pbdt_code','=',$data[$i]->pb_code)->get();
     // }

     // return $check_data_seq;
     // return $data;


     return Datatables::of($data)
             ->addColumn('detail', function ($data) {
                       // return '<button data-toggle="modal" onclick="detail(this)" title="Detail" class="btn btn-outline-primary icon-btn btn-rounded btn-sm"><i class="fa fa-folder"></i></button>
                       //         <button onclick="edit('.$data->sg_id.')" title="Edit" class="btn btn-outline-warning icon-btn btn-rounded btn-sm"><i class="fa fa-edit"></i></button>
                       //         <button onclick="hapus('.$data->sg_id.')" title="Hapus" class="btn btn-outline-danger btn-rounded icon-btn btn-sm"><i class="fa fa-trash"></i></button>';
                       return '<button data-toggle="modal" onclick="detail(this)" title="Detail" class="btn btn-outline-primary icon-btn btn-rounded btn-sm"><i class="fa fa-folder"></i></button>';
             // })
             })
             ->rawColumns(['aksi','detail','confirmed','status'])
         ->make(true);
 }

 public function autoitem(Request $request){
   if ($request->item == '') {
     return response()->json([
       'status' => 'kosong'
     ]);
   } else {
     $data = DB::table('m_item')
      ->join('d_unit', 'u_id', '=', 'i_unit')
      ->select('u_unit', 'i_price', 'i_price_currency')
      ->where("i_code", $request->item)
      ->get();

      return response()->json($data);
   }
 }

 public function simpan(Request $request){
   DB::beginTransaction();
   try {

     $validation = Validator::make($request->all(), [
              'item' => 'required',
              'qty' => 'required',
              'unit' => 'required',
              'price' => 'required',
          ]);

    if ($validation->fails()) {
        return response()->json([
          'status' => 'kesalahan'
        ]);
    } else {
      $id = DB::table('i_stock_gudang')
            ->max('sg_id');

        if ($id == null) {
          $id = 1;
        } else {
          $id += 1;
        }

        DB::table('i_stock_gudang')
          ->insert([
            'sg_id' => $id,
            'sg_iditem' => $request->item,
            'sg_qty' => $request->qty,
            'sg_harga' => $request->price,
            'sg_insert' => Carbon::now('Asia/Jakarta')
          ]);

          $detailid = DB::table('i_stock_mutasi')
                      ->where('sm_id', $id + 1)
                      ->max('sm_iddetail');

                      if ($detailid < 0) {
                          $detailid = 0;
                      }

          DB::table('i_stock_mutasi')
            ->insert([
              'sm_id' => $id,
              'sm_iddetail' => $detailid + 1,
              'sm_item' => $request->item,
              'sm_hpp' => $request->price,
              'sm_qty' => $request->qty,
              'sm_use' => 0,
              'sm_sisa' => $request->qty,
              'sm_description' => 'INPUT STOCK MANUAL',
              'sm_insert' => Carbon::now('Asia/Jakarta'),
            ]);

        logController::inputlog('Input Stock Barang', 'Insert', $request->item . ' ' . $request->qty);
        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
    }
   } catch (\Exception $e) {
     DB::rollback();
     return response()->json([
       'status' => 'gagal'
     ]);
   }
 }

 public function hapus(Request $request){
   DB::beginTransaction();
   try {

     $data = DB::table('i_stock_gudang')
              ->where('sg_id', $request->id)
              ->get();

     DB::table('i_stock_gudang')
        ->where('sg_id', $request->id)
        ->delete();

     DB::table('i_stock_mutasi')
        ->where('sm_item', $data[0]->sg_iditem)
        ->where('sm_qty', $data[0]->sg_qty)
        ->where('sm_description', 'INPUT STOCK MANUAL')
        ->delete();

        logController::inputlog('Input Stock Barang', 'Hapus', $data->sg_iditem);

     DB::commit();
     return response()->json([
       'status' => 'berhasil'
     ]);
   } catch (\Exception $e) {
     DB::rollback();
     return response()->json([
       'status' => 'gagal'
     ]);
   }

 }

 public function edit(Request $request){
   $data = DB::table('i_stock_gudang')
    ->join('m_item', 'i_code', '=', 'sg_iditem')
    ->join('d_unit', 'u_id', '=', 'i_unit')
    ->select('i_code', 'sg_harga', 'sg_qty')
    ->where('sg_id', $request->id)
    ->get();

    return response()->json($data);
 }

 public function update(Request $request){
   DB::beginTransaction();
   try {

     $validation = Validator::make($request->all(), [
              'itemedit' => 'required',
              'qty' => 'required',
              'unit' => 'required',
              'price' => 'required',
          ]);

    if ($validation->fails()) {
        return response()->json([
          'status' => 'kesalahan'
        ]);
    } else {

      $data = DB::table('i_stock_gudang')
               ->where('sg_id', $request->id)
               ->get();

      DB::table('i_stock_gudang')
        ->where('sg_id', $request->id)
        ->update([
          'sg_iditem' => $request->itemedit,
          'sg_qty' => $request->qty,
          'sg_harga' => $request->price,
          'sg_update' => Carbon::now('Asia/Jakarta')
        ]);

        DB::table('i_stock_mutasi')
           ->where('sm_item', $data[0]->sg_iditem)
           ->where('sm_qty', $data[0]->sg_qty)
           ->where('sm_description', 'INPUT STOCK MANUAL')
           ->delete();

           $id = DB::table('i_stock_mutasi')
                 ->max('sm_id');

                 if ($id < 0) {
                     $id = 0;
                 }

           $detailid = DB::table('i_stock_mutasi')
                       ->where('sm_id', $id + 1)
                       ->max('sm_iddetail');

                       if ($detailid < 0) {
                           $detailid = 0;
                       }

           DB::table('i_stock_mutasi')
             ->insert([
               'sm_id' => $id + 1,
               'sm_iddetail' => $detailid + 1,
               'sm_item' => $request->itemedit,
               'sm_hpp' => $request->price,
               'sm_qty' => $request->qty,
               'sm_use' => 0,
               'sm_sisa' => $request->qty,
               'sm_description' => 'INPUT STOCK MANUAL',
               'sm_insert' => Carbon::now('Asia/Jakarta'),
             ]);

             logController::inputlog('Input Stock Barang', 'Update', $request->itemedit);

      DB::commit();
      return response()->json([
        'status' => 'berhasil'
      ]);
    }
   } catch (\Exception $e) {
     DB::rollback();
     return response()->json([
       'status' => 'gagal'
     ]);
   }
 }

}
