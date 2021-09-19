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
use App\mMember;
use App\Http\Controllers\logController;
class currency_controller extends Controller
{
    public function index()
    {
      if (!mMember::akses('MASTER CURRENCY', 'aktif')) {
        return redirect('error-404');
      }
    	$currency = DB::table('m_currency')
    				  ->select('cu_code')
    				  ->get();
    	return view('master.currency.currency',compact('currency'));
    }

    public function datatable_currency()
    {
    	$data = DB::table('m_currency')
    			  ->where('cu_value','!=',null)
                  ->get();


        // return $data;
                  
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                           $a =  '<div class="btn-group">';

                            if(Auth::user()->akses('QUOTATION','ubah')){
                             $b = '<button type="button" onclick="edit(\''.$data->cu_code.'\')" class="btn btn-primary btn-lg" title="edit">'.'<label class="fa fa-pencil "></label></button>';
                            }else{
                              $b = '';
                            }

                        	return $a . $b ;



                        })
                        ->addColumn('total', function ($data) {
                            return $data->cu_value;
                        })
                        ->rawColumns(['aksi','total'])
                        ->addIndexColumn()
                        ->make(true);
    }
    public function auto_complete(request $req)
    {
    	$data = DB::table('m_currency')
    				  ->where('cu_code',$req->id)
    				  ->first();
    	return Response::json(['data'=>$data]);
    }

    public function save(request $req)
    {
      if (!mMember::akses('MASTER CURRENCY', 'ubah')) {
        return redirect('error-404');
      }
    	$update = DB::table('m_currency')
    				->where('cu_code',$req->id)
    				->update([
    					'cu_value'=>filter_var($req->value,FILTER_SANITIZE_NUMBER_INT)
    				]);

            logController::inputlog('MASTER CURRENCY', 'Update', filter_var($req->value,FILTER_SANITIZE_NUMBER_INT));

    	return Response::json(['status'=>1]);
    }
    public function edit_detail(request $req)
    {
      if (!mMember::akses('MASTER CURRENCY', 'ubah')) {
        return redirect('error-404');
      }
        $data = DB::table('m_currency')
                      ->where('cu_code',$req->id)
                      ->first();
        return Response::json(['data'=>$data]);
    }
}
