<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Facades\Datatables;

use DB;

use Carbon\Carbon;
use App\mMember;
use App\Http\Controllers\logController;
class payrollController extends Controller
{
    public function datatable_payroll(){
      $list = DB::table('m_gaji_man')
                ->get();

        $data = collect($list);
        return Datatables::of($data)
                ->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit('.$data->c_id.')" class="btn btn-info btn-lg" title="edit">'.
                                   '<label class="fa fa-pencil "></label></button>'.
                                   '<button type="button" onclick="hapus('.$data->c_id.')" class="btn btn-danger btn-lg" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
            ->addColumn('sma', function ($data) {
                return '<div>Rp.
                  <span class="pull-right">
                    '.number_format( floatval($data->c_sma) ,2,',','.').'
                  </span>
                </div>';
            })
            ->addColumn('d3', function ($data) {
                return '<div>Rp.
                  <span class="pull-right">
                    '.number_format( floatval($data->c_d3) ,2,',','.').'
                  </span>
                </div>';
            })
            ->addColumn('s1', function ($data) {
                return '<div>Rp.
                  <span class="pull-right">
                    '.number_format( floatval($data->c_s1) ,2,',','.').'
                  </span>
                </div>';
            })
            ->addColumn('pangkat', function ($data) {
              $jabatan = DB::table('m_jabatan')
                            ->where('c_id', $data->c_jabatan)
                            ->select('c_posisi')
                            ->first();

                if ($jabatan->c_posisi != null){
                    $pangkat = $jabatan->c_posisi;
                } else {
                    $pangkat = "Semua";
                }

                return $pangkat;
            })
            ->rawColumns(['aksi','sma','d3','s1'])
            ->make(true);
    }

    public function simpan_payroll(Request $request){
      DB::beginTransaction();
      try {
        $id = DB::table('m_gaji_man')
                ->max("c_id");

        if ($id == null) {
          $id = 1;
        } else {
          $id += 1;
        }

        $request->c_sd = str_replace('.','',$request->c_sd);
        $request->c_sma = str_replace('.','',$request->c_sma);
        $request->c_smk = str_replace('.','',$request->c_smk);
        $request->c_d1 = str_replace('.','',$request->c_d1);
        $request->c_d2 = str_replace('.','',$request->c_d2);
        $request->c_d3 = str_replace('.','',$request->c_d3);
        $request->c_s1 = str_replace('.','',$request->c_s1);


        DB::table('m_gaji_man')
            ->insert([
              'c_id' => $id,
              'nm_gaji' => $request->nm_gaji,
              'c_sd' => (float)$request->c_sd,
              'c_smp' => (float)$request->c_smp,
              'c_sma' => (float)$request->c_sma,
              'c_smk' => (float)$request->c_smk,
              'c_d1' => (float)$request->c_d1,
              'c_d2' => (float)$request->c_d2,
              'c_d3' => (float)$request->c_d3,
              'c_s1' => (float)$request->c_s1,
              'c_jabatan' => $request->c_jabatan,
              'created_at' => Carbon::now('Asia/Jakarta')
            ]);

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

    public function hapus_payroll(Request $request){
      DB::beginTransaction();
      try {

        DB::table('m_gaji_man')
            ->where('c_id', $request->id)
            ->delete();

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

    public function edit_payroll(Request $request){
      $data = DB::table('m_gaji_man')
                ->where('c_id', $request->id)
                ->get();

      return response()->json($data);
    }

    public function update_payroll(Request $request){
      DB::beginTransaction();
      try {


        $request->c_sd = str_replace('.','',$request->c_sd);
        $request->c_sma = str_replace('.','',$request->c_sma);
        $request->c_smk = str_replace('.','',$request->c_smk);
        $request->c_d1 = str_replace('.','',$request->c_d1);
        $request->c_d2 = str_replace('.','',$request->c_d2);
        $request->c_d3 = str_replace('.','',$request->c_d3);
        $request->c_s1 = str_replace('.','',$request->c_s1);

        DB::table('m_gaji_man')
            ->where('c_id', $request->id)
            ->update([
              'nm_gaji' => $request->nm_gaji,
              'c_sd' => (float)$request->c_sd,
              'c_smp' => (float)$request->c_smp,
              'c_sma' => (float)$request->c_sma,
              'c_smk' => (float)$request->c_smk,
              'c_d1' => (float)$request->c_d1,
              'c_d2' => (float)$request->c_d2,
              'c_d3' => (float)$request->c_d3,
              'c_s1' => (float)$request->c_s1,
              'c_jabatan' => $request->c_jabatan,
              'updated_at' => Carbon::now('Asia/Jakarta')
            ]);

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
}
