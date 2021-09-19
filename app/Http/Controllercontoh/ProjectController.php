<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Carbon\Carbon;
use Validator;
use File;
use App\mMember;
use App\Http\Controllers\logController;
use keuangan;

class ProjectController extends Controller
{
    public function dokumentasi()
    {
    	return view('project/dokumentasi/dokumentasi');
    }
    public function jadwalujicoba()
    {
      if (!mMember::akses('SCHEDULE UJI COBA DAN DOKUMENTASI', 'aktif')) {
        return redirect('error-404');
      }
      $data = DB::table('d_schedule')
                ->get();

    	return view('project/jadwalujicoba/jadwalujicoba', compact('data'));
    }
    public function hapus_jadwal(Request $request){
      if (!mMember::akses('SCHEDULE UJI COBA DAN DOKUMENTASI', 'hapus')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $data = DB::table('d_schedule')
            ->where('s_id', $request->id)
            ->first();

        DB::table('d_schedule')
            ->where('s_id', $request->id)
            ->delete();

        DB::table('d_schedule_checklist')
            ->where('sc_schedule', $request->id)
            ->delete();

        DB::table('d_schedule_image')
            ->where('si_schedule', $request->id)
            ->delete();

        DB::table('d_schedule_install')
            ->where('si_schedule', $request->id)
            ->delete();

        $this->deleteDir('image/uploads/dokumentasi/'.$request->id);

        logController::inputlog('Schedule Uji Coba Dan Dokumentasi', 'Hapus', $data->s_title . ' ' . $data->s_description);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollbac();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }
    public function tambah_jadwalujicoba()
    {
      if (!mMember::akses('SCHEDULE UJI COBA DAN DOKUMENTASI', 'tambah')) {
        return redirect('error-404');
      }
        $provinces = DB::table('provinces')
                        ->get();

        $signature = DB::table("m_signature")
                        ->get();

        $regencies = DB::table("regencies")
                        ->get();

        $quotation = DB::select("select q_id, q_nota from d_quotation");

        return view('project/jadwalujicoba/tambah_jadwal', compact('provinces', 'signature', 'quotation', 'regencies'));
    }
    public function quotation(Request $request){
      $data = DB::table('d_quotation')
                ->join('d_quotation_dt', 'qd_id', '=', 'q_id')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->where('q_status', 1)
                ->where('q_id', $request->quotation)
                ->where('i_code', 'LIKE', '%BRG%')
                ->get();

      return response()->json($data);
    }
    public function city(Request $request){
      $data = DB::table('regencies')
                ->where('province_id', $request->hasil)
                ->get();

      return response()->json($data);
    }
    public function simpan_jadwal(Request $request){
      if (!mMember::akses('SCHEDULE UJI COBA DAN DOKUMENTASI', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $idschdule = DB::table('d_schedule')
                      ->max('s_id');

        if ($idschdule == null) {
          $idschdule = 1;
        } else {
          $idschdule += 1;
        }

        DB::table('d_schedule')
          ->insert([
            's_id' => $idschdule,
            's_title' => nl2br($request->judul_laporan),
            's_description' => nl2br($request->deskripsi_laporan),
            's_insert' => Carbon::now('Asia/Jakarta')
          ]);

          for ($z=1; $z <= (int)$request->jumlahimage; $z++) {
            $idimage = DB::table('d_schedule_image')
                          ->max('si_id');

            if ($idimage == null) {
              $idimage = 1;
            } else {
              $idimage += 1;
            }

            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/dokumentasi/' .$idschdule. '/' .$idimage;
            $childPath = $dir . '/';
            $path = $childPath;
            $file = $request->file('image'.($z).'');
            $name = null;
            if ($file != null) {
                $name = $folder . '-' .$idimage. '.' . $file->getClientOriginalExtension();
                        $file->move($path, $name);
                        $imgPath = $childPath . $name;
                } else {
                    $imgPath = null;
                }

            if ($imgPath == null) {

            } else {
              DB::table('d_schedule_image')
                ->insert([
                  'si_id' => $idimage,
                  'si_schedule' => $idschdule,
                  'si_judul' => $request->title[($z - 1)],
                  'si_image' => $imgPath,
                  'si_insert' => Carbon::now('Asia/Jakarta')
                ]);
            }

            }

          $si_id = DB::table('d_schedule_install')
                    ->max('si_id');

          if ($si_id == null) {
            $si_id = 1;
          } else {
            $si_id += 1;
          }

          DB::table('d_schedule_install')
                ->insert([
                  'si_id' => $si_id,
                  'si_schedule' => $idschdule,
                  'si_end_customer' => $request->si_end_customer,
                  'si_installer' => $request->si_installer,
                  'si_contact_data_of_installer' => $request->si_contact_data_of_installer,
                  'si_country' => $request->si_country,
                  'si_province' => $request->si_province,
                  'si_city' => $request->si_city,
                  'si_longitude' => $request->si_longitude,
                  'si_latitude' => $request->si_latitude,
                  'si_installation_date' => Carbon::parse($request->si_installation_date)->format('Y-m-d'),
                  'si_application' => $request->si_application,
                  'si_other_application' => $request->si_other_application,
                  'si_many_people' => $request->si_many_people,
                  'si_many_animal' => $request->si_many_animal,
                  'si_type_animal' => $request->si_type_animal,
                  'si_crop_grown' => $request->si_crop_grown,
                  'si_area' => $request->si_area,
                  'si_satuan_area' => $request->si_satuan_area,
                  'si_pool_size' => $request->si_pool_size,
                  'si_pool_type' => $request->si_pool_type,
                  'si_satuan_pool' => $request->si_satuan_pool,
                  'si_additional_information' => $request->si_additional_information,
                  'si_pump_type' => $request->si_pump_type,
                  'si_pump_pump' => $request->si_pump_pump,
                  'si_pump_controller' => $request->si_pump_controller,
                  'si_controller_serial_number' => $request->si_controller_serial_number,
                  'si_motor_serial_number' => $request->si_motor_serial_number,
                  'si_pump_end_serial_number' => $request->si_pump_end_serial_number,
                  'si_total_dynamic_head' => $request->si_total_dynamic_head,
                  'si_total_dinamyc_satuan' => $request->si_total_dinamyc_satuan,
                  'si_static_head' => $request->si_static_head,
                  'si_daily_flow_rate' => $request->si_daily_flow_rate,
                  'si_water_source' => $request->si_water_source,
                  'si_pipe_lenght' => $request->si_pipe_lenght,
                  'si_pipe_diameter' => $request->si_pipe_diameter,
                  'si_pipe_diameter_satuan' => $request->si_pipe_diameter_satuan,
                  'si_cable_lenght' => $request->si_cable_lenght,
                  'si_type_of_water_storage' => $request->si_type_of_water_storage,
                  'si_size_of_water_storage' => $request->si_size_of_water_storagem,
                  'si_suction_head' => $request->si_suction_head,
                  'si_suction_head_satuan' => $request->si_suction_head_satuan,
                  'si_itlet_pipe_size' => $request->si_itlet_pipe_size,
                  'si_itlet_pipe_size_satuan' => $request->si_itlet_pipe_size_satuan,
                  'si_pv_module_manufacturer' => $request->si_pv_module_manufacturer,
                  'si_model_generator' => $request->si_model_generator,
                  'si_type_generator' => $request->si_type_generator,
                  'si_quantity_generator' => $request->si_quantity_generator,
                  'si_power_each' => $request->si_power_each,
                  'si_power_total' => $request->si_power_total,
                  'si_quantity_battery' => $request->si_quantity_battery,
                  'si_capacity_battery' => $request->si_capacity_battery,
                  'si_voltage_battery' => $request->si_voltage_battery,
                  'si_manufaktur_system' => $request->si_manufaktur_system,
                  'si_type_system' => $request->si_type_system,
                  'si_model_system' => $request->si_model_system,
                  'si_quantity_system' => $request->si_quantity_system,
                  'si_check1' => $request->si_check1,
                  'si_check2' => $request->si_check2,
                  'si_your_name' => $request->si_your_name,
                  'si_signature' => $request->si_signature,
                  'si_email_address' => $request->si_email_address,
                  'si_insert' => Carbon::now('Asia/Jakarta')
                ]);

              for ($i=0; $i < count($request->sc_check); $i++) {
                  if ($request->sc_quantity[$i] == 0 || $request->sc_quantity[$i] == '') {

                  } else {
                     if ($request->sc_check[$i] == '' || $request->sc_check[$i] == null) {
                       $check = 'N';
                     } else {
                       $check = 'Y';
                       if ($request->sc_remarks[$i] == '' || $request->sc_remarks[$i] == null) {

                       } else {
                         $scid = DB::table('d_schedule_checklist')
                                   ->max('sc_id');

                        if ($scid == null) {
                          $scid = 1;
                        } else {
                          $scid += 1;
                        }

                         DB::table('d_schedule_checklist')
                            ->insert([
                              'sc_id' => $scid,
                              'sc_schedule' => $idschdule,
                              'sc_quotation' => $request->si_quotation,
                              'sc_item' => $request->sc_item[$i],
                              'sc_quantity' => $request->sc_quantity[$i],
                              'sc_check' => $check,
                              'sc_remarks' => $request->sc_remarks[$i],
                              'sc_insert' => Carbon::now('Asia/Jakarta')
                            ]);
                       }
                     }
                  }
              }

              logController::inputlog('Schedule Uji Coba Dan Dokumentasi', 'Insert', nl2br($request->judul_laporan) . ' ' . nl2br($request->deskripsi_laporan));

        DB::commit();
        Session::flash('sukses', 'Berhasil Disimpan!');
        return redirect('project/jadwalujicoba/jadwalujicoba');
    } catch (\Exception $e) {
        DB::rollback();
        Session::flash('gagal', 'Gagal Disimpan!');
        return redirect('project/jadwalujicoba/jadwalujicoba');
    }

    }
    public function pdf_jadwal(Request $request)
    {
      if (!mMember::akses('SCHEDULE UJI COBA DAN DOKUMENTASI', 'print')) {
        return redirect('error-404');
      }
      $request->id = decrypt($request->id);
      $data = DB::table('d_schedule')
                ->where('s_id', $request->id)
                ->get();

      $install = DB::table('d_schedule_install')
                ->where('si_schedule', $request->id)
                ->get();

      $image = DB::table('d_schedule_image')
                ->where('si_schedule', $request->id)
                ->get();

      $judul = DB::table('d_schedule_image')
                ->where('si_schedule', $request->id)
                ->select('si_judul')
                ->distinct('si_judul')
                ->get();

        for ($x=0; $x < count($image); $x++) {
          $image[$x]->si_update = DB::table('d_schedule_image')
                                                ->where('si_schedule', $request->id)
                                                ->where('si_judul', $image[$x]->si_judul)
                                                ->count();
        }

      logController::inputlog('Schedule Uji Coba Dan Dokumentasi', 'Print', $data[0]->s_title . ' ' . $data[0]->s_description);

      return view('project/jadwalujicoba/pdf_jadwal', compact('data', 'install', 'image', 'judul'));
    }
    public function pdf_install(Request $request)
    {
      if (!mMember::akses('SCHEDULE UJI COBA DAN DOKUMENTASI', 'print')) {
        return redirect('error-404');
      }
        $request->id = decrypt($request->id);
        $data = DB::table('d_schedule')
                  ->where('s_id', $request->id)
                  ->get();

        $install = DB::table('d_schedule_install')
                  ->where('si_schedule', $request->id)
                  ->leftjoin('m_signature', 's_id', '=', 'si_signature')
                  ->get();

        $quotation = DB::table('d_schedule_checklist')
                      ->join('m_item', 'i_code', '=', 'sc_item')
                      ->where('sc_schedule', $request->id)
                      ->get();

        logController::inputlog('Schedule Uji Coba Dan Dokumentasi', 'Print', $data[0]->s_title . ' ' . $data[0]->s_description);

        return view('project/jadwalujicoba/pdf_install', compact('data', 'install', 'quotation'));
    }
    public function pemasangan()
    {

      if (!mMember::akses('PEMASANGAN', 'aktif')) {
        return redirect('error-404');
      }

      $data = DB::table('d_work_order')
              ->leftjoin('d_quotation', 'q_nota', '=', 'wo_ref')
              ->leftjoin('d_sales_order', 'so_ref', '=', 'q_nota')
              ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
              ->leftjoin('d_perdin', 'p_wo', '=', 'wo_nota')
              ->leftjoin('d_lpj_perdin', 'lp_perdin', '=', 'p_id')
              ->leftjoin('m_pegawai', 'mp_id', '=', 'p_pelaksana')
              ->where('q_remain', 0)
              ->where('wo_status', 'Printed')
              ->where('wo_active', 'Y')
              ->groupby('wo_id')
              ->get();

      $countd = DB::table('d_work_order')
              ->leftjoin('d_quotation', 'q_nota', '=', 'wo_ref')
              ->leftjoin('d_sales_order', 'so_ref', '=', 'q_nota')
              ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
              ->leftjoin('d_perdin', 'p_wo', '=', 'wo_nota')
              ->leftjoin('m_pegawai', 'mp_id', '=', 'p_pelaksana')
              ->where('q_remain', 0)
              ->where('wo_status', 'Printed')
              ->where('wo_active', 'Y')
              ->where('p_status', 'released')
              ->count();

      $countp = DB::table('d_work_order')
              ->leftjoin('d_quotation', 'q_nota', '=', 'wo_ref')
              ->leftjoin('d_sales_order', 'so_ref', '=', 'q_nota')
              ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
              ->leftjoin('d_perdin', 'p_wo', '=', 'wo_nota')
              ->leftjoin('m_pegawai', 'mp_id', '=', 'p_pelaksana')
              ->where('q_remain', 0)
              ->where('wo_status', 'Printed')
              ->where('wo_active', 'Y')
              ->where('p_status', 'acc')
              ->count();

      $countpd = DB::table('d_work_order')
              ->leftjoin('d_quotation', 'q_nota', '=', 'wo_ref')
              ->leftjoin('d_sales_order', 'so_ref', '=', 'q_nota')
              ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
              ->leftjoin('d_perdin', 'p_wo', '=', 'wo_nota')
              ->leftjoin('m_pegawai', 'mp_id', '=', 'p_pelaksana')
              ->where('q_remain', 0)
              ->where('wo_status', 'Printed')
              ->where('wo_active', 'Y')
              ->where('p_status', 'revition')
              ->count();

      $bank = DB::table('m_bank')->get();

    	return view('project/pemasangan/pemasangan', compact('data','countd','countp','countpd', 'bank'));
    }
    public function prosespemasangan($id){
      if (!mMember::akses('PEMASANGAN', 'tambah')) {
        return redirect('error-404');
      }
      $data = DB::table('d_work_order')
          ->leftjoin('d_quotation', 'q_nota', '=', 'wo_ref')
          ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
          ->where('wo_id', $id)
          ->get();

      $barang = DB::table('d_quotation_dt')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->join('d_unit', 'u_id', '=', 'i_unit')
                ->where('i_code', 'LIKE', '%BJS%')
                ->where('qd_id', $data[0]->q_id)
                ->get();

      $pelaksana = DB::table('m_pegawai')
                      ->get();

      $querykode = DB::select(DB::raw("SELECT MAX(MID(p_code,4,3)) as counter FROM d_perdin"));

      if (count($querykode) > 0) {
          foreach($querykode as $k)
            {
              $tmp = ((int)$k->counter)+1;
              $kode = sprintf("%02s", $tmp);
            }
      } else {
        $kode = "001";
      }


      $finalkode = 'EP-' . $kode . '/' . date('m') . date('Y');

      for ($i=0; $i < count($barang); $i++) {
        if ($barang[$i]->qd_description == null) {
          $barang[$i]->qd_description = ' ';
        }
      }

      logController::inputlog('Pemasangan', 'Insert', '');

    	return view('project/pemasangan/prosespemasangan', compact('data', 'barang', 'pelaksana', 'finalkode'));
    }
    public function simpanpemasangan(Request $request){
      if (!mMember::akses('PEMASANGAN', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('d_install')
              ->max('i_id');

              if ($id < 0) {
                $id = 0;
              }

              $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(i_io,4,3)) as counter FROM d_install"));

        if (count($querykode) > 0) {
            foreach($querykode as $k)
              {
                $tmp = ((int)$k->counter)+1;
                $kode = sprintf("%02s", $tmp);
              }
        } else {
          $kode = "001";
        }


        $finalkode = 'IO-' . $kode . '/' . date('m') . date('Y');

        DB::table('d_install')
          ->insert([
            'i_id' => $id + 1,
            'i_wo' => $request->d_wo,
            'i_io' => $finalkode,
            'i_status' => 'PD',
            'i_instalation_date' => Carbon::parse($request->i_instalation_date)->format('Y-m-d'),
            'i_location' => $request->i_location,
            'i_installer' => $request->i_installer,
            'i_active' => 'Y',
            'i_insert' => Carbon::now('Asia/Jakarta')
          ]);

          DB::table('d_work_order')
            ->where('wo_nota', $request->d_wo)
            ->update([
              'wo_status_install' => 'PD',
              'wo_active' => 'Y'
            ]);

            logController::inputlog('Pemasangan', 'Insert', $request->d_wo . ' ' . $finalkode);

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
    public function editpemasangan(Request $request){
      if (!mMember::akses('PEMASANGAN', 'ubah')) {
        return redirect('error-404');
      }
      $wo = DB::table('d_work_order')
              ->select('wo_nota')
              ->Where('wo_id', $request->id)
              ->get();

      $data = DB::table('d_install')
                ->select('i_wo')
                ->where('i_wo', $wo[0]->wo_nota)
                ->get();

      return response()->json($data);
    }
    public function ubahpemasangan(Request $request){
      if (!mMember::akses('PEMASANGAN', 'ubah')) {
        return redirect('error-404');
      }
      $id = $request->id;

      $data = DB::table('d_work_order')
          ->leftjoin('d_quotation', 'q_nota', '=', 'wo_ref')
          ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
          ->where('wo_id', $id)
          ->get();

      $barang = DB::table('d_quotation_dt')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->join('d_unit', 'u_id', '=', 'i_unit')
                ->where('i_code', 'LIKE', '%BJS%')
                ->where('qd_id', $data[0]->q_id)
                ->get();

      for ($i=0; $i < count($barang); $i++) {
        if ($barang[$i]->qd_description == null) {
          $barang[$i]->qd_description = '';
        }
      }

      $install = DB::table('d_install')
                  ->where('i_wo', $data[0]->wo_nota)
                  ->where('i_active', 'Y')
                  ->get();

      logController::inputlog('Pemasangan', 'Update', '');

      return view('project.pemasangan.editprosespemasangan', compact('data','barang','install'));
    }
    public function perbaruipemasangan(Request $request){
      if (!mMember::akses('PEMASANGAN', 'ubah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        DB::table('d_install')
          ->where('i_io', $request->i_io)
          ->where('i_active', 'Y')
          ->update([
            'i_instalation_date' => Carbon::parse($request->i_instalation_date)->format('Y-m-d'),
            'i_location' => $request->i_location,
            'i_installer' => $request->i_installer
          ]);

          logController::inputlog('Pemasangan', 'Update', $request->i_io);
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
    public function settingpemasangan(Request $request){
      if (!mMember::akses('PEMASANGAN', 'ubah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $validation = Validator::make($request->all(), [
                 'i_wo' => 'required',
                 'i_report_date' => 'required',
                 'i_notes' => 'required',
             ]);

       if ($validation->fails()) {
           return response()->json([
             'status' => 'kesalahan'
           ]);
        } else {
          DB::table('d_install')
            ->where('i_wo', $request->i_wo)
            ->where('i_active', 'Y')
            ->update([
              'i_report_date' => Carbon::parse($request->d_delivery_date)->format('Y-m-d'),
              'i_notes' => $request->i_notes,
              'i_status' => 'D',
              'i_update' => Carbon::now('Asia/Jakarta')
            ]);

          DB::table('d_work_order')
            ->where('wo_nota', $request->i_wo)
            ->update([
              'wo_status_install' => 'D'
            ]);
        }
        logController::inputlog('Pemasangan', 'Update', $request->i_wo);
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
    public function hapuspemasangan(Request $request){
      if (!mMember::akses('PEMASANGAN', 'hapus')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $wo = DB::table('d_work_order')
          ->where('wo_id', $request->id)
          ->get();

        DB::table('d_work_order')
          ->where('wo_id', $request->id)
          ->update([
            'wo_active' => 'N'
          ]);

        $check = DB::table('d_install')
                  ->where('i_wo', $wo[0]->wo_nota)
                  ->count();

        if ($check != 0) {
          DB::table('d_install')
              ->where('i_wo', $wo[0]->wo_nota)
              ->update([
                'i_active' => 'N',
                'i_update' => Carbon::now('Asia/Jakarta')
              ]);
        }

        logController::inputlog('Pemasangan', 'Hapus', $wo[0]->wo_nota);

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
    public function pengadaanbarang()
    {
    	return view('project/pengadaanbarang/pengadaanbarang');
    }
    public function prosespengadaanbarang()
    {
    	return view('project/pengadaanbarang/prosespengadaanbarang');
    }
    public function pengepakanbarang()
    {
    	return view('project/pengepakanbarang/pengepakanbarang');
    }
    public function pengirimanbarang()
    {
      if (!mMember::akses('PENGIRIMAN BARANG', 'aktif')) {
        return redirect('error-404');
      }

      $data = DB::table('d_sales_order')
              ->leftjoin('d_quotation', 'q_nota', '=', 'so_ref')
              ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
              ->leftjoin('d_delivery', 'd_so', '=', 'so_nota')
              ->where('so_active', 'Y')
              ->orderBy('so_date', 'DESC')
              ->get();

      $countd = DB::table('d_sales_order')
                ->where('so_status_delivery', 'D')
                ->where('so_active', 'Y')
                ->count();

      $countp = DB::table('d_sales_order')
                ->where('so_status_delivery', 'P')
                ->where('so_active', 'Y')
                ->count();

      $countpd = DB::table('d_sales_order')
                ->where('so_status_delivery', 'PD')
                ->where('so_active', 'Y')
                ->count();

    	return view('project/pengirimanbarang/pengirimanbarang', compact('data','countd','countp','countpd'));
    }
    public function prosespengirimanbarang($id)
    {
      if (!mMember::akses('PENGIRIMAN BARANG', 'tambah')) {
        return redirect('error-404');
      }
      $data = DB::table('d_sales_order')
          ->leftjoin('d_quotation', 'q_nota', '=', 'so_ref')
          ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
          ->where('so_id', $id)
          ->get();

      $barang = DB::table('d_quotation_dt')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->join('d_unit', 'u_id', '=', 'i_unit')
                ->where('qd_id', $data[0]->q_id)
                ->where('qd_item', 'LIKE', '%BRG%')
                ->get();

      for ($i=0; $i < count($barang); $i++) {
        if ($barang[$i]->qd_description == null) {
          $barang[$i]->qd_description = ' ';
        }
      }

    	return view('project/pengirimanbarang/prosespengirimanbarang', compact('data', 'barang'));
    }
    public function edit(Request $request){
      if (!mMember::akses('PENGIRIMAN BARANG', 'ubah')) {
        return redirect('error-404');
      }
      $so = DB::table('d_sales_order')
              ->select('so_nota')
              ->Where('so_id', $request->id)
              ->get();

      $data = DB::table('d_delivery')
                ->select('d_so', 'd_delivery_date')
                ->where('d_so', $so[0]->so_nota)
                ->get();

      $data[0]->d_delivery_date = Carbon::parse($data[0]->d_delivery_date)->format('d-m-Y');

      return response()->json($data);
    }
    public function proses(Request $request){
      if (!mMember::akses('PENGIRIMAN BARANG', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('d_delivery')
              ->max('d_id');

              if ($id < 0) {
                $id = 0;
              }

              $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(d_do,4,3)) as counter FROM d_delivery"));

        if (count($querykode) > 0) {
            foreach($querykode as $k)
              {
                $tmp = ((int)$k->counter)+1;
                $kode = sprintf("%02s", $tmp);
              }
        } else {
          $kode = "001";
        }


        $finalkode = 'DO-' . $kode . '/' . date('m') . date('Y');

        if ($request->d_shipping_charges == "") {
          $d_shipping_charges = 0;
        } else {
          $d_shipping_charges = str_replace('Rp. ', '', $request->d_shipping_charges);
          $d_shipping_charges = str_replace('.', '', $d_shipping_charges);
        }

        DB::table('d_delivery')
          ->insert([
            'd_id' => $id + 1,
            'd_so' => $request->d_so,
            'd_do' => $finalkode,
            'd_status' => 'PD',
            'd_delivery_date' => Carbon::parse($request->d_delivery_date)->format('Y-m-d'),
            'd_shipping_charges' => $d_shipping_charges,
            'd_active' => 'Y',
            'd_insert' => Carbon::now('Asia/Jakarta')
          ]);

          DB::table('d_sales_order')
            ->where('so_nota', $request->d_so)
            ->update([
              'so_status_delivery' => 'PD',
              'so_active' => 'Y'
            ]);

            $data = DB::table('d_sales_order')
                ->leftjoin('d_quotation', 'q_nota', '=', 'so_ref')
                ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
                ->where('so_nota', $request->d_so)
                ->get();

            $barang = DB::table('d_quotation_dt')
                      ->join('m_item', 'i_code', '=', 'qd_item')
                      ->join('d_unit', 'u_id', '=', 'i_unit')
                      ->where('qd_id', $data[0]->q_id)
                      ->where('qd_item', 'LIKE', '%BRG%')
                      ->get();


                for ($i = 0; $i < count($barang); $i++) {

                    $stock = DB::table('i_stock_gudang')
                        ->join('i_stock_mutasi', 'sm_id', '=', 'sg_id')
                        ->select('i_stock_gudang.*', 'i_stock_mutasi.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
                        ->where('sg_iditem', $barang[$i]->qd_item)
                        ->where(DB::raw('(sm_qty - sm_use)'), '>', 0)
                        ->get();

                    if (count($stock) == 0) {
                        return response()->json([
                          'status' => 'stock kurang',
                          'ket' => 'Stock ' . $barang[$i]->i_code . ' - ' . $barang[$i]->i_name . ' kurang'
                        ]);

                    } else {
                      $permintaan = $barang[$i]->qd_qty;

                      DB::table('i_stock_gudang')
                          ->where('sg_id', $stock[0]->sm_id)
                          ->where('sg_iditem', $stock[0]->sm_item)
                          ->update([
                              'sg_qty' => $stock[0]->sg_qty - $permintaan
                          ]);

                      for ($j = 0; $j < count($stock); $j++) {
                          //Terdapat sisa permintaan

                          $detailid = DB::table('i_stock_mutasi')
                              ->max('sm_iddetail');

                          if ($permintaan > $stock[$j]->sm_sisa && $permintaan != 0) {

                              DB::table('i_stock_mutasi')
                                  ->where('sm_id', '=', $stock[$j]->sm_id)
                                  ->where('sm_iddetail', '=', $stock[$j]->sm_iddetail)
                                  ->update([
                                      'sm_use' => $stock[$j]->sm_qty
                                  ]);

                              $permintaan = $permintaan - $stock[$j]->sm_sisa;

                              DB::table('i_stock_mutasi')
                                  ->insert([
                                      'sm_id' => $stock[$j]->sm_id,
                                      'sm_iddetail' => $detailid + 1,
                                      'sm_item' => $barang[$i]->qd_item,
                                      'sm_qty' => $stock[$j]->sm_sisa,
                                      'sm_use' => 0,
                                      'sm_hpp' => $stock[$j]->sm_hpp,
                                      'sm_deliveryorder' => $stock[$j]->sm_deliveryorder
                                  ]);

                          } elseif ($permintaan <= $stock[$j]->sm_sisa && $permintaan != 0) {
                              //Langsung Eksekusi

                              $detailid = DB::table('i_stock_mutasi')
                                  ->max('sm_iddetail');

                              DB::table('i_stock_mutasi')
                                  ->where('sm_id', '=', $stock[$j]->sm_id)
                                  ->where('sm_iddetail', '=', $stock[$j]->sm_iddetail)
                                  ->update([
                                      'sm_use' => $permintaan + $stock[$j]->sm_use
                                  ]);

                              DB::table('i_stock_mutasi')
                                  ->insert([
                                      'sm_id' => $stock[$j]->sm_id,
                                      'sm_iddetail' => $detailid + 1,
                                      'sm_item' => $barang[$i]->qd_item,
                                      'sm_qty' => $permintaan,
                                      'sm_use' => 0,
                                      'sm_hpp' => $stock[$j]->sm_hpp,
                                      'sm_deliveryorder' => $stock[$j]->sm_deliveryorder
                                  ]);

                              $permintaan = 0;
                              $j = count($stock) + 1;
                          }
                      }
                    }
                }

                for ($i=0; $i < count($request->accin); $i++) {

                  $id = DB::table('d_accessories')->max('a_id')+1;

                  $tmp = DB::table('d_sales_order')
                            ->where('so_nota', $request->d_so)
                            ->first();

                  DB::table('d_accessories')
                        ->insert([
                          'a_id' => $id,
                          'a_so' => $tmp->so_id,
                          'a_acc' => $request->accin[$i],
                          'a_description' => $request->desc[$i],
                          'a_qty' => $request->qty[$i]
                        ]);
                }

            logController::inputlog('Pengiriman Barang', 'Insert', $finalkode);

            // Tambahan Dirga
                $jurnalDetail = [];

                $items = DB::table('d_quotation_dt')
                              ->join('m_item', 'i_code', '=', 'qd_item')
                              ->where('qd_id', $data[0]->q_id)
                              ->where('qd_item', 'LIKE', '%BRG%')
                              ->select('i_id', 'qd_qty', 'qd_total')
                              ->get();

                foreach($items as $keynote => $item){
                  $akunPersediaan = DB::table('m_item')->where('i_id', $item->i_id)->select('i_akun_persediaan')->first();
                  $akunBeban = DB::table('m_item')->where('i_id', $item->i_id)->select('i_akun_beban')->first();

                  if(!$akunPersediaan || $akunPersediaan->i_akun_persediaan == null || !$akunBeban || $akunBeban->i_akun_beban == null)
                    return 'error';

                  // pendapatan

                  if(!array_key_exists($akunPersediaan->i_akun_persediaan, $jurnalDetail)){
                    $jurnalDetail[$akunPersediaan->i_akun_persediaan] = [
                        "jrdt_akun"   => $akunPersediaan->i_akun_persediaan,
                        "jrdt_value"  => $item->qd_total,
                        "jrdt_dk"     => 'K'
                    ];
                  }else{
                    $jurnalDetail[$akunPersediaan->i_akun_persediaan]['jrdt_value'] += $item->qd_total;
                  }


                  if(!array_key_exists($akunBeban->i_akun_beban, $jurnalDetail)){
                    $jurnalDetail[$akunBeban->i_akun_beban] = [
                        "jrdt_akun"   => $akunBeban->i_akun_beban,
                        "jrdt_value"  => $item->qd_total,
                        "jrdt_dk"     => 'D'
                    ];
                  }else{
                    $jurnalDetail[$akunBeban->i_akun_beban]['jrdt_value'] += $item->qd_total;
                  }

                }

                keuangan::jurnal()->addJurnal($jurnalDetail, date('Y-m-d'), $finalkode.' (printed)', 'Pengirman Barang Atas Nota SO : '.$request->d_so, 'MM', modulSetting()['onLogin'], true);

            // Selesai Dirga

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
    public function ubah(Request $request){
      if (!mMember::akses('PENGIRIMAN BARANG', 'ubah')) {
        return redirect('error-404');
      }
      $id = $request->id;

      $data = DB::table('d_sales_order')
          ->leftjoin('d_quotation', 'q_nota', '=', 'so_ref')
          ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
          ->where('so_id', $id)
          ->get();

      $barang = DB::table('d_quotation_dt')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->join('d_unit', 'u_id', '=', 'i_unit')
                ->where('i_code', 'LIKE', '%BRG%')
                ->where('qd_id', $data[0]->q_id)
                ->get();

      for ($i=0; $i < count($barang); $i++) {
        if ($barang[$i]->qd_description == null) {
          $barang[$i]->qd_description = '';
        }
      }

      $delivery = DB::table('d_delivery')
                  ->where('d_so', $data[0]->so_nota)
                  ->where('d_active', 'Y')
                  ->get();

      $acc = DB::table('d_accessories')
                ->where('a_so', $id)
                ->get();

      return view('project.pengirimanbarang.editprosespengiriman', compact('acc','data','barang','delivery'));
    }
    public function setting(Request $request){
      if (!mMember::akses('PENGIRIMAN BARANG', 'ubah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $validation = Validator::make($request->all(), [
                 'd_delivery_date' => 'required',
                 'd_so' => 'required',
                 'd_receiver' => 'required',
                 'd_receive_date' => 'required',
             ]);

       if ($validation->fails()) {
           return response()->json([
             'status' => 'kesalahan'
           ]);
        } else {
          DB::table('d_delivery')
            ->where('d_so', $request->d_so)
            ->where('d_active', 'Y')
            ->update([
              'd_delivery_date' => Carbon::parse($request->d_delivery_date)->format('Y-m-d'),
              'd_receive_date' => Carbon::parse($request->d_receive_date)->format('Y-m-d'),
              'd_receiver' => $request->d_receiver,
              'd_status' => 'D',
              'd_update' => Carbon::now('Asia/Jakarta')
            ]);

          DB::table('d_sales_order')
            ->where('so_nota', $request->d_so)
            ->update([
              'so_status_delivery' => 'D'
            ]);
        }
        logController::inputlog('Pengiriman Barang', 'Update', '');
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
      if (!mMember::akses('PENGIRIMAN BARANG', 'hapus')) {
        return redirect('error-404');
      }
    DB::beginTransaction();
    try {

      $so = DB::table('d_sales_order')
        ->where('so_id', $request->id)
        ->get();

      DB::table('d_sales_order')
        ->where('so_id', $request->id)
        ->update([
          'so_active' => 'N'
        ]);

      $check = DB::table('d_delivery')
                ->where('d_so', $so[0]->so_nota)
                ->count();

      if ($check != 0) {
        DB::table('d_delivery')
            ->where('d_so', $so[0]->so_nota)
            ->update([
              'd_active' => 'N',
              'd_update' => Carbon::now('Asia/Jakarta')
            ]);

            logController::inputlog('Pengiriman Barang', 'Hapus', '');
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
    public function perbarui(Request $request){
      if (!mMember::akses('PENGIRIMAN BARANG', 'ubah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        // return 'aaa';

        $request->d_shipping_charges = str_replace('Rp. ','',$request->d_shipping_charges);
        $request->d_shipping_charges = str_replace('.','',$request->d_shipping_charges);

        DB::table('d_delivery')
          ->where('d_do', $request->nota)
          ->where('d_active', 'Y')
          ->update([
            'd_delivery_date' => Carbon::parse($request->d_delivery_date)->format('Y-m-d'),
            'd_shipping_charges' => $request->d_shipping_charges
          ]);

          $so = DB::table('d_sales_order')->where('so_nota', $request->d_so)->first();

          DB::table('d_accessories')->where('a_so', $so->so_id)->delete();

          for ($i=0; $i < count($request->accin); $i++) {

            $id = DB::table('d_accessories')->max('a_id')+1;

            $tmp = DB::table('d_sales_order')
                      ->where('so_nota', $request->d_so)
                      ->first();

            DB::table('d_accessories')
                  ->insert([
                    'a_id' => $id,
                    'a_so' => $so->so_id,
                    'a_acc' => $request->accin[$i],
                    'a_description' => $request->desc[$i],
                    'a_qty' => $request->qty[$i]
                  ]);
          }

          logController::inputlog('Pengiriman Barang', 'Update', $request->nota);

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
    public function salescommon()
    {
    	return view('project/salescommon/salescommon');
    }
    public function technicianfee()
    {
      if (!mMember::akses('TECHNICIAN FEE', 'aktif')) {
        return redirect('error-404');
      }

    	return view('project/technicianfee/technicianfee');
    }
    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return false;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    public function suratjalan(){
      $data = DB::table('d_suratjalan')
                ->leftjoin('d_sales_order', 'so_nota', '=', 's_so')
                ->leftjoin('d_quotation', 'q_nota', '=', 'so_ref')
                ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
                ->get();

      return view('project.suratjalan.suratjalan', compact('data'));
    }
    public function tambah_suratjalan(){
      $so = DB::table('d_sales_order')
                ->where('so_status', 'Printed')
                ->get();

      $querykode = DB::select(DB::raw("SELECT MAX(MID(s_code,4,3)) as counter FROM d_suratjalan"));

      if (count($querykode) > 0) {
          foreach($querykode as $k)
            {
              $tmp = ((int)$k->counter)+1;
              $kode = sprintf("%02s", $tmp);
            }
      } else {
        $kode = "001";
      }


      $finalkode = 'SJ-' . $kode . '/' . date('m') . date('Y');

      $ekspedisi = DB::table('m_ekspedisi')
                      ->get();

      return view('project.suratjalan.tambah_suratjalan', compact('ekspedisi', 'finalkode', 'so'));
    }
    public function print_suratjalan(Request $request){
      $data = DB::table('d_suratjalan')
                ->leftjoin('d_sales_order', 'so_nota', '=', 's_so')
                ->leftjoin('d_quotation', 'q_nota', '=', 'so_ref')
                ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
                ->leftjoin('m_ekspedisi', 'e_id', '=', 's_ekspedisi')
                ->where('s_id', $request->id)
                ->get();

      $dt = DB::table('d_suratjalan_dt')
                ->where('sd_suratjalan', $data[0]->s_id)
                ->get();

      return view('project.suratjalan.print_suratjalan', compact('data', 'dt'));
    }

    public function getso(Request $request){
      $so = DB::table('d_sales_order')
              ->where('so_nota', $request->so)
              ->first();

      $data = DB::table('d_quotation')
                ->join('d_quotation_dt', 'qd_id', '=', 'q_id')
                ->join('m_customer', 'c_code', '=', 'q_customer')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->join('d_unit', 'u_id', '=', 'i_unit')
                ->where('q_nota', $so->so_ref)
                ->where('qd_item', 'LIKE', '%BRG%')
                ->get();

      return response()->json($data);
    }

    public function simpansj(Request $request){
      DB::beginTransaction();
      try {

        $cek = DB::table('d_suratjalan')
                  ->where('s_code', $request->nodo)
                  ->count();

        if ($cek != 0) {
          return response()->json([
            'status' => 'digunakan'
          ]);
        } else {
          $id = DB::table('d_suratjalan')->max('s_id')+1;

          DB::table('d_suratjalan')
                ->insert([
                  's_id' => $id,
                  's_code' => $request->nodo,
                  's_so' => $request->do,
                  's_ekspedisi' => $request->ekspedisi,
                  's_insert' => Carbon::now('Asia/Jakarta')
                ]);

          for ($i=0; $i < count($request->banyakin); $i++) {
            $dt = DB::table('d_suratjalan_dt')->max('sd_id')+1;

            DB::table('d_suratjalan_dt')
                  ->insert([
                    'sd_id' => $dt,
                    'sd_suratjalan' => $id,
                    'sd_banyaknya' => $request->banyakin[$i],
                    'sd_barang' => $request->itemin[$i],
                    'sd_insert' => Carbon::now('Asia/Jakarta'),
                    'sd_update' => Carbon::now('Asia/Jakarta')
                  ]);
          }
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
    public function print_checklistform(Request $request){
      $data = DB::table('d_sales_order')
                  ->leftjoin('d_quotation', 'so_ref', '=', 'q_nota')
                  ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
                  ->leftjoin('d_delivery', 'd_so', '=', 'so_nota')
                  ->where('so_id', $request->id)
                  ->first();

      $item = DB::table('d_quotation')->join('d_quotation_dt', 'qd_id', '=', 'q_id')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->where('q_nota', $data->so_ref)
                ->where('qd_item', 'LIKE', '%BRG%')
                ->get();

      $acc = DB::table('d_accessories')->where('a_so', $request->id)->get();

      return view('project.pengirimanbarang.print_checklistform', compact('data','item','acc'));
    }
    public function gettanggung(Request $request){
      $tanggung = Carbon::parse($request->enddate)->format('d-m-Y');
      $tanggung = Carbon::parse($tanggung)->addDays(4);
      $tanggung = Carbon::parse($tanggung)->format('d-m-Y');

      return response()->json($tanggung);
    }
    public function simpanperdin(Request $request){
      DB::beginTransaction();
      try {

        $id = DB::table('d_perdin')->max('p_id')+1;

        $total = [];
        for ($i=0; $i < count($request->keterangan); $i++) {
          $tmp = str_replace('.', '', $request->jumlah[$i]);
          $tmp = (int)$tmp;
          $total[$i] = $tmp;
        }


        DB::table('d_perdin')
            ->insert([
              'p_id' => $id,
              'p_customer' => $request->customer,
              'p_wo' => $request->codewo,
              'p_code' => $request->codeperdin,
              'p_pengajuan' => Carbon::parse($request->pengajuandate)->format('Y-m-d'),
              'p_pelaksana' => $request->pelaksana,
              'p_proyek' => $request->proyek,
              'p_dinas_start' => Carbon::parse($request->dinasstart)->format('Y-m-d'),
              'p_lokasi' => $request->lokasi,
              'p_total' => array_sum($total),
              'p_dinas_end' => Carbon::parse($request->dinasend)->format('Y-m-d'),
              'p_tanggung_jawab' => Carbon::parse($request->tanggung)->format('Y-m-d'),
              'p_insert' => Carbon::now('Asia/Jakarta')
            ]);

        for ($i=0; $i < count($request->keterangan); $i++) {
          $dt = DB::table('d_perdin_dt')->max('pd_id')+1;
          DB::table('d_perdin_dt')
              ->insert([
                'pd_id' => $dt,
                'pd_perdin' => $id,
                'pd_keterangan' => $request->keterangan[$i],
                'pd_jumlah' => str_replace('.', '', $request->jumlah[$i])
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
    public function editperdin(Request $request){
      $id = $request->id;
      $data = DB::table('d_work_order')
          ->leftjoin('d_quotation', 'q_nota', '=', 'wo_ref')
          ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
          ->where('wo_id', $request->id)
          ->get();

      $barang = DB::table('d_quotation_dt')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->join('d_unit', 'u_id', '=', 'i_unit')
                ->where('i_code', 'LIKE', '%BJS%')
                ->where('qd_id', $data[0]->q_id)
                ->get();

      $pelaksana = DB::table('m_pegawai')
                      ->get();

      $perdin = DB::table('d_perdin')
                    ->where('p_wo', $data[0]->wo_nota)
                    ->first();

      $perdindt = DB::table('d_perdin_dt')
                    ->where('pd_perdin', $perdin->p_id)
                    ->get();

      return view('project.pemasangan.editprosespemasangan', compact('id', 'data', 'barang', 'pelaksana', 'perdin', 'perdindt'));
    }
    public function detailperdin(Request $request){
      $id = $request->id;
      $data = DB::table('d_work_order')
          ->leftjoin('d_quotation', 'q_nota', '=', 'wo_ref')
          ->leftjoin('m_customer', 'c_code', '=', 'q_customer')
          ->where('wo_id', $request->id)
          ->get();

      $barang = DB::table('d_quotation_dt')
                ->join('m_item', 'i_code', '=', 'qd_item')
                ->join('d_unit', 'u_id', '=', 'i_unit')
                ->where('i_code', 'LIKE', '%BJS%')
                ->where('qd_id', $data[0]->q_id)
                ->get();

      $pelaksana = DB::table('m_pegawai')
                      ->get();

      $perdin = DB::table('d_perdin')
                    ->where('p_wo', $data[0]->wo_nota)
                    ->first();

      $perdindt = DB::table('d_perdin_dt')
                    ->where('pd_perdin', $perdin->p_id)
                    ->get();

      return view('project.pemasangan.detail', compact('id', 'data', 'barang', 'pelaksana', 'perdin', 'perdindt'));
    }
    public function updateperdin(Request $request){
      DB::beginTransaction();
      try {
        $wo = DB::table('d_work_order')->where('wo_id', $request->id)->first();

        $perdin = DB::table('d_perdin')->where('p_wo', $wo->wo_nota)->first();

        DB::table('d_perdin')->where('p_id', $perdin->p_id)->delete();
        DB::table('d_perdin_dt')->where('pd_perdin', $perdin->p_id)->delete();

        $id = $perdin->p_id;
        $nota = $perdin->p_code;

        $total = [];
        for ($i=0; $i < count($request->keterangan); $i++) {
          $tmp = str_replace('.', '', $request->jumlah[$i]);
          $tmp = (int)$tmp;
          $total[$i] = $tmp;
        }

        DB::table('d_perdin')
            ->insert([
              'p_id' => $id,
              'p_customer' => $request->customer,
              'p_wo' => $request->codewo,
              'p_code' => $nota,
              'p_pengajuan' => Carbon::parse($request->pengajuandate)->format('Y-m-d'),
              'p_pelaksana' => $request->pelaksana,
              'p_proyek' => $request->proyek,
              'p_total' => array_sum($total),
              'p_dinas_start' => Carbon::parse($request->dinasstart)->format('Y-m-d'),
              'p_lokasi' => $request->lokasi,
              'p_dinas_end' => Carbon::parse($request->dinasend)->format('Y-m-d'),
              'p_tanggung_jawab' => Carbon::parse($request->tanggung)->format('Y-m-d'),
              'p_insert' => Carbon::now('Asia/Jakarta')
            ]);

        for ($i=0; $i < count($request->keterangan); $i++) {
          $dt = DB::table('d_perdin_dt')->max('pd_id')+1;
          DB::table('d_perdin_dt')
              ->insert([
                'pd_id' => $dt,
                'pd_perdin' => $id,
                'pd_keterangan' => $request->keterangan[$i],
                'pd_jumlah' => str_replace('.', '', $request->jumlah[$i])
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
    public function transaksiup(Request $request){
      if ($request->transaksi == 'transfer') {
        $data = DB::table('dk_akun')->where('ak_kelompok', '1.002')->get();
      } elseif ($request->transaksi == 'tunai') {
        $data = DB::table('dk_akun')->where('ak_kelompok', '1.001')->get();
      }

      return response()->json($data);
    }
    public function getkasbon(Request $request){
      $wo = DB::table('d_work_order')->where('wo_id', $request->id)->first();

      $nominal = DB::table('d_perdin')->where('p_wo', $wo->wo_nota)
                    ->join('d_perdin_dt', 'pd_perdin', '=', 'p_id')
                    ->sum('pd_jumlah');

      $querykode = DB::select(DB::raw("SELECT MAX(MID(k_code,4,3)) as counter FROM d_kasbon"));

      if (count($querykode) > 0) {
          foreach($querykode as $k)
            {
              $tmp = ((int)$k->counter)+1;
              $kode = sprintf("%02s", $tmp);
            }
      } else {
        $kode = "001";
      }


      $finalkode = 'KS-' . $kode . '/' . date('m') . date('Y');

      return response()->json([
        'nominal' => $nominal,
        'finalkode' => $finalkode
      ]);
    }
    public function simpankasbon(Request $request){
      DB::beginTransaction();
      try {
        $wo = DB::table('d_work_order')->where('wo_id', $request->id)->first();

        $perdin = DB::table('d_perdin')->where('p_wo', $wo->wo_nota)->first();

        $id = DB::table('d_kasbon')->max('k_id')+1;

        $request->diberikan = str_replace('.', '', $request->diberikan);

        DB::table('d_kasbon')
            ->insert([
              'k_id' => $id,
              'k_code' => $request->nokasbon,
              'k_perdin' => $perdin->p_id,
              'k_diberikan' => str_replace('.','', $request->diberikan),
              'k_date' => Carbon::parse($request->diberikantanggal)->format('Y-m-d'),
              'k_transfer' => $request->transferbank,
              'k_transaksi' => $request->transaksi,
              'k_pilih_bank' => $request->bank,
              'k_insert' => Carbon::now('Asia/Jakarta')
            ]);

            DB::table('d_perdin')->where('p_wo', $wo->wo_nota)->update([
              'p_status_approve' => 'Y',
              'p_status' => 'acc'
            ]);

            $akundebet = DB::table('dk_akun_penting')
                            ->where("ap_nama", 'HPP Perjalanan Dinas')
                            ->first();

            $akunkredit = $request->bank;

            $debet[$akundebet->ap_akun] = [
              'jrdt_akun' => $akundebet->ap_akun,
              'jrdt_value' => str_replace('.','', $request->diberikan),
              'jrdt_dk' => 'D'
            ];

            $debet[$akunkredit] = [
              'jrdt_akun' => $akunkredit,
              'jrdt_value' => str_replace('.','', $request->diberikan),
              'jrdt_dk' => 'K'
            ];

            keuangan::jurnal()->addJurnal($debet, date('Y-m-d'), $request->nokasbon, 'Pengeluaran Perdin', 'KK', modulSetting()['onLogin'], true);

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
    public function printperdin(Request $request){
      $wo = DB::table('d_work_order')->where('wo_id', $request->id)->first();

      $perdin = DB::table('d_perdin')->where('p_wo', $wo->wo_nota)->join('m_customer', 'c_code', '=', 'p_customer')->first();

      $perdindt = DB::table('d_perdin_dt')->where('pd_perdin', $perdin->p_id)->get();

      $jumlahsum = DB::table('d_perdin_dt')->where('pd_perdin', $perdin->p_id)->sum('pd_jumlah');

      $kasbon = DB::table('d_kasbon')->join('dk_akun', 'ak_id', '=', 'k_pilih_bank')->where('k_perdin', $perdin->p_id)->first();

      $sisa = DB::table('d_lpj_perdin')->where('lp_perdin', $perdin->p_id)->sum('lp_sisa_perdin');

      $sisa = (int)$kasbon->k_diberikan - (int)$sisa;

      return view('project.pemasangan.print_estimasiperdin', compact('perdin', 'perdindt', 'kasbon', 'jumlahsum', 'sisa'));
    }
    public function perdin()
    {
      $data = DB::table('d_perdin')
                ->select('p_tanggung_jawab', 'lp_code', 'p_code', 'p_total', 'lp_status', 'p_id', 'lp_perdin')
                ->leftjoin('d_lpj_perdin', 'lp_perdin', '=', 'p_id')
                ->groupby('p_id')
                ->get();


      return view('project.perdin.perdin', compact('data'));
    }

    public function proses_perdin(Request $request)
    {
      $perdin = DB::table('d_perdin')
                  ->leftjoin('m_customer', 'c_code', '=', 'p_customer')
                  ->where('p_id', decrypt($request->id))
                  ->first();

      $perdindt = DB::table('d_perdin_dt')
                    ->where('pd_perdin', decrypt($request->id))
                    ->get();

      return view('project.perdin.proses_perdin', compact('perdin', 'perdindt'));
    }
    public function print_perdin(Request $request)
    {
      $lpj = DB::table('d_lpj_perdin')->where('lp_perdin', decrypt($request->id))->get();

      $perdin = DB::table('d_perdin')->leftjoin('m_pegawai', 'p_id', '=', 'p_pelaksana')->leftjoin('m_customer', 'c_code', '=', 'p_customer')->where('p_id', decrypt($request->id))->first();

      $perdindt = DB::table('d_perdin_dt')->where('pd_perdin', decrypt($request->id))->get();

      return view('project.perdin.print_perdin', compact('lpj', 'perdin', 'perdindt'));
    }
    public function estimasi_perdin()
    {
      return view('order.print_estimasiperdin');
    }
    public function simpan_lpj(Request $request){
      DB::beginTransaction();
      try {

        $querykode = DB::select(DB::raw("SELECT MAX(MID(lp_code,4,3)) as counter FROM d_lpj_perdin"));

        if (count($querykode) > 0) {
            foreach($querykode as $k)
              {
                $tmp = ((int)$k->counter)+1;
                $kode = sprintf("%02s", $tmp);
              }
        } else {
          $kode = "001";
        }


        $finalkode = 'PR-' . $kode . '/' . date('m') . date('Y');

        for ($i=0; $i < count($request->tanggal); $i++) {
          $id = DB::table('d_lpj_perdin')->max('lp_id')+1;
          DB::table('d_lpj_perdin')
                ->insert([
                  'lp_id' => $id,
                  'lp_code' => $finalkode,
                  'lp_perdin' => $request->idperdin,
                  'lp_tanggal' => Carbon::parse($request->tanggal[$i])->format('Y-m-d'),
                  'lp_keterangan' => $request->keterangan[$i],
                  'lp_unit' => $request->unit[$i],
                  'lp_price' => $request->price[$i],
                  'lp_estimasi_budget' => str_replace('.','',$request->estimasibudget[$i]),
                  'lp_total_price' => str_replace('.','',$request->totalprice[$i]),
                  'lp_sisa_perdin' => str_replace('.','',$request->sisaperdin[$i]),
                  'lp_status' => 'released',
                  'lp_insert' => Carbon::now('Asia/Jakarta')
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

    public function edit_lpj(Request $request){
      $perdin = DB::table('d_perdin')
                  ->leftjoin('m_customer', 'c_code', '=', 'p_customer')
                  ->where('p_id', decrypt($request->id))
                  ->first();

      $lpj = DB::table('d_lpj_perdin')
                  ->where('lp_perdin', decrypt($request->id))
                  ->get();

      return view('project.perdin.edit_perdin', compact('perdin', 'lpj'));
    }

    public function update_lpj(Request $request){
      DB::beginTransaction();
      try {

        for ($i=0; $i < count($request->lp_id); $i++) {
          if ($request->lp_id[$i] == null) {
            $id = DB::table('d_lpj_perdin')->max('lp_id')+1;
            DB::table('d_lpj_perdin')
                  ->insert([
                    'lp_id' => $id,
                    'lp_code' => $request->lp_code,
                    'lp_perdin' => $request->lp_perdin,
                    'lp_tanggal' => Carbon::parse($request->tanggal[$i])->format('Y-m-d'),
                    'lp_keterangan' => $request->keterangan[$i],
                    'lp_unit' => $request->unit[$i],
                    'lp_price' => $request->price[$i],
                    'lp_estimasi_budget' => str_replace('.','',$request->estimasibudget[$i]),
                    'lp_total_price' => str_replace('.','',$request->totalprice[$i]),
                    'lp_sisa_perdin' => str_replace('.','',$request->sisaperdin[$i]),
                    'lp_status' => 'released',
                    'lp_insert' => Carbon::now('Asia/Jakarta')
                  ]);
          } else {
            DB::table('d_lpj_perdin')
                ->where('lp_id', $request->lp_id[$i])
                ->update([
                  'lp_tanggal' => Carbon::parse($request->tanggal[$i])->format('Y-m-d'),
                  'lp_keterangan' => $request->keterangan[$i],
                  'lp_unit' => $request->unit[$i],
                  'lp_price' => $request->price[$i],
                  'lp_estimasi_budget' => str_replace('.','',$request->estimasibudget[$i]),
                  'lp_total_price' => str_replace('.','',$request->totalprice[$i]),
                  'lp_sisa_perdin' => str_replace('.','',$request->sisaperdin[$i]),
                  'lp_update' => Carbon::now('Asia/Jakarta')
                ]);
          }
        }

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (Exception $e) {
        DB::commit();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }

    public function detail_lpj(Request $request){
      $perdin = DB::table('d_perdin')
                  ->leftjoin('m_customer', 'c_code', '=', 'p_customer')
                  ->where('p_id', decrypt($request->id))
                  ->first();

      $lpj = DB::table('d_lpj_perdin')
                  ->where('lp_perdin', decrypt($request->id))
                  ->get();

      return view('project.perdin.detail_perdin', compact('perdin', 'lpj'));
    }

    public function approve_lpj(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_lpj_perdin')
            ->where('lp_perdin', $request->id)
            ->update([
              'lp_status' => 'approved'
            ]);

            $lp = DB::table('d_lpj_perdin')
                ->where('lp_perdin', $request->id)
                ->first();

            $data = DB::table('d_kasbon')
                      ->where('k_perdin', $request->id)
                      ->first();

            $diberikan = DB::table('d_lpj_perdin')
                          ->where('lp_perdin', $request->id)
                          ->sum('lp_sisa_perdin');

            $akunkredit = DB::table('dk_akun_penting')
                            ->where("ap_nama", 'HPP Perjalanan Dinas')
                            ->first();

            $akundebet = $data->bank;

            $debet[$akunkredit->ap_akun] = [
              'jrdt_akun' => $akunkredit->ap_akun,
              'jrdt_value' => str_replace('.','', $diberikan),
              'jrdt_dk' => 'D'
            ];

            $debet[$akundebet] = [
              'jrdt_akun' => $akundebet,
              'jrdt_value' => str_replace('.','', $diberikan),
              'jrdt_dk' => 'K'
            ];

            keuangan::jurnal()->addJurnal($debet, date('Y-m-d'), $lp->lp_code, 'Pengeluaran Perdin', 'KK', modulSetting()['onLogin'], true);

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
}
