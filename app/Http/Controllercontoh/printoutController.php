<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Carbon\Carbon;

use Session;

use Auth;

use App\mMember;

use Yajra\Datatables\Datatables;

class printoutController extends Controller
{
    public function index(){
      if (!mMember::akses('MASTER PRINT OUT TERM & CONDITION', 'aktif')) {
        return redirect('error-404');
      }
      return view('master.printout.index');
    }

    public function datatable_print(){
      DB::statement(DB::raw('set @rownum=0'));
      $data = DB::table('m_printoutterm')
                ->select(DB::raw('@rownum  := @rownum  + 1 AS number'), 'p_id', 'p_print')
                ->get();

      $list = collect($data);

      return Datatables::of($list)
          ->addColumn('aksi', function ($list) {
                    return  '<div class="btn-group">'.
                             '<button type="button" onclick="edit('.$list->p_id.')" class="btn btn-info btn-lg" title="edit">'.
                             '<label class="fa fa-pencil "></label></button>'.
                             '<button type="button" onclick="hapus('.$list->p_id.')" class="btn btn-danger btn-lg" title="hapus">'.
                             '<label class="fa fa-trash"></label></button>'.
                            '</div>';
          })
          ->rawColumns(['aksi', 'status'])
          ->make(true);
    }

    public function simpan(Request $request){
      if (!mMember::akses('MASTER PRINT OUT TERM & CONDITION', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $check = DB::table('m_printoutterm')->where('p_menu', $request->menu)->count();
        if ($check != 0) {
          DB::table('m_printoutterm')->where('p_menu', $request->menu)
              ->update([
                'p_print' => nl2br($request->print),
                'p_update' => Carbon::now('Asia/Jakarta')
              ]);
        } else {
          $id = DB::table('m_printoutterm')->max('p_id')+1;

          DB::table('m_printoutterm')
                ->insert([
                  'p_id' => $id,
                  'p_print' => nl2br($request->print),
                  'p_menu' => $request->menu,
                  'p_insert' => Carbon::now('Asia/Jakarta')
                ]);
        }

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }

    public function hapus(Request $request){
      DB::beginTransaction();
      try {

        DB::table('m_printoutterm')
            ->where('p_id', $request->id)
            ->delete();

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }

    public function edit(Request $request){
      $data = DB::table('m_printoutterm')
                  ->where('p_id', $request->id)
                  ->get();

      $result = str_replace( "<br />", '', $data[0]->p_print );


      $data[0]->p_print = $result;

      return response()->json($data);
    }
}
