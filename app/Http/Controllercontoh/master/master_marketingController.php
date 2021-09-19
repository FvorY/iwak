<?php

namespace App\Http\Controllers\master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;
use App\mMember;
use App\Http\Controllers\logController;
class master_marketingController extends Controller
{

    public function marketing()
    {
        return view('quotation/marketing/marketing');
    }
    public function kode_marketing(Request $request)
    {
        $kode = DB::table('d_marketing')->max('mk_id');

            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }
        $index = str_pad($kode, 5, '0', STR_PAD_LEFT);
        $nota = 'MKT/'.$index;
        return response()->json($nota);
    }
    public function datatalble_marketing(Request $request)
    {
    	$list = DB::select("SELECT * from d_marketing");
        // return $data;
        $data = collect($list);
        return Datatables::of($data)
        		->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-info btn-lg" title="edit">'.
                                   '<label class="fa fa-pencil "></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['aksi', 'confirmed'])
        		->make(true);
    }

    public function simpan_marketing(Request $request)
    {
    	// dd($request->all());
    	$kode = DB::table('d_marketing')->max('mk_id');

            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }
	    $tanggal = date("Y-m-d h:i:s");

     	$data = DB::table('d_marketing')
    			->insert([
    			'mk_id'=> $kode,
    			'mk_code'=>$request->d_id,
    			'mk_information'=>$request->d_informasi,
    			'mk_name'=>$request->d_name,
    			'mk_address'=>$request->d_address,
    			'mk_email'=>$request->d_email,
                'mk_phone'=>$request->d_tlp,
    			'mk_type'=>$request->d_tipe,
    			]);

    	return response()->json(['status'=>1]);
    }
    public function dataedit_marketing(Request $request)
    {
    	// dd($request->all());
    	$data = DB::table('d_marketing')->where('mk_code','=',$request->id)->get();
    	return response()->json($data);
    }
    public function update_marketing(Request $request)
    {
    	// dd($request->all());

    	$data = DB::table('d_marketing')
    			->where('mk_code','=',$request->kode_old)
    			->update([
                'mk_information'=>$request->d_informasi,
                'mk_name'=>$request->d_name,
                'mk_address'=>$request->d_address,
                'mk_email'=>$request->d_email,
                'mk_phone'=>$request->d_tlp,
                'mk_type'=>$request->d_tipe,
    			]);

    	return response()->json(['status'=>1]);

    }
    public function hapus_marketing(Request $request)
    {
    	// dd($request->all());
    	$data = DB::table('d_marketing')->where('mk_code','=',$request->id)->delete();
    	return response()->json($data);
    }


}
