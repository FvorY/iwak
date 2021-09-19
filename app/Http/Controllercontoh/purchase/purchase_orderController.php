<?php

namespace App\Http\Controllers\purchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;
use App\mMember;
use App\Http\Controllers\logController;
class purchase_orderController extends Controller
{
  	public function purchaseorder()
    {
      if (!mMember::akses('PURCHASE ORDER', 'aktif')) {
        return redirect('error-404');
      }
    	$vendor = DB::table('m_vendor')->get();
      $item = DB::table('m_item')->get();
      $ro = DB::table('d_requestorder')->join('m_vendor', 's_kode', '=', 'ro_vendor')->where('ro_status_po','=','F')->where('ro_status','=','T')->get();

      $process = DB::table('d_purchaseorder')
                ->where('po_status', 'F')
                ->where('po_print', 'F')
                ->count();

      $printed = DB::table('d_purchaseorder')
                    ->where('po_status', 'T')
                    ->where('po_print', 'T')
                    ->count();

    	return view('purchase/purchaseorder/purchaseorder',compact('vendor','item', 'ro', 'process', 'printed'));
    }
    public function datatable_purchaseorder()
    {
      $list = DB::select("SELECT * from d_purchaseorder left join m_vendor on m_vendor.s_kode = d_purchaseorder.po_vendor");
          // return $list;
      $data = collect($list);

      // return $data;

      return Datatables::of($data)

              ->addColumn('aksi', function ($data) {
                        if ($data->po_print == 'T' or $data->po_status == 'T') {
                            return '<div class="btn-group">'.
                                   '<button type="button" onclick="print(this)" class="btn btn-primary btn-sm" title="Print">'.
                                   '<label class="fa fa-print"></label></button>'.
                                  '</div>';
                        }else{
                            return '<div class="btn-group">'.
                                   '<button type="button" onclick="print(this)" class="btn btn-primary btn-sm" title="Print">'.
                                   '<label class="fa fa-print"></label></button>'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-info btn-sm" title="edit">'.
                                   '<label class="fa fa-pencil "></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-sm" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        }
              })
              ->addColumn('detail', function ($data) {

                  return '<button data-toggle="modal" onclick="detail(this)"  class="btn btn-outline-primary btn-sm">Detail</button>';
              })
              ->addColumn('status', function ($data) {
                  if ($data->po_print == 'T' or $data->po_status == 'T') {
                    return '<span class="badge badge-info badge-pill">Printed</span>';
                  } else {
                    return '<span class="badge badge-warning badge-pill">Process</span>';
                  }
              })
              ->rawColumns(['aksi','detail','confirmed','status'])
          ->make(true);
    }
   	public function cari_ro_purchaseorder(Request $request)
   	{
   		$data = DB::table('d_requestorder')->where('ro_status_po','=','F')->where('ro_status','=','T')->where('ro_vendor','=',$request->cari_vendor)->get();

   		return response()->json($data);
   	}
   	public function cari_po_purchaseorder(Request $request)
   	{

            $no_ro = [];
            $ro = $request->check;
            for ($i=0; $i < count($request->check); $i++) {
              $no_ro = $request->check[$i];
              $data_header = DB::table('d_requestorder')
                            ->leftjoin('m_vendor','m_vendor.s_kode','=','d_requestorder.ro_vendor')
                            ->where('ro_status_po','=','F')
                            ->where('ro_status','=','T')
                            ->where('ro_code','=',$request->check[$i])
                            ->first();

              $no_vendor = $data_header->ro_vendor;

            json_encode($data_header);
            }

            $data_seq = DB::table('d_requestorder_dt')
                            ->join('m_item','m_item.i_code','=','d_requestorder_dt.rodt_barang')
                            ->leftjoin('d_unit', 'u_id', '=', 'i_unit')
                            ->where('rodt_status_po','=','F')
                            ->where('rodt_status','=','T')
                            ->whereIn('rodt_code',$request->check)
                            ->orderBy('rodt_code')
                            ->get();


            $kode = DB::table('d_purchaseorder')->max('po_id');
                  if ($kode == null) {
                      $kode = 1;
                  }else{
                      $kode += 1;
                  }

            $index = str_pad($kode, 3, '0', STR_PAD_LEFT);
            $date = date('my');
            $nota = 'PO-'.$index.'/'.$request->vendor[0].'/'.$date;

            $item = DB::table('m_item')->leftjoin('d_unit', 'u_id', '=', 'i_unit')->leftjoin('i_stock_gudang','i_stock_gudang.sg_iditem','=','m_item.i_Code')->get();

            return view('purchase/purchaseorder/create_purchaseorder',compact('ro','data_header','data_seq','vendor','nota','no_ro','no_vendor','item'));
      }

    public function detail_purchaseorder(Request $request)
    {
      // dd($request->all());
      $data = DB::table('d_purchaseorder_dt')->where('podt_code','=',$request->id)->join('m_item','m_item.i_code','=','d_purchaseorder_dt.podt_item')->get();
      return response()->json($data);
    }
    public function edit_purchaseorder(Request $request)
    {
      if (!mMember::akses('PURCHASE ORDER', 'ubah')) {
        return redirect('error-404');
      }
      $data = DB::table('d_purchaseorder')
                ->join('d_requestorder', 'ro_code', '=', 'po_nomor_ro')
                ->join('m_vendor', 's_kode', '=', 'ro_vendor')
                ->where('po_code', $request->id)
                ->get();

      $item = DB::table('m_item')->leftjoin('d_unit', 'u_id', '=', 'i_unit')->leftjoin('i_stock_gudang','i_stock_gudang.sg_iditem','=','m_item.i_Code')->get();

      $data_seq = DB::table('d_purchaseorder_dt')
                    ->join('m_item','m_item.i_code','=','podt_item')
                    ->leftjoin('d_unit', 'u_id', '=', 'i_unit')
                    ->where('podt_code', $data[0]->po_code)
                    ->get();

    return view('purchase.purchaseorder.edit_purchaseorder', compact('data', 'item', 'data_seq'));
    }
    public function save_purchaseorder(Request $request)
    {
      if (!mMember::akses('PURCHASE ORDER', 'tambah')) {
        return redirect('error-404');
      }

      // return json_encode($request->all());
      // dd($request->all());
      $tanggal = date("Y-m-d h:i:s");
      $kode = DB::table('d_purchaseorder')->max('po_id');
            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }

        $po_subtotal = str_replace('.','',$request->po_subtotal);
        $total_net = str_replace('.','',$request->total_net);
        $po_tax = str_replace('.','',$request->po_tax);

        $data_header = DB::table('d_purchaseorder')
                        ->insert([
                          'po_id'=>$kode,
                          'po_code'=>$request->po_nopo,
                          'po_nomor_ro'=>$request->po_noro,
                          'po_date'=>date('Y-m-d',strtotime($request->po_date)),
                          'po_shipping_method'=>$request->po_shipping_method,
                          'po_shipping_term'=>$request->po_shipping_term,
                          'po_delivery_date'=>date('Y-m-d',strtotime($request->po_shipping_date)),
                          'po_shipping_to'=>$request->po_shipping_to,
                          'po_subtotal'=>$po_subtotal,
                          'po_sales_tax'=>$po_tax,
                          'po_total_net'=>$total_net,
                          'po_insert'=>$tanggal,
                          'po_vendor'=>$request->vedor_ro,
                        ]);

      $kode_seq = 0;
      for ($i=0; $i <count($request->podt_barang) ; $i++) {
        $kode_seq = $kode_seq + 1;

        $podt_barang[$i] = str_replace('.','',$request->podt_barang[$i]);
        $podt_price[$i] = str_replace('.','',$request->podt_price[$i]);
        $podt_unit_price[$i] = str_replace('.','',$request->podt_unit_price[$i]);
        $podt_qty[$i] = str_replace('.','',$request->podt_qty[$i]);

        $data_sequence = DB::table('d_purchaseorder_dt')
                        ->insert([
                          'podt_id'=>$kode_seq,
                          'podt_code'=>$request->po_nopo,
                          'podt_item'=>$podt_barang[$i],
                          'podt_price'=>$podt_price[$i],
                          'podt_tax' => $request->nilai_ppn[$i],
                          'podt_unit_price'=>$podt_unit_price[$i],
                          'podt_qty_approved'=>$podt_qty[$i],
                          'podt_insert'=>$tanggal,
                        ]);

        $request_sequence = DB::table('d_requestorder_dt')
                        ->where('rodt_code','=',$request->nomor_ro)
                        ->update([
                          'rodt_status_po'=>'T',
                        ]);

      }

      $request_header = DB::table('d_requestorder')
                        ->where('ro_code','=',$request->nomor_ro)
                        ->update([
                          'ro_status_po'=>'T',
                        ]);

                        logController::inputlog('Purchase Order', 'Insert', $request->po_nopo);

      return response()->json(['status'=>1]);
    }
    public function hapus_purchaseorder(Request $request)
    {
      if (!mMember::akses('PURCHASE ORDER', 'hapus')) {
        return redirect('error-404');
      }

      $hapus_header = DB::table('d_purchaseorder')->where('po_code','=',$request->id)->delete();
      $hapus_seq = DB::table('d_purchaseorder_dt')->where('podt_code','=',$request->id)->delete();

      logController::inputlog('Purchase Order', 'Hapus', $request->id);

      return response()->json(['status'=>1]);
    }
    public function print_purchaseorder(Request $request)
    {
      if (!mMember::akses('PURCHASE ORDER', 'print')) {
        return redirect('error-404');
      }

      // Tambahan Dirga
        $isPusat = (modulSetting()['id_pusat'] == modulSetting()['onLogin']) ? null : modulSetting()['onLogin'];
        $dataPO = DB::table('d_purchaseorder')
                    ->join('m_vendor', 'm_vendor.s_kode', '=', 'd_purchaseorder.po_vendor')
                    ->where('po_code', $request->id)
                    ->select('s_id')
                    ->first();

        $akunHutang = DB::table('dk_akun')
                                    ->where('ak_id', function($query) use ($isPusat){
                                      $query->select('ap_akun')
                                                ->from('dk_akun_penting')
                                                ->where('ap_nama', 'Hutang Usaha')->where('ap_comp', $isPusat)->first();
                                    })->first();

        if(!$akunHutang || $akunHutang->ak_id == null)
          return 'error';

        $id = (DB::table('dk_payable')->max('py_id') + 1);

        if(!DB::table('dk_payable')->where('py_ref_nomor', $request->id)){
            DB::table('dk_payable')->insert([
              "py_id"               => $id,
              "py_comp"             => modulSetting()['onLogin'],
              "py_nomor"            => 'RC-'.date('y/d/m').'/'.str_pad($id, 3, "0", STR_PAD_RIGHT),
              "py_chanel"           => 'Hutang Supplier',
              "py_ref_nomor"        => $request->id,
              "py_kreditur"         => $dataPO->s_id,
              "py_tanggal"          => date('Y-m-d'),
              "py_total_tagihan"    => 0,
              "py_sudah_dibayar"    => 0,
              "py_akun_hutang"      => $akunHutang->ak_id,
              "py_due_date"          => date('Y-m-d', strtotime("+14 days"))
          ]);
        }

      // Selesai Dirga

      DB::table('d_purchaseorder')->where('po_code','=',$request->id)->update(['po_print'=>'T']);

      $print_header = DB::table('d_purchaseorder')->where('po_code','=',$request->id)->leftjoin('m_vendor','m_vendor.s_kode','=','d_purchaseorder.po_vendor')->first();
      json_encode($print_header);
      $print_seq = DB::table('d_purchaseorder_dt')->where('podt_code','=',$request->id)->leftjoin('m_item','m_item.i_code','=','d_purchaseorder_dt.podt_item')->leftjoin('d_unit', 'u_id', '=', 'i_unit')->get();

      logController::inputlog('Purchase Order', 'Print', $request->id);

      return view('purchase/purchaseorder/print_purchaseorder',compact('print_header','print_seq'));
    }

