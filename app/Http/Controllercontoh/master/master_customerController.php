<?php

namespace App\Http\Controllers\master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;

use App\mMember;
use App\Http\Controllers\logController;
class master_customerController extends Controller
{

    public function customer()
    {

      if (!mMember::akses('MASTER DATA CUSTOMER', 'aktif')) {
        return redirect('error-404');
      }

        $kode = DB::table('m_customer')->max('c_id');

            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }
        $index = str_pad($kode, 5, '0', STR_PAD_LEFT);
        $nota = 'MKT/'.$index;

        $kota_0 = DB::table('provinces')->get()->toArray();
        $kota_1 = DB::table('regencies')->get()->toArray();

        $kota = array_merge($kota_0,$kota_1);
        return view('master/customer/cust',compact('kota','nota'));
    }
    public function datatalble_customer(Request $request)
    {
    	$list = DB::select("SELECT * from m_customer");
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

    public function simpan_customer(Request $request)
    {      
      if (!mMember::akses('MASTER DATA CUSTOMER', 'tambah')) {
        return redirect('error-404');
      }
    	$kode = DB::table('m_customer')->max('c_id');

    		if ($kode == null) {
    	 		$kode = 1;
	    	}else{
	    	 	$kode += 1;
	    	}
	    $index = str_pad($kode, 5, '0', STR_PAD_LEFT);
	    $nota = 'MKT/'.$index;
	    $tanggal = date("Y-m-d h:i:s");
        $date = date_create($request->c_birthday);
        $date = date_format($date,"Y-m-d");

     	$data = DB::table('m_customer')
    			->insert([
                'c_id'=>$kode,
                'c_code'=>$nota,
                'c_name'=>$request->c_name,
                'c_company_name'=>$request->c_company_name,
                'c_address'=>$request->c_address,
                'c_email'=>$request->c_email,
                'c_phone'=>$request->c_phone,
                'c_phone_1'=>$request->c_phone_1,
                'c_type'=>$request->c_type,
                'c_creditterms'=>$request->c_creditterms,
                'c_plafon'=>$request->c_plafon,
                'c_npwp'=>$request->c_npwp,
                'c_accountnumber'=>$request->c_accountnumber,
                'c_bankname'=>$request->c_bankname,
                'c_hometown'=>$request->c_hometown,
                'c_birthday'=>$date,
                'c_information'=>$request->c_information,
                'c_insert'=>$tanggal,
    			]);
          logController::inputlog('Master Data Customer', 'Insert', $request->c_name);

    	return response()->json(['status'=>1]);
    }
    public function dataedit_customer(Request $request)
    {
      if (!mMember::akses('MASTER DATA CUSTOMER', 'ubah')) {
        return redirect('error-404');
      }
    	// dd($request->all());
    	$data = DB::table('m_customer')->where('c_code','=',$request->id)->get();
    	return response()->json($data);
    }
    public function update_customer(Request $request)
    {
      if (!mMember::akses('MASTER DATA CUSTOMER', 'ubah')) {
        return redirect('error-404');
      }
    	// dd($request->all());
        $tanggal = date("Y-m-d h:i:s");
    	$date = date_create($request->c_tgl);
        $date = date_format($date,"Y-m-d");

    	$data = DB::table('m_customer')
    			->where('c_code','=',$request->kode_old)
    			->update([
                'c_name'=>$request->c_name,
                'c_address'=>$request->c_address,
                'c_company_name'=>$request->c_company_name,
                'c_phone_1'=>$request->c_phone_1,
                'c_email'=>$request->c_email,
                'c_phone'=>$request->c_phone,
                'c_type'=>$request->c_type,
                'c_creditterms'=>$request->c_creditterms,
                'c_plafon'=>$request->c_plafon,
                'c_npwp'=>$request->c_npwp,
                'c_accountnumber'=>$request->c_accountnumber,
                'c_bankname'=>$request->c_bankname,
                'c_hometown'=>$request->c_hometown,
                'c_birthday'=>$date,
                'c_information'=>$request->c_information,
                'c_update'=>$tanggal,
    			]);

          logController::inputlog('Master Data Customer', 'Update', $request->c_name);

    	return response()->json(['status'=>1]);

    }
    public function hapus_customer(Request $request)
    {
      if (!mMember::akses('MASTER DATA CUSTOMER', 'hapus')) {
        return redirect('error-404');
      }
    	// dd($request->all());
      $data = DB::table('m_customer')->where('c_code','=',$request->id)->first();
    	DB::table('m_customer')->where('c_code','=',$request->id)->delete();
      logController::inputlog('Master Data Customer', 'Insert', $data->c_name);
    	return response()->json($data);
    }


}
