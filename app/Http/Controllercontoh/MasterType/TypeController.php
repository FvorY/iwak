<?php

namespace App\Http\Controllers\MasterType;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\TypeItem;
use DB;
use Yajra\Datatables\Datatables;
use App\mMember;
use App\Http\Controllers\logController;
class TypeController extends Controller
{
    public function typeproses(Request $request)
    {

        $m1 = DB::table('m_item_type')->max('it_id');

        $index = $m1+=1;

        $get_code = $request->get('t_code');

        $filter_code = str_replace(' ','',$get_code);

        $upper_code = strtoupper($filter_code);

        $data = DB::table('m_item_type')
          			->insert([
          		    'it_name' => strtoupper($request->get('t_name')),
      		        'it_code' => strtoupper($upper_code),
      		        'it_id'   => $m1,
          			]);

        return redirect('master/type/type')->with('success','Data has been  added');
    }

    public function type_edit(Request $request)
    {
    	// dd($request->all());
    	$data = DB::table('m_item_type')->where('it_id','=',$request->id)->get();
    	return response()->json($data);
    }

    public function datatable_type()
    {
    	$data= DB::table('m_item_type')->get();


        // return $data;
        $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($xyzab)
                        ->addColumn('aksi', function ($xyzab) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-info btn-lg" title="edit">'.
                                   '<label class="fa fa-pencil "></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        })

                      ->rawColumns(['aksi'])
                        ->make(true);
    }
    public function type_hapus(Request $request)
    {
      $type = DB::Table('m_item_type')->where('it_id','=',$request->id)->delete();
      return response()->json(['data'=>1]);
    }

    public function type_update(Request $request)
    {

        $get_code = $request->get('t_code');

        $filter_code = str_replace(' ','',$get_code);

        $upper_code = strtoupper($filter_code);

      // dd($request->all());
      $data = DB::table('m_item_type')
          ->where('it_id',$request->it_codex)
          ->update([
            'it_name'  => strtoupper($request->t_name),
            'it_code'  => strtoupper($upper_code)
          ]);


      return response()->json(['data'=>1]);

    }
}