    public function validation(Request $request){
      $data = DB::table('d_requestorder')
                ->whereIn('ro_code', $request->favorite)
                ->select('ro_vendor')
                ->get();

      $tmp = [];
      for ($i=0; $i < count($data); $i++) {
        $tmp[] = $data[$i]->ro_vendor;
      }

      $countdata = count($data);

      $counttmp = array_count_values($tmp);

      for ($i=0; $i < count($request->favorite); $i++) {
        $data1 = DB::table('d_requestorder')
                  ->where('ro_code', $request->favorite[$i])
                  ->select('ro_vendor')
                  ->get();

        $temp = $data1[0]->ro_vendor;

        $hasil = $counttmp["".$temp.""];

        if ($hasil == 0) {

        } else {
          if ($hasil == $countdata) {
            return response()->json([
              'status' => 'sama'
            ]);
          } else {
            return response()->json([
              'status' => 'tidak'
            ]);
            break;
          }
        }
      }
    }

    function array_is_unique($array){
      return array_unique($array) == $array;
    }

    public function update(Request $request){
      if (!mMember::akses('PURCHASE ORDER', 'ubah')) {
        return redirect('error-404');
      }
      DB::table('d_purchaseorder')
            ->where('po_code', $request->po_nopo)
            ->delete();

      DB::table('d_purchaseorder_dt')
            ->where('podt_code', $request->po_nopo)
            ->delete();

      $tanggal = date("Y-m-d h:i:s");
      $kode = DB::table('d_purchaseorder')->max('po_id');
            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }

