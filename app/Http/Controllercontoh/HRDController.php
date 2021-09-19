<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Menarik model
use App\abs_pegawai_man;
use App\abs_pegawai_pro;
use App\Divisi;
use App\M_tunjangan_man;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;
// ===================================
use App\mMember;
// Menarik plugin
use Excel;
use DB;

use Session;
use App\Http\Controllers\logController;
// =====================================

class HRDController extends Controller
{
    public function absensi()
    {
      if (!mMember::akses('ABSENSI', 'aktif')) {
        return redirect('error-404');
      }

        $divisi = new Divisi();
        $l_divisi = $divisi::all();
        $data = array( "divisi" => $l_divisi );
        return view('hrd/absensi/absensi', $data);
    }

    public function findAbsManajemen(Request $req) {

        $abs = new abs_pegawai_man();
        $data = $abs;

        if(isset($req)) {

            $tgl_awal = $req->tgl_awal == null ? '' : $req->tgl_awal;
            $tgl_akhir = $req->tgl_akhir == null ? '' : $req->tgl_akhir;
            $id_divisi = $req->id_divisi == null ? '' : $req->id_divisi;

            if($id_divisi != '') {
                $data = $data::where('apm_nama', "(SELECT mp_name FROM m_pegawai P LEFT JOIN m_jabatan J ON mp_position = c_id WHERE c_divisi_id = $id_divisi)");
            }
            if($tgl_awal != '' && $tgl_akhir != '') {
                $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
                $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
                $data = $data::whereBetween('apm_tanggal', array($tgl_awal, $tgl_akhir));
            }
        }

        $data = $data->take(100)->get();
        $result = "{\"data\" : $data}";

        header('Content-Type: application/json');
        return $result;
    }

    public function findAbsProduksi(Request $req) {

        $abs = new abs_pegawai_pro();
        $data = $abs;

        if(isset($req)) {

            $tgl_awal = $req->tgl_awal == null ? '' : $req->tgl_awal;
            $tgl_akhir = $req->tgl_akhir == null ? '' : $req->tgl_akhir;
            $id_divisi = $req->id_divisi == null ? '' : $req->id_divisi;

            if($id_divisi != '') {
                $data = $data::where('app_nama', "(SELECT mp_name FROM m_pegawai P LEFT JOIN m_jabatan J ON mp_position = c_id WHERE c_divisi_id = $id_divisi)");
            }
            if($tgl_awal != '' && $tgl_akhir != '') {
                $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
                $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
                $data = $data::whereBetween('app_tanggal', array($tgl_awal, $tgl_akhir));
            }
        }

        $data = $data->take(100)->get();
        $result = "{\"data\" : $data}";

        header('Content-Type: application/json');
        return $result;
    }
    // Import data absensi
    public function importDataManajemen(Request $request){
      if (!mMember::akses('ABSENSI', 'tambah')) {
        return redirect('error-404');
      }
      if ($request->hasFile('file-manajemen')) {
        $path = $request->file('file-manajemen')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();
        if (!empty($data) && $data->count()) {
          foreach ($data as $key => $value) {
            $absensi = new abs_pegawai_man();
            $absensi->apm_pm = $value->id_manajemen;
            $absensi->apm_nama = $value->nama;
            $absensi->apm_tanggal = $value->tanggal;
            $absensi->apm_jam_kerja = $value->jam_kerja;
            $absensi->apm_jam_masuk = $value->jam_masuk;
            $absensi->apm_jam_pulang = $value->jam_pulang;
            $absensi->apm_scan_masuk = $value->scan_masuk;
            $absensi->apm_scan_pulang = $value->scan_pulang;
            $absensi->apm_terlambat = $value->terlambat;
            $absensi->apm_plg_cepat = $value->plg_cepat;
            $absensi->apm_absent = $value->absent;
            $absensi->apm_lembur = $value->lembur;
            $absensi->apm_jml_jamkerja = $value->jml_jam_kerja;
            $absensi->save();
          }
        }
      }

      return back();
    }

    public function importDataProduksi(Request $request){
      if ($request->hasFile('file-produksi')) {
        $path = $request->file('file-produksi')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();
        if (!empty($data) && $data->count()) {
          foreach ($data as $key => $value) {
            $absensi = new abs_pegawai_pro();
            $absensi->app_pp = $value->id_produksi;
            $absensi->app_nama = $value->nama;
            $absensi->app_tanggal = $value->tanggal;
            $absensi->app_jam_kerja = $value->jam_kerja;
            $absensi->app_jam_masuk = $value->jam_masuk;
            $absensi->app_jam_pulang = $value->jam_pulang;
            $absensi->app_scan_masuk = $value->scan_masuk;
            $absensi->app_scan_pulang = $value->scan_pulang;
            $absensi->app_terlambat = $value->terlambat;
            $absensi->app_plg_cepat = $value->plg_cepat;
            $absensi->app_absent = $value->absent;
            $absensi->app_lembur = $value->lembur;
            $absensi->app_jml_jamkerja = $value->jml_jam_kerja;
            $absensi->save();
          }
        }
      }

      return back();
    }
    public function data_lembur()
    {
        return view('hrd/data_lembur/data_lembur');
    }
    public function freelance()
    {
        return view('hrd/freelance/freelance');
    }
    public function data_kpi()
    {
      if (!mMember::akses('DATA KPI', 'aktif')) {
        return redirect('error-404');
      }
        return view('hrd/data_kpi/data_kpi');
    }
    public function kesejahteraan()
    {
        return view('hrd/kesejahteraan/kesejahteraan');
    }
    public function manajemen_scoreboard()
    {
      if (!mMember::akses('MANAJEMEN SCOREBOARD', 'aktif')) {
        return redirect('error-404');
      }
        return view('hrd/manajemen_scoreboard/manajemen_scoreboard');
    }
    public function manajemen_scoreboard_kpi()
    {
      if (!mMember::akses('SCOREBOARD & KPI', 'aktif')) {
        return redirect('error-404');
      }
        return view('hrd/manajemen_scoreboard_kpi/manajemen_scoreboard_kpi');
    }
    public function manajemen_surat()
    {
        return view('hrd/manajemen_surat/manajemen_surat');
    }

    // Bagian payroll
    public function payroll()
    {
      if (!mMember::akses('PAYROLL', 'aktif')) {
        return redirect('error-404');
      }
            $data = DB::table('d_payroll_managerial')
                          ->get();

            $staff = DB::table('d_payroll_staff')
                        ->get();

        return view('hrd/payroll/payroll', compact('data', 'staff'));
    }

    public function findTunjangan(Request $req) {
        $tunj = new M_tunjangan_man();
        $data = $tunj->take(500)->get();
        $result = "{\"data\" : $data}";

        return response($result, 200)->header('Content-Type', 'application/json');
    }

    public function insertTunjangan(Request $req) {
        $tunj = new M_tunjangan_man();

        $tunj->tman_jabatan = $req->tman_levelpeg;
        $tunj->tman_nama = $req->tman_nama;
        $tunj->tman_periode = $req->tman_periode;
        $value = str_replace('.', '', $req->tman_value);
        $value = str_replace(',', '.', $value);
        $tunj->tman_value = $value;

        $tunj->save();
        $result = "{\"status\" : 1}";

        return response($result, 200)->header('Content-Type', 'application/json');
    }

    public function hapusTunjangan(Request $req) {
        $id = $req->tman_id;
        if($id != null || $id != '') {
            $tunj = new M_tunjangan_man();
            $data = $tunj->find($id);
            $data->delete();
            return response('{"status" : 1}', 200)->header('Content-Type', 'application/json');
        }
        else {
            return response('{"status" : 0}', 200)->header('Content-Type', 'application/json');
        }
    }

