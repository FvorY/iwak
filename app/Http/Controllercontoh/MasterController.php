<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\TypeItem;
use Yajra\Datatables\Datatables;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use Auth;
use DB;
use carbon\carbon;
use Session;
use App\mMember;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\logController;

class MasterController extends Controller
{
    public function suplier()
    {
    	return view('master/suplier/suplier');
    }
    public function customer()
    {
      if (!mMember::akses('MASTER DATA CUSTOMER', 'aktif')) {
        return redirect('error-404');
      }
    	return view('master/customer/cust');
    }
    public function pegawai()
    {
      if (!mMember::akses('MASTER DATA PEGAWAI', 'aktif')) {
        return redirect('error-404');
      }
    	return view('master/pegawai/pegawai');
    }
    public function keuangan()
    {
        return view('master/akun/keuangan');
    }

    //KEUANGAN AKUN
    public function a_keuangan()
    {
      if (!mMember::akses('MASTER DATA AKUN KEUANGAN', 'aktif')) {
        return redirect('error-404');
      }

        $general = DB::table('d_akun')->where('type_akun','GENERAL')->whereNotNull("kelompok_akun")->where("kelompok_akun", "!=", "-")->get();
        $detail = DB::table('d_akun')->where('type_akun','DETAIL')->get();
        $labarugi = DB::table('d_group_akun')->where('type_group','laba/rugi')->get();
        $grupakun = DB::table('d_group_akun')->where('type_group','neraca')->get();
        /*return*/ $datakelompok = json_encode(DB::table("d_akun")->where("type_akun", "GENERAL")->whereNotNull("kelompok_akun")->where("kelompok_akun", "!=", "-")->select("id_akun as value", "nama_akun as text")->get());

        return view('master/akun/a_keuangan',compact('general','detail','labarugi','grupakun','datakelompok'));
    }
    public function save_keuangan(Request $request)
    {

        // dd($request->all());
        $response = [
            'status'    => "sukses",
            'content'   => 'null'
        ];

        // return $cek;

        if($request->type_akun == "GENERAL"){

            $cek = DB::table("d_akun")->where("id_akun", $request->kelompok_akun.$request->nomor_akun)->first();

            // return json_encode($cek);

            if($cek != null){
                $response = [
                    'status'    => 'exist_id',
                    'content'   =>  $cek->nama_akun
                ];

                return json_encode($response);
            }


            // // return 'a';
            // $cek = DB::table("d_akun")->where("group_neraca", $request->group_neraca_general)->where("type_akun", "GENERAL")->first();
            // // return $cek;
            // if($cek && !is_null($cek->group_neraca)){
            //     $response = [
            //         'status'    => 'exist_group_neraca',
            //         'content'   =>  $cek->nama_akun
            //     ];
            //     return json_encode($response);
            // }

            // $cek = DB::table("d_akun")->where("group_laba_rugi", $request->group_laba_rugi_general)->where("type_akun", "GENERAL")->first();

            // // return json_encode($cek);

            // if($cek && !is_null($cek->group_laba_rugi)){
            //     $response = [
            //         'status'    => 'exist_group_laba_rugi',
            //         'content'   =>  $cek->nama_akun
            //     ];

            //     return json_encode($response);
            // }

            $data = [
                "id_akun"           => $request->kelompok_akun.$request->nomor_akun,
                "nama_akun"         => $request->nama_akun,
                "kelompok_akun"     => $request->nama_kelompok,
                "posisi_akun"       => $request->posisi_akun,
                "type_akun"         => $request->type_akun,
                "group_neraca"      => null,
                "group_laba_rugi"   => null
            ];

            DB::table("d_akun")->insert($data);


        }else{
            $cek = DB::table("d_akun")->where("id_akun", $request->kelompok_akun.'.'.$request->nomor_akun)->first();

            // return json_encode($cek);

            if($cek != null){
                $response = [
                    'status'    => 'exist_id',
                    'content'   =>  $cek->nama_akun
                ];

                return json_encode($response);
            }


            $data = [
                "id_akun"           => $request->kelompok_akun.".".$request->nomor_akun,
                "nama_akun"         => $request->nama_akun,
                "kelompok_akun"     => $request->nama_kelompok,
                "posisi_akun"       => $request->posisi_akun,
                "type_akun"         => $request->type_akun,
                "group_neraca"      => (isset($request->group_neraca)) ? $request->group_neraca : null,
                "group_laba_rugi"   => (isset($request->group_laba_rugi)) ? $request->group_laba_rugi : null,
                "opening_date"      => date('Y-m-d'),
            ];


            $saldo = [
             "id_akun"           => $request->kelompok_akun.".".$request->nomor_akun,
             "bulan"             => date("m"),
             "tahun"             => date("Y"),
             "saldo"             => str_replace(".", "", explode(',', $request->saldo)[0])
            ];

            DB::table("d_akun")->insert($data);
            DB::table("d_akun_saldo")->insert($saldo);
        }

        return json_encode($response);
    }
    public function delete_a_keuangan(Request $request)
    {
        // dd($request->all());
        // $on_jurnal = DB::table('d_jurnal_dt')->where('jrdt_acc', $request->id)->first();
        // $akun = DB::table('d_akun')->where('id_akun', $request->id)->first();

        // if($on_jurnal)
            // return response()->json(['status'=>2]);

        // if($akun)
            // return response()->json(['status'=>3]);

        DB::table("d_akun")->where("id_akun", $request->id)->delete();

        return response()->json(['status'=>1]);
    }

