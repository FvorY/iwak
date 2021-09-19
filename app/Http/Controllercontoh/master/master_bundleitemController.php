<?php

namespace App\Http\Controllers\master;
use App\Http\Controllers\Controller;
use Illuminate\Http\request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;
use Response;
use Carbon\carbon;
use Auth;
use App\Http\Controllers\logController;
use App\mMember;
set_time_limit(60000);
class master_bundleitemController extends Controller
{



 	public function bundleitem()
 	{

    if (!mMember::akses('MASTER DATA BUNDLE ITEM', 'aktif')) {
      return redirect('error-404');
    }

    $item = DB::table('m_item')->where('i_jenis','=','Barang Jual')->get();
 		$currency = DB::table('m_currency')->where('cu_value','!=',null)->get();

 		return view('master/bundle/bundle',compact('item','currency'));
 	}
 	public function datatable_bundleitem()
 	{
 		$list = DB::table('m_item')
 				  ->where('i_jenis','BUNDLE')
 				  ->get();
        $data = collect($list);
        // return $data;
        return Datatables::of($data)

                ->addColumn('aksi', function ($data) {
                          $a =  '<div class="btn-group">';

                            if(Auth::user()->akses('MASTER DATA BUNDLE ITEM','ubah')){
                             $b = '<button type="button" onclick="edit(\''.$data->i_id.'\')" class="btn btn-primary btn-lg" title="edit">'.'<label class="fa fa-pencil "></label></button>';
                            }else{
                              $b = '';
                            }

                            if(Auth::user()->akses('MASTER DATA BUNDLE ITEM','hapus')){
                             $d =
                                 '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'.
                                 '<label class="fa fa-trash"></label></button>';
                            }else{
                              $d = '';
                            }


                            $e = '</div>';

                        return $a . $b  . $d .$e ;
                })
                ->addColumn('dollars', function ($data) {
                    $harga = 0;

                    $currenncy = DB::table('m_currency')
                                 ->where('cu_code', 'USD')
                                 ->first();

                    if($currenncy && $currenncy->cu_value > 0){
                      $harga = $data->i_price / $currenncy->cu_value;
                    }

                    return number_format($harga, 2);
                })
                ->addColumn('convert', function ($data) {

                    $harga = 0;

                    if ($data->i_price_currency == 'idr') {
                      return $total = $data->i_price * 1;
                    }else{
                      $currenncy = DB::table('m_currency')
                                   ->where('cu_code',$data->i_price_currency)
                                   ->first();
                      return $total = $data->i_price * $currenncy->cu_value;
                    }


                    return $harga;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi','confirmed','convert'])
        		    ->make(true);
 	}
 	public function edit_bundle($id)
 	{
    if (!mMember::akses('MASTER DATA BUNDLE ITEM', 'ubah')) {
      return redirect('error-404');
    }
 		$data = DB::table("m_item")
              ->where('i_id',$id)
              ->first();
    $currency = DB::table('m_currency')->where('cu_value','!=',null)->get();

    $data_dt = DB::table('m_item_dt')
                  ->join('m_item','i_code','=','id_item')
                  ->leftjoin('m_currency','i_price_currency','=','cu_code')
                  ->where('id_id',$id)
                  ->get();


    $item = DB::table('m_item')->where('i_jenis','=','Barang Jual')->get();

 		return view('master/bundle/edit_bundle',compact('data','data_dt','item','id','currency'));
 	}
 	public function cari_item(request $req)
 	{
 		$data = DB::table('m_item')
          ->join('d_unit','u_id','=','i_unit')
          ->leftjoin('m_currency','cu_code','=','i_price_currency')
 				  ->where('i_code',$req->kode)
 				  ->first();

 		return Response::json(['data'=>$data]);

 	}
 	public function simpan_bundleitem(request $req)
 	{
    if (!mMember::akses('MASTER DATA BUNDLE ITEM', 'tambah')) {
      return redirect('error-404');
    }
    	return DB::transaction(function() use ($req) {
        $nama = Auth::user()->m_name;
        $m1 = DB::table('m_item')->where('i_jenis','BUNDLE')->max('i_id');
        $index = DB::table('m_item')->max('i_id')+1;

        // dd($req->all());

        if($index<=9)
        {
            $id_auto = 'BND/000'.$index;
        }
        else if($index<=99)
        {
            $id_auto = 'BND/00'.$index;
        }
        else if($index<=999)
        {
            $id_auto = 'BND/0'.$index;
        }
        else {
            $id_auto = 'BND/'.$index;
        }

        $save = DB::table('m_item')->insert([
                  'i_id'          =>  $index,
                  'i_code'        =>  $id_auto,
                  'i_name'        =>  $req->ib_name,
                  'i_unit'        =>  4,
                  'i_price'       =>  $req->ib_price,
                  'i_sell_price'  =>  $req->sell_price,
                  'i_lower_price' =>  $req->lower_price,
                  'i_active'      =>  'Y',
                  'i_jenis'       =>  'BUNDLE',
                  'i_type'        =>  0,
                  'i_minstock'    =>  0,
                  'i_image'       =>  0,
                  'i_weight'      =>  0,
                  'i_description' =>  $req->keterangan,
                  'i_price_currency' =>  $req->m_currency,
                  'i_insert_at'   =>  Carbon::now(),
                  'i_update_at'   =>  Carbon::now(),
                  'i_insert_by'   =>  $nama,
                  'i_update_by'   =>  $nama,
              ]);

        for ($i=0; $i < count($req->ib_kode_dt); $i++) {
          $dt = DB::table('m_item_dt')->max('id_id')+1;

          $item = DB::table('m_item')->where('i_code', $req->ib_kode_dt[$i])->first();

          if($item){

            $save = DB::table('m_item_dt')->insert([
                  'id_id'           =>  $index,
                  'id_detailid'     =>  $i+1,
                  'id_item'         =>  $req->ib_kode_dt[$i],
                  'id_unit'         =>  $req->ib_unit_dt[$i],
                  'id_qty'          =>  $req->ib_qty_dt[$i],
                  'id_price_unit'   =>  $item->i_price,
                  'id_total_price'  =>  $item->i_price * $req->ib_qty_dt[$i],
                  'id_insert_at'    =>  Carbon::now(),
                  'id_update_at'    =>  Carbon::now(),
                  'id_insert_by'    =>  $nama,
                  'id_update_by'    =>  $nama,
                ]);

          }
        }

        logController::inputlog('Master Bundle Item', 'Insert', $req->ib_name);
        // dd($save);
        return Response::json(['status'=>1]);
    	});
 	}
 	public function update_bundleitem(request $req)
 	{
    if (!mMember::akses('MASTER DATA BUNDLE ITEM', 'ubah')) {
      return redirect('error-404');
    }
 		return DB::transaction(function() use ($req) {
    		// dd($req->all());

        $nama = Auth::user()->m_name;
        $save = DB::table('m_item')->where('i_id',$req->id)->update([
                  'i_name'        =>  $req->ib_name,
                  'i_unit'        =>  4,
                  'i_price'       =>  $req->ib_price,
                  'i_sell_price'  =>  $req->sell_price,
                  'i_lower_price' =>  $req->lower_price,
                  'i_active'      =>  'Y',
                  'i_jenis'       =>  'BUNDLE',
                  'i_type'        =>  0,
                  'i_minstock'    =>  0,
                  'i_image'       =>  0,
                  'i_weight'      =>  0,
                  'i_description' =>  $req->keterangan,
                  'i_price_currency' =>  $req->m_currency,
                  'i_update_at'   =>  Carbon::now(),
                  'i_update_by'   =>  $nama,
              ]);

              logController::inputlog('Master Bundle Item', 'Update', $req->ib_name);

        $dt = DB::table('m_item_dt')->where('id_id',$req->id)->delete();
        // dd($dt);
        for ($i=0; $i < count($req->ib_kode_dt); $i++) {

          $save = DB::table('m_item_dt')->insert([
                  'id_id'           =>  $req->id,
                  'id_detailid'     =>  $i+1,
                  'id_item'         =>  $req->ib_kode_dt[$i],
                  'id_unit'         =>  $req->ib_unit_dt[$i],
                  'id_qty'          =>  $req->ib_qty_dt[$i],
                  'id_price_unit'   =>  $req->ib_price_dt[$i],
                  'id_total_price'  =>  $req->ib_total_price[$i],
                  'id_insert_at'    =>  Carbon::now(),
                  'id_update_at'    =>  Carbon::now(),
                  'id_insert_by'    =>  $nama,
                  'id_update_by'    =>  $nama,
                ]);
        }
        return Response::json(['status'=>1]);
    });
 	}
 	public function dataedit_bundleitem(request $req)
 	{
 		$data_head = DB::table('m_item')->where('m_id','=',$req->id)->get();
 		$data_seq = DB::table('m_item_dt')->where('id_id','=',$req->id)->get();
 		$item = DB::table('m_item')->select('i_code','i_name','i_price')->get();
 		return response()->json([$data_head,$data_seq]);
    	// return view('master/bundle/ajax_update',compact('item','data_head','data_seq'));
 	}
 	public function detail_bundleitem(request $req)
 	{
 		$data = DB::table('m_item_dt')->join('m_item','m_item.i_code','=','m_item_dt.ibd_barang')->where('i_id','=',$req->id)->get();
    	return response()->json($data);
 	}
 	public function hapus_bundleitem(request $req)
 	{
 		// dd($req->all());
    $data_head = DB::table('m_item')->where('i_code','=',$req->id)->first();
 		DB::table('m_item')->where('i_code','=',$req->id)->delete();
    logController::inputlog('Master Bundle Item', 'Insert', $data_head->i_name);
    	return response()->json(['status'=>1]);
 	}

  public function sinkron_bundle()
  {
    // $data = DB::table('m_item')
    //           ->where('i_jenis','BUNDLE')
    //           ->orderBy('i_id','ASC')
    //           ->get();

    // $dt = DB::table('m_item')
    //           ->join('m_item_dt','id_id','=','i_id')
    //           ->where('i_jenis','BUNDLE')
    //           ->get();

    // for ($i=0; $i < count($data); $i++) {
    //   $harga = 0;
    //   for ($a=0; $a < count($dt); $a++) {
    //     if ($dt[$a]->i_id == $data[$i]->i_id) {
    //       $harga += $dt[$a]->id_total_price;
    //     }
    //   }
    //   $tes = DB::table('m_item')
    //           ->where('i_id',$data[$i]->i_id)
    //           ->update([
    //             'i_price' => $harga,
    //             'i_sell_price' => $harga,
    //             'i_lower_price' => $harga,
    //           ]);


    // }
  }
}
