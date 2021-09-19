<?php

namespace App\Http\Controllers\purchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;
use Carbon\Carbon;
use App\mMember;
use App\Http\Controllers\logController;
class request_orderController extends Controller
{
   public function rencanapembelian()
    {
      if (!mMember::akses('REQUEST ORDER', 'aktif')) {
        return redirect('error-404');
      }
        // return 'a';
        $kode = DB::table('d_requestorder')->max('ro_id');
            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }
        $index = str_pad($kode, 3, '0', STR_PAD_LEFT);
        $date = date('my');
        $nota = 'RO-'.$index.'/'.$date;

        $vendor = DB::table('m_vendor')->get();
        $item = DB::table('m_item')->leftjoin('m_currency','cu_code','=','i_price_currency')->leftjoin('i_stock_gudang','i_stock_gudang.sg_iditem','=','m_item.i_Code')->get();
        $list = DB::select("SELECT * from d_requestorder join m_vendor on d_requestorder.ro_vendor = m_vendor.s_kode");

        $need = 0;
        $approved = 0;
        for ($i=0; $i < count($list); $i++) {
          if ($list[$i]->ro_status_po == 'F' && $list[$i]->ro_status == 'F') {
            $need += 1;
          } else {
            $approved += 1;
          }
        }
        // return $item;
        return view('purchase/rencanapembelian/rencanapembelian',compact('vendor','item','nota', 'approved', 'need'));
    }
    public function datatable_rencanapembelian(Request $request)
    {
        // $list = DB::select("SELECT * from d_requestorder join m_vendor on d_requestorder.ro_vendor = m_vendor.s_kode");

        $list = DB::table('d_requestorder')
                    ->join('m_vendor', 'ro_vendor', '=', 's_kode')
                    ->select('ro_code', DB::raw('DATE_FORMAT(ro_insert, "%d-%m-%Y") as ro_insert'), 's_company', 'ro_qty', 'ro_qty_approved', 'ro_id', 'ro_status_po', 'ro_status')
                    ->orderBy('ro_id', 'DESC');


       // for ($i=0; $i <count($list) ; $i++) {
       //                  $code[$i] = $list[$i]->ro_code;
       //                  $true[$i] = DB::select("SELECT * from d_requestorder_dt where rodt_code = '$code[$i]' and rodt_status = 'F'");
       //              }
       //  for ($i=0; $i <count($true) ; $i++) {
       //      for ($j=0; $j <count($true[$i]) ; $j++) {
       //          $code[$i] = $true[$i][$j]->rodt_code;
       //              if ($true[$i] == null) {
       //                  $true_nested[$i] = 0;
       //              }else{
       //                  $true_nested[$i] = DB::select("SELECT * from d_requestorder_dt where rodt_code = '$code[$i]' and rodt_status = 'F'");
       //              }

       //              $lol[$i] = count($true_nested[$i]);
       //      }
       //  }
        // return $lol;

        return Datatables::of($list)

                ->addColumn('aksi', function ($list) {
                        if ($list->ro_status_po == 'F' && $list->ro_status == 'F') {                                                  
                            return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm" title="edit">'.
                                   '<label class="fa fa-pencil"></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-sm" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        }else{
                            return '<span class="badge badge-pill badge-danger">Disabled</span>';
                        }

                })

                ->addColumn('detail', function ($list) {
                    return '<button data-toggle="modal" onclick="detail(this)"  class="btn btn-outline-primary btn-sm">Detail</button>';
                })
                ->addColumn('status', function ($list) {
                  if ($list->ro_status_po == 'F' && $list->ro_status == 'F') {
                    return '<label class="badge badge-warning">Need Approved</label>';
                  } else {
                    return '<label class="badge badge-primary">Approved</label>';
                  }
                })
                ->rawColumns(['aksi','detail','confirmed','status'])
                ->make(true);
        }


    public function datatable_historypembelian(Request $request)
    {
        $list = DB::select("SELECT * from d_requestorder_dt join m_item on d_requestorder_dt.rodt_barang =  m_item.i_code where rodt_status = 'T'");

        $data = collect($list);

        // return $data;

        return Datatables::of($data)
        ->addColumn('status', function ($data) {
                    return '<span class="badge badge-pill badge-primary">Approved</span>';
                })
        ->rawColumns(['status','confirmed'])
        ->make(true);
    }


    public function kode_rencanapembelian(Request $request)
    {
        $kode = DB::table('d_requestorder')->max('ro_id');
            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }
        $index = str_pad($kode, 3, '0', STR_PAD_LEFT);
        $date = date('my');
        return $nota = 'RO-'.$index.'/'.$date;
        return response()->json($kode);
    }

    public function detail_rencanapembelian(Request $request)
    {
        $data = DB::table('d_requestorder_dt')->select('rodt_code','rodt_barang','rodt_price','rodt_qty','i_name','rodt_id','rodt_qty_approved','rodt_status')->leftjoin('m_item','m_item.i_code','=','d_requestorder_dt.rodt_barang')->where('rodt_code','=',$request->id)->orderBy('rodt_id','ASC')->get();
        return response()->json($data);
    }
    public function approve_rencanapembelian(Request $request)
    {
      if (!mMember::akses('REQUEST ORDER', 'tambah')) {
        return redirect('error-404');
      }

             // dd($request->all());

             $tanggal = date("Y-m-d h:i:s");

             for ($i=0; $i <count($request->kode) ; $i++) {

                if ($request->approved[$i] == 0) {
                    $approved[$i] = 0;
                    $status[$i] = 'F';
                }else{
                    $approved[$i] = $request->approved[$i];
                    $status[$i] = 'T';
                }
                $qty_sum[$i] =  array_sum($approved);


                $header = DB::table('d_requestorder')
                    ->where('ro_code','=',$request->kode[$i])
                    ->update([
                        'ro_qty_approved' =>$qty_sum[$i],
                        'ro_update' =>$tanggal,
                        'ro_status'=>'T',
                    ]);



                $qty_seq[$i] = str_replace('.','',$request->approved[$i]);


                $sequence[$i] = DB::table('d_requestorder_dt')
                ->where('rodt_code','=',$request->kode[$i])
                ->where('rodt_id','=',$request->kode_detail[$i])
                ->update([
                    'rodt_status' => $status[$i],
                    'rodt_qty_approved' => $qty_seq[$i],
                    'rodt_update' =>$tanggal,
                    'rodt_status' =>$status[$i],
                ]);

                logController::inputlog('Request Order', 'Approve', $request->kode[$i]);
            }
            return $sequence;

    }
    public function simpan_rencanapembelian(Request $request)
    {
      if (!mMember::akses('REQUEST ORDER', 'tambah')) {
        return redirect('error-404');
      }
            // dd($request->all());
            $kode = DB::table('d_requestorder')->max('ro_id');
                if ($kode == null) {
                    $kode = 1;
                }else{
                    $kode += 1;
                }

            $ro_price_header = str_replace('.','',$request->ro_total_header);
            $ro_price_header = str_replace('Rp ','',$ro_price_header);
            $ro_price_header = str_replace('$ ','',$ro_price_header);
            $ro_qty_header = str_replace('.','',$request->ro_qty_header);
            $ro_qty_header = str_replace('Rp ','',$ro_qty_header);
            $ro_qty_header = str_replace('$ ','',$ro_qty_header);
            $tanggal = date("Y-m-d h:i:s");

            $header = DB::table('d_requestorder')
                    ->insert([
                        'ro_id'    => $kode,
                        'ro_code' => $request->ro_code_header,
                        'ro_vendor' =>$request->ro_vendor_header,
                        'ro_price' =>$ro_price_header,
                        'ro_qty' =>$ro_qty_header,
                        'ro_qty_approved' => 0,
                        'ro_insert' =>$tanggal,
            ]);

            $kode_seq = 0;
            for ($i=0; $i < count($request->ro_item_seq); $i++) {
                $unit_price_seq[$i] = str_replace('.','',$request->ro_unit_price_seq[$i]);
                $unit_price_seq[$i] = str_replace('Rp ','',$unit_price_seq[$i]);
                $unit_price_seq[$i] = str_replace('$ ','',$unit_price_seq[$i]);
                $price_seq[$i] = str_replace('.','',$request->ro_price_seq[$i]);
                $price_seq[$i] = str_replace('Rp ','',$price_seq[$i]);
                $price_seq[$i] = str_replace('$ ','',$price_seq[$i]);
                $qty_seq[$i] = str_replace('.','',$request->ro_qty_seq[$i]);
                $qty_seq[$i] = str_replace('Rp ','',$qty_seq[$i]);
                $qty_seq[$i] = str_replace('$ ','',$qty_seq[$i]);

                $kode_seq = $kode_seq + 1;

                $sequence[$i] = DB::table('d_requestorder_dt')
                    ->insert([
                        'rodt_id'     => $kode_seq,
                        'rodt_code' => $request->ro_code_header,
                        'rodt_status' => 'F',
                        'rodt_barang' => $request->ro_item_seq[$i],
                        'rodt_qty' => $qty_seq[$i],
                        'rodt_qty_approved' => 0,
                        'rodt_price' =>$price_seq[$i],
                        'rodt_unit_price' =>$unit_price_seq[$i],
                        'rodt_insert' =>$tanggal,
                ]);
            }
            logController::inputlog('Request Order', 'Insert', $request->ro_code_header);

        return response()->json(['status'=>1]);
    }

    public function hapus_rencanapembelian(Request $request)
    {
      if (!mMember::akses('REQUEST ORDER', 'hapus')) {
        return redirect('error-404');
      }
        $hapus_header = DB::table('d_requestorder')->where('ro_code','=',$request->id)->where('ro_status_po','!=','T')->delete();
        $hapus_seq = DB::table('d_requestorder_dt')->where('rodt_code','=',$request->id)->where('rodt_status_po','!=','T')->delete();

        logController::inputlog('Request Order', 'Insert', $request->id);
        return response()->json(['status'=>1]);
    }

    public function edit_rencanapembelian(Request $request){
        $dataheader = DB::table('d_requestorder')
                    ->where('ro_code', $request->id)
                    ->get();

        for ($i=0; $i < count($dataheader); $i++) {
            $dataheader[$i]->ro_insert = Carbon::parse($dataheader[$i]->ro_insert)->format('d-m-Y');
        }

        $dataseq = DB::table('d_requestorder_dt')
                    ->leftjoin('m_item', 'i_code', '=', 'rodt_barang')
                    ->leftjoin('m_currency','cu_code','=','i_price_currency')
                    ->leftjoin('i_stock_gudang', 'sg_iditem', '=', 'rodt_barang')
                    ->where('rodt_code', $request->id)
                    ->get();

        return response()->json(['dataheader' => $dataheader,'dataseq' => $dataseq]);

    }

    public function update_rencanapembelian(Request $request){
        if (!mMember::akses('REQUEST ORDER', 'ubah')) {
            return redirect('error-404');
          }

          $hapus_header = DB::table('d_requestorder')->where('ro_code','=',$request->ro_code_header)->where('ro_status_po','!=','T')->get();
          $hapus_seq = DB::table('d_requestorder_dt')->where('rodt_code','=',$request->ro_code_header)->where('rodt_status_po','!=','T')->get();

          DB::table('d_requestorder')->where('ro_code','=',$request->ro_code_header)->where('ro_status_po','!=','T')->delete();
          DB::table('d_requestorder_dt')->where('rodt_code','=',$request->ro_code_header)->where('rodt_status_po','!=','T')->delete();

                // dd($request->all());
                $kode = DB::table('d_requestorder')->max('ro_id');
                    if ($kode == null) {
                        $kode = 1;
                    }else{
                        $kode += 1;
                    }

                $ro_price_header = str_replace('.','',$request->ro_total_header);
                $ro_price_header = str_replace('Rp ','',$ro_price_header);
                $ro_price_header = str_replace('$ ','',$ro_price_header);
                $ro_qty_header = str_replace('.','',$request->ro_qty_header);
                $ro_qty_header = str_replace('Rp ','',$ro_qty_header);
                $ro_qty_header = str_replace('$ ','',$ro_qty_header);
                $tanggal = date("Y-m-d h:i:s");

                $header = DB::table('d_requestorder')
                        ->insert([
                            'ro_id'    => $kode,
                            'ro_code' => $request->ro_code_header,
                            'ro_vendor' =>$request->ro_vendor_header,
                            'ro_price' =>$ro_price_header,
                            'ro_qty' =>$ro_qty_header,
                            'ro_qty_approved' => 0,
                            'ro_status_po' => $hapus_header[0]->ro_status_po,
                            'ro_status' => $hapus_header[0]->ro_status,
                            'ro_insert' =>$tanggal,
                ]);

                $kode_seq = 0;
                for ($i=0; $i < count($request->ro_item_seq); $i++) {
                    $unit_price_seq[$i] = str_replace('.','',$request->ro_unit_price_seq[$i]);
                    $unit_price_seq[$i] = str_replace('Rp ','',$unit_price_seq[$i]);
                    $unit_price_seq[$i] = str_replace('$ ','',$unit_price_seq[$i]);
                    $price_seq[$i] = str_replace('.','',$request->ro_price_seq[$i]);
                    $price_seq[$i] = str_replace('Rp ','',$price_seq[$i]);
                    $price_seq[$i] = str_replace('$ ','',$price_seq[$i]);
                    $qty_seq[$i] = str_replace('.','',$request->ro_qty_seq[$i]);
                    $qty_seq[$i] = str_replace('Rp ','',$qty_seq[$i]);
                    $qty_seq[$i] = str_replace('$ ','',$qty_seq[$i]);

                    $kode_seq = $kode_seq + 1;

                    $sequence[$i] = DB::table('d_requestorder_dt')
                        ->insert([
                            'rodt_id'     => $kode_seq,
                            'rodt_code' => $request->ro_code_header,
                            'rodt_barang' => $request->ro_item_seq[$i],
                            'rodt_qty' => $qty_seq[$i],
                            'rodt_qty_approved' => 0,
                            'rodt_price' =>$price_seq[$i],
                            'rodt_unit_price' =>$unit_price_seq[$i],
                            'rodt_status' => $hapus_header[0]->ro_status,
                            'rodt_status_po' => $hapus_header[0]->ro_status_po,
                            'rodt_insert' =>$tanggal,
                    ]);
                }
                logController::inputlog('Request Order', 'Update', $request->ro_code_header);

            return response()->json(['status'=>1]);
    }

}
