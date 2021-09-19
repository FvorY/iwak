<?php

namespace App\Http\Controllers\master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;
use App\mMember;
use App\Http\Controllers\logController;
class master_NpenawaranController extends Controller
{

 	public function n_penawaran()
 	{
 		// return 'a';
 		$item = DB::table('m_item')->select('i_code','i_name','i_price')->get();
 		$marketing = DB::table('d_marketing')->select('mk_code','mk_name')->get();
 		$bundle = DB::table('m_item_bundling')->select('ib_item','ib_price')->get();

 		return view('quotation/n_penawaran/n_penawaran',compact('item','marketing','bundle'));
 	}
 	public function datatable_Npenawaran()
 	{
 		$list = DB::select("SELECT * from d_npenawaran left join m_item on m_item.i_code = d_npenawaran.np_kodeitem left join d_marketing on d_marketing.mk_code = d_npenawaran.np_marketing ");
        // return $list;
        $data = collect($list);

        // return $data;

        return Datatables::of($data)
        		->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-info btn-lg" title="edit">'.
                                   '<label class="fa fa-pencil "></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                })
                ->addColumn('item', function ($data) {
                    return $data->i_code.'  -   '.$data->i_name;
                })
                ->addColumn('marketing', function ($data) {
                    return $data->mk_code.'  -   '.$data->mk_name;
                })
                ->rawColumns(['aksi', 'confirmed'])
        		->make(true);
 	}
 	public function simpan_Npenawaran(Request $request)
 	{
 		// dd($request->all());
 		$kode = DB::table('d_npenawaran')->max('np_id');
	    $tanggal = date("Y-m-d h:i:s");

 		for ($i=0; $i <count($request->item_kode) ; $i++) {
 			if ($kode == null) {
    	 		$kode = 1;
	    	}else{
	    	 	$kode += 1;
	    	}
			$index = str_pad($kode, 5, '0', STR_PAD_LEFT);
		    $nota = 'NPN/'.$index;
	    	$price[$i] = str_replace('.','',$request->item_price[$i]);
	    	$low_price[$i] = str_replace('.','',$request->item_lowerprice[$i]);

			$data = DB::table('d_npenawaran')
					->insert([
						'np_id'	 => $kode,
						'np_kode' => $nota,
						'np_kodeitem' =>$request->item_kode[$i],
						'np_marketing' =>$request->d_marketing,
						'np_price' =>$low_price[$i],
						'np_lowerlimit' =>$price[$i],
						'np_insert' =>$tanggal,
						'np_flag' =>$request->item_flag[$i],
					]);
 		}
 		return response()->json($data);
 	}
 	public function update_Npenawaran(Request $request)
 	{
 		// dd($request->all());
 		$kode = DB::table('d_npenawaran')->max('np_id');
	    $tanggal = date("Y-m-d h:i:s");


 			if ($kode == null) {
    	 		$kode = 1;
	    	}else{
	    	 	$kode += 1;
	    	}
			$index = str_pad($kode, 5, '0', STR_PAD_LEFT);
		    $nota = 'NPN/'.$index;
	    	$price = str_replace('.','',$request->d_price);
	    	$low_price = str_replace('.','',$request->d_lowerprice);

			$data = DB::table('d_npenawaran')
					->where('np_kode',$request->kode_old)
					->update([
						'np_kodeitem' =>$request->d_itemname,
						'np_marketing' =>$request->d_marketing,
						'np_price' =>$price,
						'np_lowerlimit' =>$low_price,
						'np_update' =>$tanggal,
					]);

 		return response()->json($data);
 	}
 	public function dataedit_Npenawaran(Request $request)
 	{
 		$data = DB::table('d_npenawaran')->where('np_kode','=',$request->id)->get();
    	return response()->json($data);
 	}
 	public function hapus_Npenawaran(Request $request)
 	{
 		// dd($request->all());
 		$data = DB::table('d_npenawaran')->where('np_kode','=',$request->id)->delete();
    	return response()->json($data);
 	}
}