    public function edit_a_keuangan(Request $request)
    {
        $akun = DB::table('d_akun')->where('id_akun', $request->id)->first();
        // return json_encode($akun);
        $grupakun = DB::table("d_group_akun")->where("type_group", "neraca")->select("no_group", "nama_group")->get();
        $labarugi = DB::table("d_group_akun")->where("type_group", "laba/rugi")->select("no_group", "nama_group")->get();

        return view("master/akun/edit",compact('grupakun','labarugi','akun'));
    }


    //END OF
    public function t_keuangan()
    {
      if (!mMember::akses('MASTER DATA TRANSAKSI KEUANGAN', 'aktif')) {
        return redirect('error-404');
      }
        return view('master/transaksi/keuangan');
    }
    public function barang()
    {
      if (!mMember::akses('MASTER DATA BARANG', 'aktif')) {
        return redirect('error-404');
      }
        $type_barang = TypeItem::all();

        $unit        = DB::table('d_unit')
                         ->get();

        $currency    = DB::table('m_currency')
                         ->where('cu_value','!=',null)
                         ->get();

        $akun = DB::table('dk_akun')
                    ->get();

    	return view('master/barang/barang', compact('type_barang','unit','currency', 'akun'));
    }
    public function vendor()
    {
        return view('master/vendor/vendor');
    }
    public function bundle()
    {
        return view('master/bundle/bundle');
    }