        $po_subtotal = str_replace('.','',$request->po_subtotal);
        $total_net = str_replace('.','',$request->total_net);
        $po_tax = str_replace('.','',$request->po_tax);

        $data_header = DB::table('d_purchaseorder')
                        ->insert([
                          'po_id'=>$kode,
                          'po_code'=>$request->po_nopo,
                          'po_nomor_ro'=>$request->po_noro,
                          'po_date'=>date('Y-m-d',strtotime($request->po_date)),
                          'po_shipping_method'=>$request->po_shipping_method,
                          'po_shipping_term'=>$request->po_shipping_term,
                          'po_delivery_date'=>date('Y-m-d',strtotime($request->po_shipping_date)),
                          'po_shipping_to'=>$request->po_shipping_to,
                          'po_subtotal'=>$po_subtotal,
                          'po_sales_tax'=>$po_tax,
                          'po_total_net'=>$total_net,
                          'po_insert'=>$tanggal,
                          'po_vendor'=>$request->vedor_ro,
                        ]);

      $kode_seq = 0;
      for ($i=0; $i <count($request->podt_barang) ; $i++) {
        $kode_seq = $kode_seq + 1;

        $podt_barang[$i] = str_replace('.','',$request->podt_barang[$i]);
        $podt_price[$i] = str_replace('.','',$request->podt_price[$i]);
        $podt_unit_price[$i] = str_replace('.','',$request->podt_unit_price[$i]);
        $podt_qty[$i] = str_replace('.','',$request->podt_qty[$i]);

        $data_sequence = DB::table('d_purchaseorder_dt')
                        ->insert([
                          'podt_id'=>$kode_seq,
                          'podt_code'=>$request->po_nopo,
                          'podt_item'=>$podt_barang[$i],
                          'podt_price'=>$podt_price[$i],
                          'podt_unit_price'=>$podt_unit_price[$i],
                          'podt_qty_approved'=>$podt_qty[$i],
                          'podt_insert'=>$tanggal,
                        ]);

        $request_sequence = DB::table('d_requestorder_dt')
                        ->where('rodt_code','=',$request->nomor_ro)
                        ->update([
                          'rodt_status_po'=>'T',
                        ]);

      }

      $request_header = DB::table('d_requestorder')
                        ->where('ro_code','=',$request->nomor_ro)
                        ->update([
                          'ro_status_po'=>'T',
                        ]);

                        logController::inputlog('Purchase Order', 'Update', $request->po_nopo);

      return response()->json(['status'=>1]);
    }

}
