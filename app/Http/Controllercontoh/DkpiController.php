<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\d_kpi;
use App\Model\d_kpi_dt;
use App\Model\m_kpi;
use DB;
use Yajra\Datatables\Facades\Datatables;
use Auth;
use Response;
use App\mMember;
use App\Http\Controllers\logController;
class DkpiController extends Controller
{

    public function getKpiByTgl($tgl1, $tgl2)
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $tanggal1 = date('Y-m-d',strtotime($tgl1));
        $tanggal2 = date('Y-m-d',strtotime($tgl2));
        $data = d_kpi::leftjoin('m_pegawai','d_kpi.d_kpi_pid','=','m_pegawai.mp_id')->where('d_kpi.d_kpi_pid', '=', $id_peg)->whereBetween('d_kpi_date', [$tanggal1, $tanggal2])->orderBy('d_kpi_created', 'DESC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data)
        {
            if ($data->d_kpi_date == null) {
                return '-';
            } else {
                return $data->d_kpi_date ? with(new Carbon($data->d_kpi_date))->format('d M Y') : '';
            }
        })
        ->editColumn('tglConfirm', function ($data)
        {
            if ($data->d_kpi_dateconfirm == null) {
                return '-';
            } else {
                return $data->d_kpi_dateconfirm ? with(new Carbon($data->d_kpi_dateconfirm))->format('d M Y') : '';
            }
        })
        ->addColumn('action', function($data)
        {
            if ($data->d_kpi_isconfirm == 'Y') {
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit"
                                onclick=editKpi("'.$data->d_kpi_id.'") disabled><i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Hapus"
                                onclick=hapusKpi("'.$data->d_kpi_id.'") disabled><i class="fa fa-times-circle"></i>
                            </button>
                        </div>';
            }else{
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit"
                                onclick=editKpi("'.$data->d_kpi_id.'")><i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Hapus"
                                onclick=hapusKpi("'.$data->d_kpi_id.'")><i class="fa fa-times-circle"></i>
                            </button>
                        </div>';
            }

        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function lookup_divisi(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        $jenis_peg = $request->jenis;
        if (empty($term))
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_divisi')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_divisi')->where('c_id', '4')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            }

            return Response::json($formatted_tags);
        }
        else
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_divisi')->where('c_divisi', 'LIKE', '%'.$term.'%')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_divisi')->where('c_id', '4')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            }

          return Response::json($formatted_tags);
        }
    }

    public function setFieldModal()
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $data = DB::table('m_pegawai')
            ->join('m_jabatan', 'm_pegawai.mp_position', '=', 'm_jabatan.c_id')
            ->join('m_divisi', 'c_divisi_id', '=', 'm_divisi.c_id')
            ->select(
                'm_pegawai.mp_name',
                'm_jabatan.c_divisi_id',
                'm_jabatan.c_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('m_pegawai.mp_id', '=', $id_peg)->first();

        $kpi = m_kpi::where('kpi_p_id', '=', $id_peg)->get();
        return response()->json([
            'status' => 'sukses',
            'id_peg' => $id_peg,
            'data' => $data,
            'kpi' => $kpi
        ]);
    }

    public function simpanData(Request $request)
    {
      if (!mMember::akses('SCOREBOARD PEGAWAI', 'tambah')) {
        return redirect('error-404');
      }
        //dd($request->all());
        DB::beginTransaction();
        try
        {
            //code penerimaan
            $kode = $this->kodeKpiAuto();
            $lastId = d_kpi::select('d_kpi_id')->max('d_kpi_id');
            if ($lastId == 0 || $lastId == '') { $lastId  = 1; } else { $lastId += 1; }

            $kpi = new d_kpi;
            $kpi->d_kpi_id = $lastId;
            $kpi->d_kpi_code = $kode;
            $kpi->d_kpi_pid = $request->idpegawai;
            $kpi->d_kpi_date = date('Y-m-d',strtotime($request->tglKpi));
            $kpi->d_kpi_created = Carbon::now('Asia/Jakarta');
            $kpi->save();

            for ($i=0; $i < count($request->value_kpi); $i++)
            {
                d_kpi_dt::insert([
                            'd_kpidt_dkpi_id' => $lastId,
                            'd_kpidt_mkpi_id' => $request->index_kpi[$i],
                            'd_kpidt_value' => strtoupper($request->value_kpi[$i]),
                            'd_kpidt_created' => Carbon::now('Asia/Jakarta')
                        ]);
            }

            logController::inputlog('Scoreboard Pegawai', 'Insert', $kode);

            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Scoreboard Berhasil Disimpan'
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

    public function kodeKpiAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_kpi_code,4)) as kode_max from d_kpi WHERE DATE_FORMAT(d_kpi_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
        $kd = "";

        if(count($query)>0)
        {
          foreach($query as $k)
          {
            $tmp = ((int)$k->kode_max)+1;
            $kd = sprintf("%04s", $tmp);
          }
        }
        else
        {
          $kd = "0001";
        }

        return $code = "SCR-".date('ym')."-".$kd;
    }

    public function getDataEdit($id)
    {
      if (!mMember::akses('SCOREBOARD PEGAWAI', 'ubah')) {
        return redirect('error-404');
      }
        $id_peg = Auth::user()->m_pegawai_id;
        $pegawai = d_kpi::join('m_pegawai', 'd_kpi.d_kpi_pid', '=', 'm_pegawai.mp_id')
            ->join('m_jabatan', 'm_pegawai.mp_position', '=', 'm_jabatan.c_id')
            ->join('m_divisi', 'c_divisi_id', '=', 'm_divisi.c_id')
            ->select(
                'm_pegawai.mp_name',
                'm_jabatan.c_divisi_id',
                'm_jabatan.c_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('d_kpi.d_kpi_pid', '=', $id_peg)->first();

        $data = d_kpi::join('d_kpi_dt', 'd_kpi.d_kpi_id', '=', 'd_kpi_dt.d_kpidt_dkpi_id')
                            ->join('m_kpi', 'd_kpi_dt.d_kpidt_mkpi_id', '=', 'm_kpi.kpi_id')
                            ->where('d_kpi.d_kpi_id', $id)->get();

        return response()->json([
            'status' => 'sukses',
            'id_peg' => $id_peg,
            'pegawai' => $pegawai,
            'data' => $data
        ]);
    }

    public function updateData(Request $request)
    {
      if (!mMember::akses('SCOREBOARD PEGAWAI', 'ubah')) {
        return redirect('error-404');
      }
        //dd($request->all());
        DB::beginTransaction();
        try
        {
            $tanggal = Carbon::now('Asia/Jakarta');

            $d_kpi = d_kpi::find($request->e_old);
            $d_kpi->d_kpi_date = date('Y-m-d',strtotime($request->eTglKpi));
            $d_kpi->d_kpi_updated = $tanggal;
            $d_kpi->save();

            for ($i=0; $i < count($request->e_value_kpi); $i++)
            {
                d_kpi_dt::where('d_kpidt_id','=',$request->e_index_dt[$i])
                        ->update([
                            'd_kpidt_value' => strtoupper($request->e_value_kpi[$i]),
                            'd_kpidt_updated' => Carbon::now('Asia/Jakarta')
                        ]);
            }

            logController::inputlog('Scoreboard Pegawai', 'Update', $request->e_old);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Input Scoreboard Berhasil Diupdate'
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

    public function deleteData(Request $request)
    {
      if (!mMember::akses('SCOREBOARD PEGAWAI', 'hapus')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $data = d_kpi::where('d_kpi_id', $request->id)->first();
        d_kpi_dt::where('d_kpidt_dkpi_id', $request->id)->delete();
        d_kpi::where('d_kpi_id', $request->id)->delete();

        logController::inputlog('Scoreboard Pegawai', 'Hapus', $data->d_kpi_code);

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Input Scoreboard Berhasil Dihapus'
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

    // =======================================================================================================================
}
