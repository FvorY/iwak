<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\m_kpix;
use Response;
use DB;
use Yajra\Datatables\Datatables;
use Auth;
use App\mMember;
use App\Http\Controllers\logController;
class KpiController extends Controller
{
    public function index()
    {
      if (!mMember::akses('MASTER KPI', 'aktif')) {
        return redirect('error-404');
      }
        //update deadline jika hari ini sudah melebihi deadline
        DB::statement("UPDATE m_kpix SET kpix_deadline = NULL WHERE kpix_deadline < DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d')");
        return view('master/kpi/index');
    }

    public function tambahKpi()
    {
      if (!mMember::akses('MASTER KPI', 'tambah')) {
        return redirect('error-404');
      }
        return view('master/kpi/tambah');
    }

    public function getDatatableKpi()
    {
        $data = m_kpix::leftjoin('m_pegawai', 'm_kpix.kpix_p_id', '=', 'm_pegawai.mp_id')
                    ->leftjoin('m_divisi', 'm_kpix.kpix_div_id', '=', 'm_divisi.c_id')
                    ->leftjoin('m_jabatan', 'm_kpix.kpix_jabatan_id', '=', 'm_jabatan.c_id')
                    ->get();

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('deadline', function ($data)
        {
           if ($data->kpix_deadline != null || $data->kpix_deadline != '') {
                return '<div style="text-align:center;">' .$data->kpix_deadline. '</div>';
           }else{
                return '<div style="text-align:center;"> - </div>';
           }
        })
        ->addColumn('action', function ($data)
        {
            return  '<div align="center"><button id="edit" onclick=edit('.$data->kpix_id.') class="btn btn-warning btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>'.'
                    <button id="delete" onclick=hapus('.$data->kpix_id.') class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fa fa-times-circle"></i>
                    </button></div>';
        })
        ->rawColumns(['action','deadline'])
        ->make(true);
    }

    public function simpanKpi(Request $request)
    {
      if (!mMember::akses('MASTER KPI', 'tambah')) {
        return redirect('error-404');
      }
        //dd($request->all());
        DB::beginTransaction();
        try
        {
            $id = m_kpix::select('kpix_id')->max('kpix_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $kpix = new m_kpix();
            $kpix->kpix_id = $id;
            $kpix->kpix_name = $request->indikator;
            $kpix->kpix_bobot = $request->bobot;
            $kpix->kpix_deadline = date('Y-m-d',strtotime($request->deadline));
            $kpix->kpix_target = $request->targetkpi;
            $kpix->kpix_p_id = $request->pegawai;
            $kpix->kpix_div_id = $request->divisi;
            $kpix->kpix_jabatan_id = $request->jabatan;
            $kpix->kpix_created = Carbon::now('Asia/Jakarta');
            $kpix->save();

            logController::inputlog('Master KPI', 'Insert', $request->indikator);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Disimpan'
            ]);
        }
        catch (\Exception $e)
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function editKpi(Request $request)
    {
      if (!mMember::akses('MASTER KPI', 'ubah')) {
        return redirect('error-404');
      }
        $data = m_kpix::leftjoin('m_pegawai', 'm_kpix.kpix_p_id', '=', 'm_pegawai.mp_id')
                    ->leftjoin('m_divisi', 'm_kpix.kpix_div_id', '=', 'm_divisi.c_id')
                    ->leftjoin('m_jabatan', 'm_kpix.kpix_jabatan_id', '=', 'm_jabatan.c_id')
                    ->where('m_kpix.kpix_id', '=', $request->id)
                    ->first();
        return view('master/kpi/edit', compact('data'));
    }

    public function updateKpi(Request $request)
    {
      if (!mMember::akses('MASTER KPI', 'ubah')) {
        return redirect('error-404');
      }
        //dd($request->all());
        DB::beginTransaction();
        try
        {
            $kpix = m_kpix::find($request->kode_old);
            $kpix->kpix_name = $request->e_nama;
            $kpix->kpix_bobot = $request->e_bobot;
            $kpix->kpix_deadline = date('Y-m-d',strtotime($request->e_deadline));
            $kpix->kpix_target = $request->e_target;
            $kpix->kpix_p_id = $request->e_pegawai;
            $kpix->kpix_div_id = $request->e_divisi;
            $kpix->kpix_updated = Carbon::now('Asia/Jakarta');
            $kpix->save();

            logController::inputlog('Master KPI', 'Update', $request->e_nama);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Diupdate'
            ]);
        }
        catch (\Exception $e)
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function deleteKpi(Request $request)
    {
      if (!mMember::akses('Master KPI', 'hapus')) {
        return redirect('error-404');
      }
        DB::beginTransaction();
        try
        {

            $data = m_kpix::where('kpix_id', (int)$request->id)->first();

            m_kpix::where('kpix_id', (int)$request->id)->delete();

            logController::inputlog('Master KPI', 'Delete', $data->kpix_name);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Dihapus'
            ]);
        }
        catch (\Exception $e)
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    function generateRandomString($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function lookup_divisi(Request $request)
  {
      $formatted_tags = array();
      $term = trim($request->q);
      if (empty($term))
      {
          $divisi = DB::table('m_divisi')->orderBy('c_divisi', 'ASC')->limit(10)->get();
          foreach ($divisi as $val)
          {
              $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
          }
          return response()->json($formatted_tags);
      }
      else
      {
          $divisi = DB::table('m_divisi')->where('c_divisi', 'LIKE', '%'.$term.'%')->orderBy('c_divisi', 'ASC')->limit(10)->get();
          foreach ($divisi as $val)
          {
              $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
          }

        return response()->json($formatted_tags);
      }
  }

  public function lookup_jabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term))
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', '=', $request->divisi)->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val)
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            return response()->json($formatted_tags);
        }
        else
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', '=', $request->divisi)->where('c_posisi', 'LIKE', '%'.$term.'%')->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val)
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }

          return response()->json($formatted_tags);
        }
    }

    public function lookup_pegawai(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term))
        {
            $pegawai = DB::table('m_pegawai')
                        ->join('m_jabatan', 'm_jabatan.c_id', '=', 'mp_position')
                        ->join('m_divisi', 'm_divisi.c_id', '=', 'c_divisi_id')
                        ->where('c_divisi_id', $request->divisi)
                        ->where('mp_position', $request->jabatan)
                        ->get();

            foreach ($pegawai as $val)
            {
                $formatted_tags[] = ['id' => $val->mp_id, 'text' => $val->mp_name];
            }
            return response()->json($formatted_tags);
        }
        else
        {
            $pegawai = DB::table('m_pegawai')->join('m_jabatan', 'm_jabatan.c_id', '=', 'mp_position')
            ->join('m_divisi', 'm_divisi.c_id', '=', 'c_divisi_id')->where('c_divisi_id', '=', $request->divisi)->where('mp_position', '=', $request->jabatan)->where('mp_name', 'LIKE', '%'.$term.'%')->orderBy('mp_name', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val)
            {
            $formatted_tags[] = ['id' => $val->mp_id, 'text' => $val->mp_name];
            }

          return response()->json($formatted_tags);
        }
    }


    // ==================================================================================================================
}