    public function updateTunjangan(Request $req) {
        $tunj = new M_tunjangan_man();
        $data = $tunj->find( $req->tman_id );

        $data->tman_jabatan = $req->tman_levelpeg;
        $data->tman_nama = $req->tman_nama;
        $data->tman_periode = $req->tman_periode;

        $value = str_replace('.', '', $req->tman_value);
        $value = str_replace(',', '.', $value);
        $tunj->tman_value = $value;

        $data->save();
        $result = "{\"status\" : 1}";

        return response($result, 200)->header('Content-Type', 'application/json');
    }

    public function datatable_tunjangan(){
      $list = DB::table('m_pegawai')
                ->leftjoin('m_jabatan', 'm_jabatan.c_id', '=', 'mp_position')
                ->leftjoin('m_divisi', 'm_divisi.c_id', '=', 'c_divisi_id')
                ->leftjoin('d_tunjangan', 't_pegawai', '=', 'mp_id')
                ->leftjoin('m_tunjangan_man', 'tman_id', '=', 't_tunjangan')
                ->select('mp_name', 'mp_nik', 'c_divisi', 'c_posisi', 'tman_nama', 'mp_id')
                ->get();

        $data = collect($list);
        return Datatables::of($data)
                ->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" class="btn btn-primary btn-lg alamraya-btn-aksi" title="edit" onclick="edit('.$data->mp_id.')"><label class="fa fa-pencil "></label></button>'.
                                  '</div>';
                })
                ->addColumn('tunjangan', function ($data) {
                  return '<li>'.$data->tman_nama.'</li>';
                })
            ->rawColumns(['aksi', 'tunjangan'])
            ->make(true);
    }

    public function finddata(Request $request){
      $data = DB::table('m_pegawai')
                ->leftjoin('m_jabatan', 'm_jabatan.c_id', '=', 'mp_position')
                ->leftjoin('m_divisi', 'm_divisi.c_id', '=', 'c_divisi_id')
                ->leftjoin('d_tunjangan', 't_pegawai', '=', 'mp_id')
                ->leftjoin('m_tunjangan_man', 'tman_id', '=', 't_tunjangan')
                ->where('mp_id', $request->id)
                ->get();

     $tunjangan = DB::table('m_tunjangan_man')
                    ->where('tman_jabatan', $data[0]->mp_position)
                    ->get();

      return response()->json([
        'data' => $data,
        'tunjangan' => $tunjangan
        ]);
    }

    public function simpansetting(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_tunjangan')
            ->where('t_pegawai', $request->pegawai)
            ->delete();

        $id = DB::table('d_tunjangan')
                  ->max('t_id');

        if ($id == 0) {
          $id = 1;
        } else {
          $id += 1;
        }

        for ($i=0; $i < count($request->tunjangan); $i++) {
          DB::table('d_tunjangan')
                ->insert([
                  't_id' => $id,
                  't_pegawai' => $request->pegawai,
                  't_tunjangan' => $request->tunjangan[$i],
                  't_insert' => Carbon::now('Asia/Jakarta')
                ]);
        }


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
    // ============================================================
    public function payroll_manajemen()
    {
        $divisi = DB::table('m_divisi')
                    ->get();

        return view('hrd/payroll_manajemen/payroll_manajemen', compact('divisi'));
    }

    public function payroll_manajemen_simpan(Request $request){
      DB::beginTransaction();
      try {

        $id = DB::table('d_payroll')
                ->max('p_id');

        if ($id == 0) {
          $id = 1;
        } else {
          $id += 1;
        }

        $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(p_kode,4,3)) as counter, MAX(MID(p_kode,8,2)) as tanggal, MAX(MID(p_kode,11,2)) as bulan, MAX(MID(p_kode,14)) as tahun FROM d_payroll"));

        if (count($querykode) > 0) {
          if ($querykode[0]->tanggal != date('d') || $querykode[0]->bulan != date('m') || $querykode[0]->tahun != date('Y')) {
              $kode = "001";
          } else {
            foreach($querykode as $k)
              {
                $tmp = ((int)$k->counter)+1;
                $kode = sprintf("%03s", $tmp);
              }
          }
        } else {
          $kode = "001";
        }


        $finalkode = 'PY-' . $kode . '/' . date('d') . '/' . date('m') . '/' . date('Y');

        if ($request->gaji == '') {
          $request->gaji = 0;
        } elseif ($request->tunjangan == '') {
          $request->tunjangan = 0;
        } elseif ($request->potongan == '') {
          $request->potongan = 0;
        } elseif ($request->total == '') {
          $request->total = 0;
        }

        $request->gaji = str_replace('Rp. ', '', $request->gaji);
        $request->gaji = str_replace('.', '', $request->gaji);
        $request->tunjangan = str_replace('Rp. ', '', $request->tunjangan);
        $request->tunjangan = str_replace('.', '', $request->tunjangan);
        $request->potongan = str_replace('Rp. ', '', $request->potongan);
        $request->potongan = str_replace('.', '', $request->potongan);
        $request->total = str_replace('Rp. ', '', $request->total);
        $request->total = str_replace('.', '', $request->total);


        DB::table('d_payroll')
            ->insert([
              'p_id' => $id,
              'p_kode' => $finalkode,
              'p_date' => Carbon::now('Asia/Jakarta'),
              'p_periode_start' => Carbon::parse($request->start)->format('Y-m-d'),
              'p_periode_end' => Carbon::parse($request->end)->format('Y-m-d'),
              'p_pegawai' => $request->pegawai,
              'p_divisi' => $request->divisi,
              'p_jabatan' => $request->jabatan,
              'p_gaji' => $request->gaji,
              'p_tunjangan' => $request->tunjangan,
              'p_potongan' => $request->potongan,
              'p_total_gaji' => $request->total,
              'p_insert' => Carbon::now('Asia/Jakarta')
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

    public function payroll_manajemen_datatable(Request $request){
      $divisi = $request->divisi;
      $status = $request->status;
      $start = $request->start;
      $end = $request->end;

      if ($start != null) {
        $start = Carbon::parse($request->start)->format('Y-m-d');
      }
       if ($end != null) {
        $end = Carbon::parse($request->end)->format('Y-m-d');
      }

      if ($divisi == null && $status == null && $start == null && $end == null) {
        $data = DB::table('d_payroll')
                    ->join('m_pegawai', 'mp_id', '=', 'p_pegawai')
                    ->get();
      } elseif ($divisi != null && $status == null && $start == null && $end == null) {
        $data = DB::table('d_payroll')
                    ->join('m_pegawai', 'mp_id', '=', 'p_pegawai')
                    ->where('p_divisi', $divisi)
                    ->get();
      } elseif ($divisi == null && $status != null && $start == null && $end == null) {
        $data = DB::table('d_payroll')
                    ->join('m_pegawai', 'mp_id', '=', 'p_pegawai')
                    ->where('p_status_cetak', $status)
                    ->get();
      } elseif ($divisi == null && $status == null && $start != null && $end != null) {
        $data = DB::table('d_payroll')
                    ->join('m_pegawai', 'mp_id', '=', 'p_pegawai')
                    ->where('p_periode_start', $start)
                    ->where('p_periode_end', $end)
                    ->get();
      } elseif ($divisi != null && $status != null && $start != null && $end != null) {
        $data = DB::table('d_payroll')
                    ->join('m_pegawai', 'mp_id', '=', 'p_pegawai')
                    ->where('p_divisi', $divisi)
                    ->where('p_status_cetak', $status)
                    ->where('p_periode_start', $start)
                    ->where('p_periode_end', $end)
                    ->get();
      } elseif ($divisi != null && $status != null && $start == null && $end == null) {
        $data = DB::table('d_payroll')
                    ->join('m_pegawai', 'mp_id', '=', 'p_pegawai')
                    ->where('p_divisi', $divisi)
                    ->where('p_status_cetak', $status)
                    ->get();
      }

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->p_periode_start = Carbon::parse($data[$i]->p_periode_start)->format('d-m-Y');
        $data[$i]->p_periode_end= Carbon::parse($data[$i]->p_periode_end)->format('d-m-Y');
      }

      return response()->json($data);
    }

    public function payroll_manajemen_getdivisi(Request $request){
        $jabatan = DB::table('m_jabatan')
                      ->where('c_divisi_id', $request->divisi)
                      ->select('c_id', 'c_posisi')
                      ->get();

        return response()->json($jabatan);
    }

    public function payroll_manajemen_hapus(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_payroll')
              ->where('p_id', $request->id)
              ->delete();

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      }

    }

    public function payroll_manajemen_detail(Request $request){
      $data = DB::table('d_payroll')
                  ->join('m_pegawai', 'mp_id', '=', 'p_pegawai')
                  ->join('m_jabatan', 'm_jabatan.c_id', '=', 'p_jabatan')
                  ->join('m_divisi', function($e){
                    $e->on('m_divisi.c_id', '=', 'c_divisi_id')
                      ->on('m_divisi.c_id', '=', 'p_divisi');
                  })
                  ->where('p_id', $request->id)
                  ->get();

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->p_date = Carbon::parse($data[$i]->p_date)->format('d-m-Y');
        $data[$i]->p_periode_start = Carbon::parse($data[$i]->p_periode_start)->format('d-m-Y');
        $data[$i]->p_periode_end = Carbon::parse($data[$i]->p_periode_end)->format('d-m-Y');
      }

      $tunjangan = DB::table('d_tunjangan')
                      ->join('m_tunjangan_man', 'tman_id', '=', 't_tunjangan')
                      ->where('t_pegawai', $data[0]->p_pegawai)
                      ->get();

      return response()->json([
        'data' => $data,
        'tunjangan' => $tunjangan
      ]);
    }

    public function payroll_manajemen_getjabatan(Request $request){
      $pegawai = DB::table('m_pegawai')
                    ->where('mp_position', $request->jabatan)
                    ->select('mp_id', 'mp_name')
                    ->get();

      return response()->json($pegawai);
    }

    public function payroll_manajemen_proses(Request $request){
      $pegawai = DB::table('m_pegawai')
                ->where('mp_id', $request->pegawai)
                ->first();

      $getmaster = DB::table('m_gaji_man')
                    ->orderBy('created_at', 'asc')
                    ->first();

      $tunjangan = DB::table('d_tunjangan')
                      ->join('m_tunjangan_man', 'tman_id', '=', 't_tunjangan')
                      ->where('t_pegawai', $request->pegawai)
                      ->select(DB::raw('sum(tman_value) as tunjangan'))
                      ->first();

      if ($pegawai->mp_pendidikan == 'SD') {
        $gaji = $getmaster->c_sd;
      } else if ($pegawai->mp_pendidikan == 'SMP') {
        $gaji = $getmaster->c_smp;
      } else if ($pegawai->mp_pendidikan == 'SMA') {
        $gaji = $getmaster->c_sma;
      } else if ($pegawai->mp_pendidikan == 'SMK') {
        $gaji = $getmaster->c_smk;
      } else if ($pegawai->mp_pendidikan == 'D1') {
        $gaji = $getmaster->c_d1;
      } else if ($pegawai->mp_pendidikan == 'D2') {
        $gaji = $getmaster->c_d2;
      } else if ($pegawai->mp_pendidikan == 'D3') {
        $gaji = $getmaster->c_d3;
      } else if ($pegawai->mp_pendidikan == 'S1') {
        $gaji = $getmaster->c_s1;
      }

      return response()->json([
        'gaji' => $gaji,
        'tunjangan' => $tunjangan
      ]);

    }

    public function payroll_produksi()
    {
        return view('hrd/payroll_produksi/payroll_produksi');
    }
    public function recruitment()
    {
        return view('hrd/recruitment/recruitment');
    }
    public function scoreboard_pegawai()
    {
      if (!mMember::akses('SCOREBOARD PEGAWAI', 'aktif')) {
        return redirect('error-404');
      }
        return view('hrd/scoreboard_pegawai/scoreboard_pegawai');
    }
    public function training_pegawai()
    {
        return view('hrd/training_pegawai/training_pegawai');
    }
    public function setting_tunjangan()
    {
        return view('hrd/payroll/setting_tunjangan');
    }

    public function kartushift(Request $request){
      if (!mMember::akses('ABSENSI', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $path = $request->file('kartushift')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();

          if (!empty($data) && $data->count()) {
            foreach ($data as $key => $value) {
              $check = DB::table('d_kartushift')
                          ->where('k_pin', (int)$value->pin)
                          ->where('k_nip', (int)$value->nip)
                          ->where('k_nama', $value->nama)
                          ->where('k_jabatan', $value->jabatan)
                          ->where('k_departement', $value->departement)
                          ->where('k_kantor', $value->kantor)
                          ->where('k_tanggal', Carbon::parse($value->tanggal)->format('Y-m-d'))
                          ->where('k_kehadiran', (int)$value->kehadiran)
                          ->where('k_in', $value->in)
                          ->where('k_out', $value->out)
                          ->count();

              if ($check == 0) {
                DB::table('d_kartushift')
                            ->insert(['k_pin' => (int)$value->pin,
                            'k_nip' => (int)$value->nip,
                            'k_nama' => $value->nama,
                            'k_jabatan' => $value->jabatan,
                            'k_departement' => $value->departement,
                            'k_kantor' => $value->kantor,
                            'k_tanggal' => Carbon::parse($value->tanggal)->format('Y-m-d'),
                            'k_kehadiran' => (int)$value->kehadiran,
                            'k_in' => $value->in,
                            'k_out' => $value->out]);
              } else {
                DB::table('d_kartushift')
                            ->where('k_pin', (int)$value->pin)
                            ->where('k_nip', (int)$value->nip)
                            ->where('k_nama', $value->nama)
                            ->where('k_jabatan', $value->jabatan)
                            ->where('k_departement', $value->departement)
                            ->where('k_kantor', $value->kantor)
                            ->where('k_tanggal', Carbon::parse($value->tanggal)->format('Y-m-d'))
                            ->where('k_kehadiran', (int)$value->kehadiran)
                            ->where('k_in', $value->in)
                            ->where('k_out', $value->out)
                            ->update([
                              'k_insert' => Carbon::now('Asia/Jakarta')
                            ]);
              }
            }
          }

          logController::inputlog('Absensi', 'Insert Kartu Shift', $path);

          DB::commit();
          Session::flash('sukses', 'Berhasil Disimpan!');
          return redirect('hrd/absensi/absensi');
      } catch (\Exception $e) {
          DB::rollback();
          Session::flash('gagal', 'Gagal Disimpan!');
          return redirect('hrd/absensi/absensi');
      }
    }

    public function kstable(Request $request){
      if(isset($request)) {

          $tgl_awal = $request->tgl1 == null ? '' : $request->tgl1;
          $tgl_akhir = $request->tgl2 == null ? '' : $request->tgl2;

          if($tgl_awal != '' && $tgl_akhir != '') {
              $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
              $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
              $data = DB::table('d_kartushift')
                        ->whereBetween('k_tanggal', array($tgl_awal, $tgl_akhir))
                        ->orderby('k_tanggal', 'DESC')
                        ->get();
          } else {
            $data = DB::table('d_kartushift')
                        ->orderby('k_tanggal', 'DESC')
                        ->get();
          }
      }

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->k_tanggal = Carbon::parse($data[$i]->k_tanggal)->format('d-m-Y');
      }

      $result = "{\"data\" : $data}";

      header('Content-Type: application/json');
      return $result;
    }

    public function abtable(Request $request){
      if(isset($request)) {

          $tgl_awal = $request->tgl1 == null ? '' : $request->tgl1;
          $tgl_akhir = $request->tgl2 == null ? '' : $request->tgl2;

          if($tgl_awal != '' && $tgl_akhir != '') {
              $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
              $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
              $data = DB::table('d_absensibulan')
                        ->whereBetween('a_tanggal', array($tgl_awal, $tgl_akhir))
                        ->orderBy('a_tanggal', 'DESC')
                        ->get();
          } else {
            $data = DB::table('d_absensibulan')
                        ->orderBy('a_tanggal', 'DESC')
                        ->get();
          }
      }

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->a_tanggal = Carbon::parse($data[$i]->a_tanggal)->format('d-m-Y');
      }

      $result = "{\"data\" : $data}";

      header('Content-Type: application/json');
      return $result;
    }

    public function importbulan(Request $request){
      if (!mMember::akses('ABSENSI', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $path = $request->file('importbulan')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();

          if (!empty($data) && $data->count()) {
            foreach ($data as $key => $value) {
              $check = DB::table('d_absensibulan')
                          ->where('a_tanggalscan', Carbon::parse($value->tanggal_scan)->format('Y-m-d'))
                          ->where('a_tanggal', Carbon::parse($value->tanggal)->format('Y-m-d'))
                          ->where('a_jam', $value->jam)
                          ->where('a_pin', (int)$value->pin)
                          ->where('a_nip', (int)$value->nip)
                          ->where('a_nama', $value->nama)
                          ->where('a_jabatan', $value->jabatan)
                          ->where('a_departement', $value->departement)
                          ->where('a_kantor', $value->kantor)
                          ->where('a_verifikasi', (int)$value->verifikasi)
                          ->where('a_io', (int)$value->input_output)
                          ->where('a_workcode', (int)$value->workcode)
                          ->where('a_sn', (string)$value->serial_number)
                          ->where('a_mesin', $value->mesin)
                          ->count();

              if ($check == 0) {
                DB::table('d_absensibulan')
                        ->insert(['a_tanggalscan' => Carbon::parse($value->tanggal_scan)->format('Y-m-d G:i:s'),
                        'a_tanggal' => Carbon::parse($value->tanggal)->format('Y-m-d'),
                        'a_jam' => $value->jam,
                        'a_pin' => (int)$value->pin,
                        'a_nip' => (int)$value->nip,
                        'a_nama' => $value->nama,
                        'a_jabatan' => $value->jabatan,
                        'a_departement' => $value->departement,
                        'a_kantor' => $value->kantor,
                        'a_verifikasi' => (int)$value->verifikasi,
                        'a_io' => (int)$value->input_output,
                        'a_workcode' => (int)$value->workcode,
                        'a_sn' => $value->serial_number,
                        'a_mesin' => $value->mesin]);
              } else {
                  DB::table('d_absensibulan')
                            ->where('a_tanggalscan', Carbon::parse($value->tanggal_scan)->format('Y-m-d'))
                            ->where('a_tanggal', Carbon::parse($value->tanggal)->format('Y-m-d'))
                            ->where('a_jam', $value->jam)
                            ->where('a_pin', (int)$value->pin)
                            ->where('a_nip', (int)$value->nip)
                            ->where('a_nama', $value->nama)
                            ->where('a_jabatan', $value->jabatan)
                            ->where('a_departement', $value->departement)
                            ->where('a_kantor', $value->kantor)
                            ->where('a_verifikasi', (int)$value->verifikasi)
                            ->where('a_io', (int)$value->input_output)
                            ->where('a_workcode', (int)$value->workcode)
                            ->where('a_sn', (string)$value->serial_number)
                            ->where('a_mesin', $value->mesin)
                            ->update([
                              'a_inseert' => Carbon::now('Asia/Jakarta')
                            ]);
              }
            }
          }

          logController::inputlog('Absensi', 'Insert Bulan', $path);

          DB::commit();
          Session::flash('sukses', 'Berhasil Disimpan!');
          return redirect('hrd/absensi/absensi');
      } catch (\Exception $e) {
          DB::rollback();
          Session::flash('gagal', 'Gagal Disimpan!');
          return redirect('hrd/absensi/absensi');
      }
    }

    public function artable(Request $request){
      if(isset($request)) {

          $tgl_awal = $request->tgl1 == null ? '' : $request->tgl1;
          $tgl_akhir = $request->tgl2 == null ? '' : $request->tgl2;

          if($tgl_awal != '' && $tgl_akhir != '') {
              $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
              $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
              $data = DB::table('d_rekapperiode')
                        ->whereBetween('r_insert', array($tgl_awal, $tgl_akhir))
                        ->orderBy('r_insert', 'DESC')
                        ->get();
          } else {
            $data = DB::table('d_rekapperiode')
                        ->orderBy('r_insert', 'DESC')
                        ->get();
          }
      }

      $result = "{\"data\" : $data}";

      header('Content-Type: application/json');
      return $result;
    }

    public function print_payroll(Request $request){
      if (!mMember::akses('PAYROLL', 'print')) {
        return redirect('error-404');
      }

      $data = DB::table('d_payroll_managerial')
                  ->whereIn('pm_pin', $request->pin)
                  ->whereIn('pm_nip', $request->nip)
                  ->orderby('pm_insert', 'desc')
                  ->get();

      for ($i=0; $i < count($data); $i++) {
        logController::inputlog('Payroll', 'Print Managerial', $data[$i]->pm_nama);
      }

      response()->json([
        'status' => 'berhasil'
      ]);
      return view('hrd.payroll.print_payroll', compact('data'));
    }

    public function print_payrolls(Request $request){
      if (!mMember::akses('PAYROLL', 'print')) {
        return redirect('error-404');
      }

      $data = DB::table('d_payroll_staff')
                  ->whereIn('ps_pin', $request->pin)
                  ->whereIn('ps_nip', $request->nip)
                  ->orderby('ps_insert', 'desc')
                  ->get();

      for ($i=0; $i < count($data); $i++) {
        logController::inputlog('Payroll', 'Print Staff', $data[$i]->ps_nama);
      }

      response()->json([
        'status' => 'berhasil'
      ]);
      return view('hrd.payroll.print_payrolls', compact('data'));
    }

    public function rekap(Request $request){
      if (!mMember::akses('ABSENSI', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $path = $request->file('absensirekap')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();

          if (!empty($data) && $data->count()) {
            foreach ($data as $key => $value) {
              $check = DB::table('d_rekapperiode')
                          ->where('r_pin', $value->pin)
                          ->where('r_nip', $value->nip)
                          ->where('r_nama', $value->nama)
                          ->where('r_jabatan',  $value->jabatan)
                          ->where('r_departement', $value->departement)
                          ->where('r_kantor', $value->kantor)
                          ->where('r_izin_libur', $value->izin_lembur)
                          ->where('r_kehadiran_jml', $value->jumlah_kehadiran)
                          ->where('r_kehadiran_jammenit', $value->jam_menit_kehadiran)
                          ->where('r_datangterlambat_jammenit', $value->jam_menit_datang_terlambat)
                          ->where('r_datangterlambat_jml', $value->jam_menit_datang_jml)
                          ->where('r_pulangawal_jammenit', $value->jam_menit_pulang_awal)
                          ->where('r_pulangawal_jml', $value->jumlah_pulang_awal)
                          ->where('r_istirahatlebih_jammenit', $value->jam_menit_istirahat_lebih)
                          ->where('r_istirahatlebih_jml', $value->jumlah_istirahat_lebih)
                          ->where('r_scankerja_masuk', $value->scan_kerja_masuk)
                          ->where('r_scankerja_keluar', $value->scan_kerja_keluar)
                          ->where('r_lembur_jml', $value->jumlah_lembur)
                          ->where('r_lembur_jammenit', $value->jam_menit_lembur)
                          ->where('r_lembur_scan', $value->scan_lembur)
                          ->where('r_tidakhadir_tanpaizin', $value->tidak_hadir_tanpa_izin)
                          ->where('r_libur_rutindanumum', $value->libur_rutin_dan_umum)
                          ->where('r_perhitunganpengecualianizin_izintidakmasukpribadi', $value->izin_tidak_masuk_pribadi)
                          ->where('r_perhitunganpengecualianizin_izinpulangawalpribadi', $value->izin_pulang_awal_pribadi)
                          ->where('r_perhitunganpengecualianizin_izindatangterlambatpribadi', $value->izin_datang_terlambat_pribadi)
                          ->where('r_perhitunganpengecualianizin_sakitdengansuratdokter', $value->sakit_dengan_surat_dokter)
                          ->where('r_perhitunganpengecualianizin_sakittanpasuratdokter', $value->sakit_tanpa_surat_dokter)
                          ->where('r_perhitunganpengecualianizin_izinmeninggalkantempatkerja', $value->izin_meninggalkan_tempat_kerja)
                          ->where('r_perhitunganpengecualianizin_izindinaskantor', $value->izin_dinas_kantor)
                          ->where('r_perhitunganpengecualianizin_izindatangterlambatkantor', $value->izin_datang_terlambat_kantor)
                          ->where('r_perhitunganpengecualianizin_izinpulangawalkantor', $value->izin_pulang_awal_kantor)
                          ->where('r_perhitunganpengecualianizin_cutinormatif', $value->cuti_normatif)
                          ->where('r_perhitunganpengecualianizin_cutipribadi', $value->cuti_pribadi)
                          ->where('r_perhitunganpengecualianizin_tidakscanmasuk', $value->tidak_scan_masuk)
                          ->where('r_perhitunganpengecualianizin_tidakscanpulang', $value->tidak_scan_pulang)
                          ->where('r_perhitunganpengecualianizin_tidakscanmulaiistirahat', $value->tidak_scan_mulai_istirahat)
                          ->where('r_perhitunganpengecualianizin_tidakscanselesaiistirahat', $value->tidak_scan_selesai_istirahat)
                          ->where('r_perhitunganpengecualianizin_tidakscanmulailembur', $value->tidak_scan_mulai_lembur)
                          ->where('r_perhitunganpengecualianizin_tidakscanselesailembur', $value->tidak_scan_selesai_lembur)
                          ->where('r_perhitunganpengecualianizin_izinlainlain', $value->izin_lain_lain)
                          ->count();

              if ($check == 0) {
                DB::table('d_rekapperiode')
                ->insert(['r_pin' => $value->pin,
                'r_nip' => $value->nip,
                'r_nama' => $value->nama,
                'r_jabatan' =>  $value->jabatan,
                'r_departement' => $value->departement,
                'r_kantor' => $value->kantor,
                'r_izin_libur' => $value->izin_lembur,
                'r_kehadiran_jml' => $value->jumlah_kehadiran,
                'r_kehadiran_jammenit' => $value->jam_menit_kehadiran,
                'r_datangterlambat_jammenit' => $value->jam_menit_datang_terlambat,
                'r_datangterlambat_jml' => $value->jam_menit_datang_jml,
                'r_pulangawal_jammenit' => $value->jam_menit_pulang_awal,
                'r_pulangawal_jml' => $value->jumlah_pulang_awal,
                'r_istirahatlebih_jammenit' => $value->jam_menit_istirahat_lebih,
                'r_istirahatlebih_jml' => $value->jumlah_istirahat_lebih,
                'r_scankerja_masuk' => $value->scan_kerja_masuk,
                'r_scankerja_keluar' => $value->scan_kerja_keluar,
                'r_lembur_jml' => $value->jumlah_lembur,
                'r_lembur_jammenit' => $value->jam_menit_lembur,
                'r_lembur_scan' => $value->scan_lembur,
                'r_tidakhadir_tanpaizin' => $value->tidak_hadir_tanpa_izin,
                'r_libur_rutindanumum' => $value->libur_rutin_dan_umum,
                'r_perhitunganpengecualianizin_izintidakmasukpribadi' => $value->izin_tidak_masuk_pribadi,
                'r_perhitunganpengecualianizin_izinpulangawalpribadi' => $value->izin_pulang_awal_pribadi,
                'r_perhitunganpengecualianizin_izindatangterlambatpribadi' => $value->izin_datang_terlambat_pribadi,
                'r_perhitunganpengecualianizin_sakitdengansuratdokter' => $value->sakit_dengan_surat_dokter,
                'r_perhitunganpengecualianizin_sakittanpasuratdokter' => $value->sakit_tanpa_surat_dokter,
                'r_perhitunganpengecualianizin_izinmeninggalkantempatkerja' => $value->izin_meninggalkan_tempat_kerja,
                'r_perhitunganpengecualianizin_izindinaskantor' => $value->izin_dinas_kantor,
                'r_perhitunganpengecualianizin_izindatangterlambatkantor' => $value->izin_datang_terlambat_kantor,
                'r_perhitunganpengecualianizin_izinpulangawalkantor' => $value->izin_pulang_awal_kantor,
                'r_perhitunganpengecualianizin_cutinormatif' => $value->cuti_normatif,
                'r_perhitunganpengecualianizin_cutipribadi' => $value->cuti_pribadi,
                'r_perhitunganpengecualianizin_tidakscanmasuk' => $value->tidak_scan_masuk,
                'r_perhitunganpengecualianizin_tidakscanpulang' => $value->tidak_scan_pulang,
                'r_perhitunganpengecualianizin_tidakscanmulaiistirahat' => $value->tidak_scan_mulai_istirahat,
                'r_perhitunganpengecualianizin_tidakscanselesaiistirahat' => $value->tidak_scan_selesai_istirahat,
                'r_perhitunganpengecualianizin_tidakscanmulailembur' => $value->tidak_scan_mulai_lembur,
                'r_perhitunganpengecualianizin_tidakscanselesailembur' => $value->tidak_scan_selesai_lembur,
                'r_perhitunganpengecualianizin_izinlainlain' => $value->izin_lain_lain]);
              } else {
                DB::table('d_rekapperiode')
                            ->where('r_pin', $value->pin)
                            ->where('r_nip', $value->nip)
                            ->where('r_nama', $value->nama)
                            ->where('r_jabatan',  $value->jabatan)
                            ->where('r_departement', $value->departement)
                            ->where('r_kantor', $value->kantor)
                            ->where('r_izin_libur', $value->izin_lembur)
                            ->where('r_kehadiran_jml', $value->jumlah_kehadiran)
                            ->where('r_kehadiran_jammenit', $value->jam_menit_kehadiran)
                            ->where('r_datangterlambat_jammenit', $value->jam_menit_datang_terlambat)
                            ->where('r_datangterlambat_jml', $value->jam_menit_datang_jml)
                            ->where('r_pulangawal_jammenit', $value->jam_menit_pulang_awal)
                            ->where('r_pulangawal_jml', $value->jumlah_pulang_awal)
                            ->where('r_istirahatlebih_jammenit', $value->jam_menit_istirahat_lebih)
                            ->where('r_istirahatlebih_jml', $value->jumlah_istirahat_lebih)
                            ->where('r_scankerja_masuk', $value->scan_kerja_masuk)
                            ->where('r_scankerja_keluar', $value->scan_kerja_keluar)
                            ->where('r_lembur_jml', $value->jumlah_lembur)
                            ->where('r_lembur_jammenit', $value->jam_menit_lembur)
                            ->where('r_lembur_scan', $value->scan_lembur)
                            ->where('r_tidakhadir_tanpaizin', $value->tidak_hadir_tanpa_izin)
                            ->where('r_libur_rutindanumum', $value->libur_rutin_dan_umum)
                            ->where('r_perhitunganpengecualianizin_izintidakmasukpribadi', $value->izin_tidak_masuk_pribadi)
                            ->where('r_perhitunganpengecualianizin_izinpulangawalpribadi', $value->izin_pulang_awal_pribadi)
                            ->where('r_perhitunganpengecualianizin_izindatangterlambatpribadi', $value->izin_datang_terlambat_pribadi)
                            ->where('r_perhitunganpengecualianizin_sakitdengansuratdokter', $value->sakit_dengan_surat_dokter)
                            ->where('r_perhitunganpengecualianizin_sakittanpasuratdokter', $value->sakit_tanpa_surat_dokter)
                            ->where('r_perhitunganpengecualianizin_izinmeninggalkantempatkerja', $value->izin_meninggalkan_tempat_kerja)
                            ->where('r_perhitunganpengecualianizin_izindinaskantor', $value->izin_dinas_kantor)
                            ->where('r_perhitunganpengecualianizin_izindatangterlambatkantor', $value->izin_datang_terlambat_kantor)
                            ->where('r_perhitunganpengecualianizin_izinpulangawalkantor', $value->izin_pulang_awal_kantor)
                            ->where('r_perhitunganpengecualianizin_cutinormatif', $value->cuti_normatif)
                            ->where('r_perhitunganpengecualianizin_cutipribadi', $value->cuti_pribadi)
                            ->where('r_perhitunganpengecualianizin_tidakscanmasuk', $value->tidak_scan_masuk)
                            ->where('r_perhitunganpengecualianizin_tidakscanpulang', $value->tidak_scan_pulang)
                            ->where('r_perhitunganpengecualianizin_tidakscanmulaiistirahat', $value->tidak_scan_mulai_istirahat)
                            ->where('r_perhitunganpengecualianizin_tidakscanselesaiistirahat', $value->tidak_scan_selesai_istirahat)
                            ->where('r_perhitunganpengecualianizin_tidakscanmulailembur', $value->tidak_scan_mulai_lembur)
                            ->where('r_perhitunganpengecualianizin_tidakscanselesailembur', $value->tidak_scan_selesai_lembur)
                            ->where('r_perhitunganpengecualianizin_izinlainlain', $value->izin_lain_lain)
                            ->update([
                              'r_insert' => Carbon::now('Asia/Jakarta')
                            ]);
              }
            }
          }

          logController::inputlog('Absensi', 'Insert Rekap Periode', $path);

          DB::commit();
          Session::flash('sukses', 'Berhasil Disimpan!');
          return redirect('hrd/absensi/absensi');
      } catch (\Exception $e) {
          DB::rollback();
          Session::flash('gagal', 'Gagal Disimpan!');
          return redirect('hrd/absensi/absensi');
      }
    }

    public function attable(Request $request){
      if(isset($request)) {

          $tgl_awal = $request->tgl1 == null ? '' : $request->tgl1;
          $tgl_akhir = $request->tgl2 == null ? '' : $request->tgl2;

          if($tgl_awal != '' && $tgl_akhir != '') {
              $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
              $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
              $data = DB::table('d_rincian_tahunan')
                        ->whereBetween('r_insert', array($tgl_awal, $tgl_akhir))
                        ->orderBy('rt_insert', 'DESC')
                        ->get();
          } else {
            $data = DB::table('d_rincian_tahunan')
                        ->orderBy('rt_insert', 'DESC')
                        ->get();
          }
      }

      $result = "{\"data\" : $data}";

      header('Content-Type: application/json');
      return $result;
    }

    public function tahun(Request $request){
      if (!mMember::akses('ABSENSI', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $path = $request->file('rinciantahunan')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();

          if (!empty($data) && $data->count()) {
            foreach ($data as $key => $value) {
              $check = DB::table('d_rincian_tahunan')
                          ->where('rt_pin', $value->pin)
                          ->where('rt_nip', $value->nip)
                          ->where('rt_nama', $value->nama)
                          ->where('rt_jabatan', $value->jabatan)
                          ->where('rt_departement', $value->departement)
                          ->where('rt_kantor', $value->kantor)
                          ->where('rt_bulan', $value->bulan)
                          ->where('rt_1', $value->tanggal_1)
                          ->where('rt_2', $value->tanggal_2)
                          ->where('rt_3', $value->tanggal_3)
                          ->where('rt_4', $value->tanggal_4)
                          ->where('rt_5', $value->tanggal_5)
                          ->where('rt_6', $value->tanggal_6)
                          ->where('rt_7', $value->tanggal_7)
                          ->where('rt_8', $value->tanggal_8)
                          ->where('rt_9', $value->tanggal_9)
                          ->where('rt_10', $value->tanggal_10)
                          ->where('rt_11', $value->tanggal_11)
                          ->where('rt_12', $value->tanggal_12)
                          ->where('rt_13', $value->tanggal_13)
                          ->where('rt_14', $value->tanggal_14)
                          ->where('rt_15', $value->tanggal_15)
                          ->where('rt_16', $value->tanggal_16)
                          ->where('rt_17', $value->tanggal_17)
                          ->where('rt_18', $value->tanggal_18)
                          ->where('rt_19', $value->tanggal_19)
                          ->where('rt_20', $value->tanggal_20)
                          ->where('rt_21', $value->tanggal_21)
                          ->where('rt_22', $value->tanggal_22)
                          ->where('rt_23', $value->tanggal_23)
                          ->where('rt_24', $value->tanggal_24)
                          ->where('rt_25', $value->tanggal_25)
                          ->where('rt_26', $value->tanggal_26)
                          ->where('rt_27', $value->tanggal_27)
                          ->where('rt_28', $value->tanggal_28)
                          ->where('rt_29', $value->tanggal_29)
                          ->where('rt_30', $value->tanggal_30)
                          ->where('rt_31', $value->tanggal_31)
                          ->where('rt_libur', $value->libur)
                          ->where('rt_cuti', $value->cuti)
                          ->where('rt_izin', $value->izin)
                          ->where('rt_sakit', $value->sakit)
                          ->where('rt_absen', $value->absen)
                          ->where('rt_cuti_normatif', $value->cuti_normatif)
                          ->where('rt_dinas', $value->dinas)
                          ->where('rt_hari_kerja', $value->hari_kerja)
                          ->where('rt_tidak_hadir', $value->tidak_hadir)
                          ->where('rt_kehadiran', $value->kehadiran)
                          ->count();

              if ($check == 0) {
                DB::table('d_rincian_tahunan')
                ->insert(['rt_pin' => $value->pin,
                'rt_nip' => $value->nip,
                'rt_nama' => $value->nama,
                'rt_jabatan' => $value->jabatan,
                'rt_departement' => $value->departement,
                'rt_kantor' => $value->kantor,
                'rt_bulan' => $value->bulan,
                'rt_1' => $value->tanggal_1,
                'rt_2' => $value->tanggal_2,
                'rt_3' => $value->tanggal_3,
                'rt_4' => $value->tanggal_4,
                'rt_5' => $value->tanggal_5,
                'rt_6' => $value->tanggal_6,
                'rt_7' => $value->tanggal_7,
                'rt_8' => $value->tanggal_8,
                'rt_9' => $value->tanggal_9,
                'rt_10' => $value->tanggal_10,
                'rt_11' => $value->tanggal_11,
                'rt_12' => $value->tanggal_12,
                'rt_13' => $value->tanggal_13,
                'rt_14' => $value->tanggal_14,
                'rt_15' => $value->tanggal_15,
                'rt_16' => $value->tanggal_16,
                'rt_17' => $value->tanggal_17,
                'rt_18' => $value->tanggal_18,
                'rt_19' => $value->tanggal_19,
                'rt_20' => $value->tanggal_20,
                'rt_21' => $value->tanggal_21,
                'rt_22' => $value->tanggal_22,
                'rt_23' => $value->tanggal_23,
                'rt_24' => $value->tanggal_24,
                'rt_25' => $value->tanggal_25,
                'rt_26' => $value->tanggal_26,
                'rt_27' => $value->tanggal_27,
                'rt_28' => $value->tanggal_28,
                'rt_29' => $value->tanggal_29,
                'rt_30' => $value->tanggal_30,
                'rt_31' => $value->tanggal_31,
                'rt_libur' => $value->libur,
                'rt_cuti' => $value->cuti,
                'rt_izin' => $value->izin,
                'rt_sakit' => $value->sakit,
                'rt_absen' => $value->absen,
                'rt_cuti_normatif' => $value->cuti_normatif,
                'rt_dinas' => $value->dinas,
                'rt_hari_kerja' => $value->hari_kerja,
                'rt_tidak_hadir' => $value->tidak_hadir,
                'rt_kehadiran' => $value->kehadiran]);
              } else {
                DB::table('d_rincian_tahunan')
                            ->where('rt_pin', $value->pin)
                            ->where('rt_nip', $value->nip)
                            ->where('rt_nama', $value->nama)
                            ->where('rt_jabatan', $value->jabatan)
                            ->where('rt_departement', $value->departement)
                            ->where('rt_kantor', $value->kantor)
                            ->where('rt_bulan', $value->bulan)
                            ->where('rt_1', $value->tanggal_1)
                            ->where('rt_2', $value->tanggal_2)
                            ->where('rt_3', $value->tanggal_3)
                            ->where('rt_4', $value->tanggal_4)
                            ->where('rt_5', $value->tanggal_5)
                            ->where('rt_6', $value->tanggal_6)
                            ->where('rt_7', $value->tanggal_7)
                            ->where('rt_8', $value->tanggal_8)
                            ->where('rt_9', $value->tanggal_9)
                            ->where('rt_10', $value->tanggal_10)
                            ->where('rt_11', $value->tanggal_11)
                            ->where('rt_12', $value->tanggal_12)
                            ->where('rt_13', $value->tanggal_13)
                            ->where('rt_14', $value->tanggal_14)
                            ->where('rt_15', $value->tanggal_15)
                            ->where('rt_16', $value->tanggal_16)
                            ->where('rt_17', $value->tanggal_17)
                            ->where('rt_18', $value->tanggal_18)
                            ->where('rt_19', $value->tanggal_19)
                            ->where('rt_20', $value->tanggal_20)
                            ->where('rt_21', $value->tanggal_21)
                            ->where('rt_22', $value->tanggal_22)
                            ->where('rt_23', $value->tanggal_23)
                            ->where('rt_24', $value->tanggal_24)
                            ->where('rt_25', $value->tanggal_25)
                            ->where('rt_26', $value->tanggal_26)
                            ->where('rt_27', $value->tanggal_27)
                            ->where('rt_28', $value->tanggal_28)
                            ->where('rt_29', $value->tanggal_29)
                            ->where('rt_30', $value->tanggal_30)
                            ->where('rt_31', $value->tanggal_31)
                            ->where('rt_libur', $value->libur)
                            ->where('rt_cuti', $value->cuti)
                            ->where('rt_izin', $value->izin)
                            ->where('rt_sakit', $value->sakit)
                            ->where('rt_absen', $value->absen)
                            ->where('rt_cuti_normatif', $value->cuti_normatif)
                            ->where('rt_dinas', $value->dinas)
                            ->where('rt_hari_kerja', $value->hari_kerja)
                            ->where('rt_tidak_hadir', $value->tidak_hadir)
                            ->where('rt_kehadiran', $value->kehadiran)
                            ->update([
                              'rt_insert' => Carbon::now('Asia/Jakarta')
                            ]);
              }
            }
          }

          logController::inputlog('Absensi', 'Insert Rincian Tahunan', $path);

          DB::commit();
          Session::flash('sukses', 'Berhasil Disimpan!');
          return redirect('hrd/absensi/absensi');
      } catch (\Exception $e) {
          DB::rollback();
          Session::flash('gagal', 'Gagal Disimpan!');
          return redirect('hrd/absensi/absensi');
      }
    }

    public function managerial(Request $request){
      if (!mMember::akses('PAYROLL', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $path = $request->file('managerial')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();

          if (!empty($data) && $data->count()) {
            foreach ($data as $key => $value) {
              if ($value->pin != null && $value->nip) {
              $check = DB::table('d_payroll_managerial')
                          ->where('pm_pin', $value->pin)
                          ->where('pm_nip', $value->nip)
                          ->where('pm_nama', $value->nama)
                          ->where('pm_jabatan', $value->jabatan)
                          ->where('pm_departement', $value->departement)
                          ->where('pm_kantor', $value->kantor)
                          ->where('pm_status', $value->bulan)
                          ->where('pm_norekening', $value->no_rekening)
                          ->where('pm_gajipokok', $value->gaji_pokok)
                          ->where('pm_uangmakan', $value->uang_makan)
                          ->where('pm_uangtransport', $value->uang_transport)
                          ->where('pm_uangoperasional', $value->uang_operasional)
                          ->where('pm_tunjanganistri', $value->tunjangan_istri)
                          ->where('pm_tunjangananak', $value->tunjangan_anak)
                          ->where('pm_komisisales', $value->komisi_sales)
                          ->where('pm_thr', $value->thr)
                          ->where('pm_insentifpeforma', $value->insentif_peforma)
                          ->where('pm_bonuskpi', $value->bonus_kpi)
                          ->where('pm_bonusloyalitas', $value->bonus_loyalitas)
                          ->where('pm_bonuspeformaperusahaan', $value->bonus_peformaperusahaan)
                          ->where('pm_bpjskes', $value->bpjs_kes)
                          ->where('pm_bpjstk', $value->bpjs_tk)
                          ->where('pm_terlambat', $value->terlambat)
                          ->where('pm_potongandisiplinkerja', $value->potongan_disiplin_kerja)
                          ->where('pm_kasbon', $value->kasbon)
                          ->where('pm_total_gaji_netto', $value->total_gaji_netto)
                          ->count();

              if ($check == 0) {
                DB::table('d_payroll_managerial')
                ->insert([
                'pm_pin' => $value->pin,
                'pm_nip' => $value->nip,
                'pm_nama' => $value->nama,
                'pm_jabatan' => $value->jabatan,
                'pm_departement' => $value->departement,
                'pm_kantor' => $value->kantor,
                'pm_status' => $value->bulan,
                'pm_norekening' => $value->no_rekening,
                'pm_gajipokok' => $value->gaji_pokok,
                'pm_uangmakan' => $value->uang_makan,
                'pm_uangtransport' => $value->uang_transport,
                'pm_uangoperasional' => $value->uang_operasional,
                'pm_tunjanganistri' => $value->tunjangan_istri,
                'pm_tunjangananak' => $value->tunjangan_anak,
                'pm_komisisales' => $value->komisi_sales,
                'pm_thr' => $value->thr,
                'pm_insentifpeforma' => $value->insentif_peforma,
                'pm_bonuskpi' => $value->bonus_kpi,
                'pm_bonusloyalitas' => $value->bonus_loyalitas,
                'pm_bonuspeformaperusahaan' => $value->bonus_peformaperusahaan,
                'pm_bpjskes' => $value->bpjs_kes,
                'pm_bpjstk' => $value->bpjs_tk,
                'pm_terlambat' => $value->terlambat,
                'pm_total_gaji_netto' => $value->total_gaji_netto]);
              } else {
                DB::table('d_rincian_tahunan')
                            ->where('rt_pin', $value->pin)
                            ->where('rt_nip', $value->nip)
                            ->where('rt_nama', $value->nama)
                            ->where('rt_jabatan', $value->jabatan)
                            ->where('rt_departement', $value->departement)
                            ->where('rt_kantor', $value->kantor)
                            ->where('rt_bulan', $value->bulan)
                            ->where('rt_1', $value->tanggal_1)
                            ->where('rt_2', $value->tanggal_2)
                            ->where('rt_3', $value->tanggal_3)
                            ->where('rt_4', $value->tanggal_4)
                            ->where('rt_5', $value->tanggal_5)
                            ->where('rt_6', $value->tanggal_6)
                            ->where('rt_7', $value->tanggal_7)
                            ->where('rt_8', $value->tanggal_8)
                            ->where('rt_9', $value->tanggal_9)
                            ->where('rt_10', $value->tanggal_10)
                            ->where('rt_11', $value->tanggal_11)
                            ->where('rt_12', $value->tanggal_12)
                            ->where('rt_13', $value->tanggal_13)
                            ->where('rt_14', $value->tanggal_14)
                            ->where('rt_15', $value->tanggal_15)
                            ->where('rt_16', $value->tanggal_16)
                            ->where('rt_17', $value->tanggal_17)
                            ->where('rt_18', $value->tanggal_18)
                            ->where('rt_19', $value->tanggal_19)
                            ->where('rt_20', $value->tanggal_20)
                            ->where('rt_21', $value->tanggal_21)
                            ->where('rt_22', $value->tanggal_22)
                            ->where('rt_23', $value->tanggal_23)
                            ->where('rt_24', $value->tanggal_24)
                            ->where('rt_25', $value->tanggal_25)
                            ->where('rt_26', $value->tanggal_26)
                            ->where('rt_27', $value->tanggal_27)
                            ->where('rt_28', $value->tanggal_28)
                            ->where('rt_29', $value->tanggal_29)
                            ->where('rt_30', $value->tanggal_30)
                            ->where('rt_31', $value->tanggal_31)
                            ->where('rt_libur', $value->libur)
                            ->where('rt_cuti', $value->cuti)
                            ->where('rt_izin', $value->izin)
                            ->where('rt_sakit', $value->sakit)
                            ->where('rt_absen', $value->absen)
                            ->where('rt_cuti_normatif', $value->cuti_normatif)
                            ->where('rt_dinas', $value->dinas)
                            ->where('rt_hari_kerja', $value->hari_kerja)
                            ->where('rt_tidak_hadir', $value->tidak_hadir)
                            ->where('rt_kehadiran', $value->kehadiran)
                            ->update([
                              'rt_insert' => Carbon::now('Asia/Jakarta')
                            ]);
              }
              }
            }
          }

          $staff = [];

          logController::inputlog('Payroll', 'Insert Managerial', $path);

          DB::commit();
          Session::flash('sukses', 'Berhasil Disimpan!');
          return view('hrd.payroll.payrollexcel', compact('data', 'staff'));
      } catch (\Exception $e) {
          DB::rollback();
          Session::flash('gagal', 'Gagal Disimpan!');
          return redirect('hrd/payroll/payroll');
      }
    }

    public function staff(Request $request){
      if (!mMember::akses('PAYROLL', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $path = $request->file('staff')->getRealPath();
        $staff = Excel::load($path, function($reader){})->get();

          if (!empty($staff) && $staff->count()) {
            foreach ($staff as $key => $value) {
              if ($value->pin != null && $value->nip) {
              $check = DB::table('d_payroll_staff')
                          ->where('ps_pin', $value->pin)
                          ->where('ps_nip', $value->nip)
                          ->where('ps_nama', $value->nama)
                          ->where('ps_jabatan', $value->jabatan)
                          ->where('ps_departement', $value->departement)
                          ->where('ps_kantor', $value->kantor)
                          ->where('ps_status', $value->bulan)
                          ->where('ps_norekening', $value->no_rekening)
                          ->where('ps_gajipokok', $value->gaji_pokok)
                          ->where('ps_uangmakan', $value->uang_makan)
                          ->where('ps_uangtransport', $value->uang_transport)
                          ->where('ps_uangoperasional', $value->uang_operasional)
                          ->where('ps_tunjanganistri', $value->tunjangan_istri)
                          ->where('ps_tunjangananak', $value->tunjangan_anak)
                          ->where('ps_komisisales', $value->komisi_sales)
                          ->where('ps_thr', $value->thr)
                          ->where('ps_insentifpeforma', $value->insentif_peforma)
                          ->where('ps_bonuskpi', $value->bonus_kpi)
                          ->where('ps_bonusloyalitas', $value->bonus_loyalitas)
                          ->where('ps_bonuspeformaperusahaan', $value->bonus_peformaperusahaan)
                          ->where('ps_bpjskes', $value->bpjs_kes)
                          ->where('ps_bpjstk', $value->bpjs_tk)
                          ->where('ps_terlambat', $value->terlambat)
                          ->where('ps_potongandisiplinkerja', $value->potongan_disiplin_kerja)
                          ->where('ps_kasbon', $value->kasbon)
                          ->where('ps_total_gaji_netto', $value->total_gaji_netto)
                          ->count();

              if ($check == 0) {
                DB::table('d_payroll_staff')
                ->insert([
                'ps_pin' => $value->pin,
                'ps_nip' => $value->nip,
                'ps_nama' => $value->nama,
                'ps_jabatan' => $value->jabatan,
                'ps_departement' => $value->departement,
                'ps_kantor' => $value->kantor,
                'ps_status' => $value->bulan,
                'ps_norekening' => $value->no_rekening,
                'ps_gajipokok' => $value->gaji_pokok,
                'ps_uangmakan' => $value->uang_makan,
                'ps_uangtransport' => $value->uang_transport,
                'ps_uangoperasional' => $value->uang_operasional,
                'ps_tunjanganistri' => $value->tunjangan_istri,
                'ps_tunjangananak' => $value->tunjangan_anak,
                'ps_komisisales' => $value->komisi_sales,
                'ps_thr' => $value->thr,
                'ps_insentifpeforma' => $value->insentif_peforma,
                'ps_bonuskpi' => $value->bonus_kpi,
                'ps_bonusloyalitas' => $value->bonus_loyalitas,
                'ps_bonuspeformaperusahaan' => $value->bonus_peformaperusahaan,
                'ps_bpjskes' => $value->bpjs_kes,
                'ps_bpjstk' => $value->bpjs_tk,
                'ps_terlambat' => $value->terlambat,
                'ps_total_gaji_netto' => $value->total_gaji_netto]);
              } else {
                DB::table('d_payroll_staff')
                            ->where('ps_pin', $value->pin)
                            ->where('ps_nip', $value->nip)
                            ->where('ps_nama', $value->nama)
                            ->where('ps_jabatan', $value->jabatan)
                            ->where('ps_departement', $value->departement)
                            ->where('ps_kantor', $value->kantor)
                            ->where('ps_status', $value->bulan)
                            ->where('ps_norekening', $value->no_rekening)
                            ->where('ps_gajipokok', $value->gaji_pokok)
                            ->where('ps_uangmakan', $value->uang_makan)
                            ->where('ps_uangtransport', $value->uang_transport)
                            ->where('ps_uangoperasional', $value->uang_operasional)
                            ->where('ps_tunjanganistri', $value->tunjangan_istri)
                            ->where('ps_tunjangananak', $value->tunjangan_anak)
                            ->where('ps_komisisales', $value->komisi_sales)
                            ->where('ps_thr', $value->thr)
                            ->where('ps_insentifpeforma', $value->insentif_peforma)
                            ->where('ps_bonuskpi', $value->bonus_kpi)
                            ->where('ps_bonusloyalitas', $value->bonus_loyalitas)
                            ->where('ps_bonuspeformaperusahaan', $value->bonus_peformaperusahaan)
                            ->where('ps_bpjskes', $value->bpjs_kes)
                            ->where('ps_bpjstk', $value->bpjs_tk)
                            ->where('ps_terlambat', $value->terlambat)
                            ->where('ps_potongandisiplinkerja', $value->potongan_disiplin_kerja)
                            ->where('ps_kasbon', $value->kasbon)
                            ->where('ps_total_gaji_netto', $value->total_gaji_netto)
                            ->update([
                              'ps_insert' => Carbon::now('Asia/Jakarta')
                            ]);
              }
              }
            }
          }

          $data = [];

          logController::inputlog('Payroll', 'Insert Staff', $path);

          DB::commit();
          Session::flash('sukses', 'Berhasil Disimpan!');
          return view('hrd.payroll.payrollexcel', compact('data','staff'));
      } catch (\Exception $e) {
          DB::rollback();
          Session::flash('gagal', 'Gagal Disimpan!');
          return redirect('hrd/payroll/payroll');
      }
    }
}