    // STATUS
    public function datatable_status(request $req)
    {
        $data = DB::table('d_status')
                  ->orderBy('s_id','DESC')
                  ->get();


        // return $data;
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                ->addColumn('aksi', function ($data) {
                    $a =  '<div class="btn-group">';

                    if(Auth::user()->akses('MASTER DATA STATUS','ubah')){
                     $b = '<button type="button" onclick="edit(\''.$data->s_id.'\')" class="btn btn-primary btn-lg" title="edit">'.'<label class="fa fa-pencil "></label></button>';
                    }else{
                      $b = '';
                    }

                    if(Auth::user()->akses('MASTER DATA STATUS','hapus')){
                     $d =
                         '<button type="button" onclick="hapus(\''.$data->s_id.'\')" class="btn btn-danger btn-lg" title="hapus">'.
                         '<label class="fa fa-trash"></label></button>'.
                         '</div>';
                    }else{
                      $d = '</div>';
                    }

                    return $a . $b . $d;

                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->addColumn('status', function ($data) {

                    return  '<span class="badge badge-pill badge-'.$data->s_color.'">'.$data->s_name.'</span>'.
                            '<input type="hidden" class="s_id" value="'.$data->s_id.'">';
                })
                ->rawColumns(['aksi', 'detail','histori','total','status'])
                ->addIndexColumn()
                ->make(true);
    }

    public function status()
    {

        return view('master/status/status');
    }

    public function edit_status(request $req)
    {
        $data = DB::table('d_status')
                  ->where('s_id',$req->id)
                  ->first();

        return response()->json(['data'=>$data]);
    }

    public function simpan_status(request $req)
    {
        $id = DB::table('d_status')->max('s_id')+1;

        $cari = DB::table('d_status')
                  ->where('s_name',strtoupper($req->name))
                  ->where('s_color',$req->status)
                  ->first();

        if ($cari != null) {
            return response()->json(['status'=>2]);
        }

        if ($req->id != '') {
            if($req->id != 1){
                $save = DB::table('d_status')
                      ->where('s_id',$req->id)
                      ->update([
                        's_name' => strtoupper($req->name),
                        's_color'=> $req->status,
                      ]);
                return response()->json(['status'=>3]);
            }else{
                return response()->json(['status'=>3]);
            }
        }else{
            $save = DB::table('d_status')
                      ->insert([
                        's_id'   => $id,
                        's_name' => strtoupper($req->name),
                        's_color'=> $req->status,
                      ]);
            return response()->json(['status'=>1]);
        }

    }

    public function hapus_status(request $req)
    {
        $delete = DB::table('d_status')
                    ->where('s_id',$req->id)
                    ->delete();
        return response()->json(['status'=>1]);

    }
    public function type()
    {
        return view('master/type/type');
    }
    public function edit_rencanapembelian()
    {
        return view('master/rencanapembelian/edit_rencanapembelian');
    }
    public function edit_purchaseorder()
    {
        return view('master/rencanapembelian/edit_purchaseorder');
    }
    public function ttd()
    {
      if (!mMember::akses('MASTER DATA TTD', 'aktif')) {
        return redirect('error-404');
      }

        $data = DB::table('m_signature')
                ->get();

        return view('master.ttd.ttd', compact('data'));
    }
    public function simpanttd(Request $request){
      if (!mMember::akses('MASTER DATA TTD', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('m_signature')
                ->max('s_id');

                if ($id == null) {
                  $id = 1;
                } else {
                  $id += 1;
                }

            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/ttd/' . $id;
            $childPath = $dir . '/';
            $path = $childPath;
            $file = $request->file('signatureimage');
            $name = null;
            if ($file != null) {
                $name = $folder . '.' . $file->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        $file->move($path, $name);
                        $imgPath = $childPath . $name;
                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }

            DB::table('m_signature')
                ->insert([
                  's_id' => $id,
                  's_name' => strtoupper($request->name),
                  's_image' => $imgPath,
                  's_insert' => Carbon::now('Asia/Jakarta')
                ]);

                logController::inputlog('Master TTD', 'Insert', $imgPath);

            DB::commit();
            Session::flash('sukses', 'Berhasil Disimpan!');
            return redirect('master/ttd/ttd');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('gagal', 'Gagal Disimpan!');
            return redirect('master/ttd/ttd');
        }
    }
    public function hapusttd(Request $request){
      if (!mMember::akses('MASTER DATA TTD', 'hapus')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $dir = 'image/uploads/ttd/' . $request->id;
        $this->deleteDir($dir);

        DB::table('m_signature')
            ->where('s_id', $request->id)
            ->delete();

        logController::inputlog('Master TTD', 'Insert', $dir);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::commit();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }
    public function updatettd(Request $request){
      if (!mMember::akses('MASTER DATA TTD', 'ubah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $dir = 'image/uploads/ttd/' . $request->s_id;
        $this->deleteDir($dir);

        $imgPath = null;
        $tgl = Carbon::now('Asia/Jakarta');
        $folder = $tgl->year . $tgl->month . $tgl->timestamp;
        $dir = 'image/uploads/ttd/' . $request->s_id;
        $childPath = $dir . '/';
        $path = $childPath;
        $file = $request->file('signatureimage');
        $name = null;
        if ($file != null) {
            $name = $folder . '.' . $file->getClientOriginalExtension();
            if (!File::exists($path)) {
                if (File::makeDirectory($path, 0777, true)) {
                    $file->move($path, $name);
                    $imgPath = $childPath . $name;
                } else
                    $imgPath = null;
            } else {
                return 'already exist';
            }
        }

        DB::table('m_signature')
            ->where('s_id', $request->s_id)
            ->update([
              's_name' => strtoupper($request->name),
              's_image' => $imgPath,
              's_update' => Carbon::now('Asia/Jakarta')
            ]);

            logController::inputlog('Master TTD', 'Update', $imgPath);

        DB::commit();
        Session::flash('sukses', 'Berhasil Disimpan!');
        return redirect('master/ttd/ttd');
    } catch (\Exception $e) {
        DB::rollback();
        Session::flash('gagal', 'Gagal Disimpan!');
        return redirect('master/ttd/ttd');
    }
  }
    public function bank()
    {
      if (!mMember::akses('MASTER DATA BANK', 'aktif')) {
        return redirect('error-404');
      }
        return view('master.bank.bank');
    }
    public function datatable_bank(request $req)
    {
        $data = DB::table('m_bank')
                  ->orderBy('id','DESC')
                  ->get();


        // return $data;
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                ->addColumn('aksi', function ($data) {
                    $a =  '<div class="btn-group">';

                    if(Auth::user()->akses('MASTER DATA BANK','ubah')){
                     $b = '<button type="button" onclick="edit(\''.$data->id.'\')" class="btn btn-primary btn-lg" title="edit">'.'<label class="fa fa-pencil "></label></button>';
                    }else{
                      $b = '';
                    }

                    if(Auth::user()->akses('MASTER DATA BANK','hapus')){
                     $d =
                         '<button type="button" onclick="hapus(\''.$data->id.'\')" class="btn btn-danger btn-lg" title="hapus">'.
                         '<label class="fa fa-trash"></label></button>'.
                         '</div>';
                    }else{
                      $d = '</div>';
                    }

                    return $a . $b . $d;

                })
                ->addColumn('none', function ($data) {
                    return '-';
                })

                ->rawColumns(['aksi', 'none'])
                ->addIndexColumn()
                ->make(true);
    }
public function edit_bank(request $req)
    {
      if (!mMember::akses('MASTER DATA BANK', 'ubah')) {
        return redirect('error-404');
      }
        $data = DB::table('m_bank')
                  ->where('id',$req->id)
                  ->first();

        return response()->json(['bank'=>$data]);
    }

    public function simpan_bank(request $req)
    {
      if (!mMember::akses('MASTER DATA BANK', 'tambah')) {
        return redirect('error-404');
      }
        $id = DB::table('m_bank')->max('id')+1;

        $cari = DB::table('m_bank')
                  ->where('name',strtoupper($req->name))
                  ->first();

        if ($cari != null) {
            return response()->json(['bank'=>2]);
        }

        if ($req->id != '') {
            if($req->id != 1){
                $save = DB::table('m_bank')
                      ->where('id',$req->id)
                      ->update([
                        'name' => strtoupper($req->name)
                      ]);
                      logController::inputlog('Master BANK', 'Update', $req->name);
                return response()->json(['bank'=>3]);
            }else{
                return response()->json(['bank'=>3]);
            }
        }else{
            $save = DB::table('m_bank')
                      ->insert([
                        'id'   => $id,
                        'name' => strtoupper($req->name)
                      ]);
                      logController::inputlog('Master BANK', 'Insert', $req->name);
            return response()->json(['bank'=>1]);
        }

    }

    public function hapus_bank(request $req)
    {
      if (!mMember::akses('MASTER DATA BANK', 'hapus')) {
        return redirect('error-404');
      }
      $delete = DB::table('m_bank')
                  ->where('id',$req->id)
                  ->first();

         DB::table('m_bank')
                    ->where('id',$req->id)
                    ->delete();

                    logController::inputlog('Master BANK', 'Hapus', $detele->name);

        return response()->json(['bank'=>1]);

    }
        public function jasa()
        {
          if (!mMember::akses('MASTER DATA JASA', 'aktif')) {
            return redirect('error-404');
          }

          $akun = DB::table('dk_akun')->get();

            return view('master.jasa.jasa', compact('akun'));
        }
        public function datatable_jasa(request $req)
        {
            $data = DB::table('m_item')
                        ->select('i_id', 'i_name', 'i_price', 'u_unit', 'i_description')
                        ->join('d_unit', 'u_id' ,'=', 'm_item.i_unit')
                        ->where('i_jenis', 'JASA')
                        ->orderBy('i_id','DESC')
                        ->get();

            for ($i=0; $i < count($data); $i++) {
              $data[$i]->i_price = "Rp. " . number_format($data[$i]->i_price,0,',','.');

            }

            // return $data;
            $data = collect($data);
            // return $data;
            return Datatables::of($data)
                    ->addColumn('aksi', function ($data) {
                        $a =  '<div class="btn-group">';

                        if(Auth::user()->akses('MASTER DATA JASA','ubah')){
                         $b = '<button type="button" onclick="edit(\''.$data->i_id.'\')" class="btn btn-primary btn-lg" title="edit">'.'<label class="fa fa-pencil "></label></button>';
                        }else{
                          $b = '';
                        }

                        if(Auth::user()->akses('MASTER DATA JASA','hapus')){
                         $d =
                             '<button type="button" onclick="hapus(\''.$data->i_id.'\')" class="btn btn-danger btn-lg" title="hapus">'.
                             '<label class="fa fa-trash"></label></button>'.
                             '</div>';
                        }else{
                          $d = '</div>';
                        }

                        return $a . $b . $d;

                    })
                    ->addColumn('none', function ($data) {
                        return '-';
                    })

                    ->rawColumns(['aksi', 'none'])
                    ->addIndexColumn()
                    ->make(true);
        }
        public function edit_jasa(request $req)
        {
          if (!mMember::akses('MASTER DATA JASA', 'ubah')) {
            return redirect('error-404');
          }
            $data = DB::table('m_item')
                      ->select('i_name', 'i_price', 'i_description', 'i_id', 'u_unit', 'i_akun_persediaan')
                      ->join('d_unit', 'u_id' ,'=', 'i_unit')
                      ->where('i_id',$req->i_id)
                      ->first();

            return response()->json(['jasa'=>$data]);
        }

        public function simpan_jasa(request $req)
        {
          if (!mMember::akses('MASTER DATA JASA', 'tambah')) {
            return redirect('error-404');
          }
            $i_id = DB::table('m_item')->max('i_id')+1;

            if($i_id<=9)
            {
                $id_auto = 'BJS/000'.$i_id;
            }
            else if($i_id<=99)
            {
                $id_auto = 'BJS/00'.$i_id;
            }
            else if($i_id<=999)
            {
                $id_auto = 'BJS/0'.$i_id;
            }
            else {
                $id_auto = 'BJS/'.$i_id;
            }

            $cari = DB::table('m_item')
                      ->where('i_code',$id_auto)
                      ->first();

            if ($cari != null) {
                return response()->json(['jasa'=>2]);
            }

            if ($req->i_id != '') {
                if($req->i_id != 1){
                    $cari_sat = DB::table('d_unit')->where('u_unit', $req->i_unit)->get()->toArray();
                    // return $cari_sat;
                    if(count($cari_sat) === 1)
                    {
                        // return 'a';
                        $id_satuan = $cari_sat[0]->u_id;
                    } else {
                        $id_satuan = DB::table('d_unit')->max('u_id')+1;

                        $simpan_unit = DB::table('d_unit')->insert([
                            'u_id' => $id_satuan,
                            'u_unit' => $req->i_unit
                        ]);
                    }
                    $save = DB::table('m_item')
                          ->where('i_id',$req->i_id)
                          ->update([
                            'i_name' => strtoupper($req->i_name),
                            'i_price' => str_replace('.','',$req->i_price),
                            'i_sell_price' => floatval($req->i_price) ,
                            'i_akun_persediaan' => $req->akun ,
                            'i_lower_price' => 0 ,
                            'i_unit' => $id_satuan,
                            'i_description' => $req->i_description
                          ]);
                          logController::inputlog('Master Data Jasa', 'Update', strtoupper($req->i_name));
                    return response()->json(['jasa'=>3]);
                }else{
                    return response()->json(['jasa'=>3]);
                }
            }else{
                $cari_sat = DB::table('d_unit')->where('u_unit', $req->i_unit)->get()->toArray();
                // return $cari_sat;
                if(count($cari_sat) === 1)
                {
                    $id_satuan = $cari_sat[0]->u_id;
                    // return $id_satuan;
                } else {
                    $id_satuan = DB::table('d_unit')->max('u_id')+1;

                    $simpan_unit = DB::table('d_unit')->insert([
                        'u_id' => $id_satuan,
                        'u_unit' => $req->i_unit
                    ]);
                }
                $save = DB::table('m_item')
                          ->insert([
                            'i_code' => $id_auto,
                            'i_id'   => $i_id,
                            'i_name' => strtoupper($req->i_name),
                            'i_price' => $req->i_price,
                            'i_sell_price' => $req->i_price,
                            'i_akun_persediaan' => $req->akun ,
                            'i_lower_price' => 999999999,
                            'i_unit' => $id_satuan,
                            'i_description' => $req->i_description,
                            'i_jenis' => 'JASA'
                          ]);
                          logController::inputlog('Master Data Jasa', 'Insert', strtoupper($req->i_name));
                return response()->json(['jasa'=>1]);
            }

        }

        public function hapus_jasa(request $req)
        {
          if (!mMember::akses('MASTER DATA JASA', 'hapus')) {
            return redirect('error-404');
          }

          $delete = DB::table('m_item')
                      ->where('i_id',$req->i_id)
                      ->first();

             DB::table('m_item')
                        ->where('i_id',$req->i_id)
                        ->delete();

                        logController::inputlog('Master Data Jasa', 'Hapus', $delete->i_name);

            return response()->json(['jasa'=>1]);

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

}
