<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use Auth;
use DB;
use carbon\carbon;
use Session;
use App\mMember;
use Illuminate\Support\Facades\Crypt;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use App\Http\Controllers\logController;


// require __DIR__ . '/vendor/autoload.php';
class SettingController extends Controller
{
   // JABATAN

  public function tes()
  {

      $nama_barang = array('PSDNT 50gr','ayam','nasi','es jeruk');
      $harga       = array('3.000,00','7.000,00','4.000,00','4.000,00');
      $qty         = array('1','1','1','1');
      $connector = new FilePrintConnector("\\\sani\POS-58");
      $printer = new Printer($connector);
      $logo =  EscposImage::load('assets/tux.png');


      // // $printer -> setJustification(Escpos::JUSTIFY_CENTER);
      // $printer -> setJustification(Printer::JUSTIFY_CENTER);
      // $printer -> bitImageColumnFormat($logo);
      // // HEAD
      // $printer -> text("Alam Raya Sebar Barokah\n");
      // $printer -> text("Jl. Purimas C3/19\n");
      // $printer -> text("Telp:087878789\n");
      // $printer -> text("********************************\n");
      // $sayur1 = 'PEPSODENT 50GR';
      // $sayur2 = '1.000.000';
      // $sayur3 = '23';
      // $tes1 = strlen($sayur1);
      // $tes2 = strlen($sayur2);
      // $tes3 = strlen($sayur3);
      // $temp = $tes1 + $tes2 + $tes3;
      // $count = 32- $temp;

      // $pad1 = 15 - $tes1;
      // $pad2 = 4 - $tes3;
      // $pad3 = 13 - $tes2;
      // $spas1_1;
      // $spas2_1;
      // $spas3_1;
      // for ($i=0; $i < $pad1; $i++) {
      //   $spas1_1[$i] = ' ';
      // }

      // $spas1 = implode("", $spas1_1);
      // for ($i=0; $i < $pad2; $i++) {
      //   $spas2_1[$i] = ' ';
      // }
      // $spas2 = implode("", $spas2_1);

      // for ($i=0; $i < $pad3; $i++) {
      //   $spas3_1[$i] = ' ';
      // }
      // $spas3 = implode("", $spas3_1);
      // // dd($spas1);
      // $coba  = $sayur1.$spas1.$spas2.$sayur3.$spas3.$sayur2;
      // $printer -> setFont(Printer::FONT_B);
      // $printer -> text($coba."\n");

      $fonts = array(
        Printer::FONT_A,
        Printer::FONT_B,
        Printer::FONT_C);
      for($i = 0; $i < count($fonts); $i++) {
        $printer -> setFont($fonts[$i]);
        $printer -> text("The quick brown fox jumps over the lazy dog\n");
      }
      $printer -> setFont(); // Reset
      $printer -> cut();
      $printer -> close();
      // //BODY
      // for ($i=0; $i < count($nama_barang); $i++) {
      //   $printer -> setJustification(Printer::JUSTIFY_LEFT);
      //   $printer -> text('x                              x');
      //   $printer -> text("\n");
      // }


      // $printer->text("\n");

      // $printer -> cut();
      // $printer -> close();
      return 'success';
  }
   public function jabatan()
   {
     if (!mMember::akses('SETTING LEVEL ACCOUNT', 'aktif')) {
        return redirect('error-404');
      }
     $data = DB::table('d_jabatan')
               ->orderBy('j_id','ASC')
               ->get();

    return view('setting.jabatan.jabatan', compact('data'));
   }

   public function datatable_jabatan()
   {
        $data = DB::table('d_jabatan')
                  ->orderBy('j_id','ASC')
                  ->get();


        // return $data;
        $data = collect($data);
        // return $data;
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
   public function simpan_jabatan(request $req)
   {
      // dd($req->all());
      return DB::transaction(function() use ($req) {
         if ($req->id == null) {
            $valid = DB::table('d_jabatan')
                       ->where('j_nama',$req->nama)
                       ->first();
            if ($valid == null) {
               $id = DB::table('d_jabatan')
                    ->max('j_id');
               if ($id != null) {
                  $id+=1;
               }else{
                  $id = 1;
               }
               $simpan = DB::table('d_jabatan')
                           ->insert([
                                    'j_id'=>$id,
                                    'j_nama'=>strtoupper($req->nama),
                                    'j_keterangan'=>strtoupper($req->keterangan),
                                    ]);

             logController::inputlog('Setting Level Account', 'Insert', $req->nama);

              $daftar_menu = DB::table('d_daftar_menu')
                             ->orderBy('dm_id','ASC')
                             ->get();

              for ($i=0; $i < count($daftar_menu); $i++) {

                $hak_akses = DB::table('d_hak_akses')
                               ->insert([
                                  'ha_id'   => $daftar_menu[$i]->dm_id,
                                  'ha_dt'   => $i+1,
                                  'ha_level'=> strtoupper($req->nama),
                                  'ha_menu' => $daftar_menu[$i]->dm_nama,
                                  'aktif'   => 1,
                                  'tambah'  => 1,
                                  'ubah'    => 1,
                                  'hapus'   => 1,
                                  'print'   => 1,
                               ]);
              }

               return response()->json(['status' => 1]);


            }else{
               return response()->json(['status' => 0]);
            }
         }else{
            $update = DB::table('d_jabatan')
                        ->where('j_id',$req->id)
                        ->update(['j_nama'=>strtoupper($req->nama),
                                 'j_keterangan'=>strtoupper($req->keterangan),
                                 ]);
             logController::inputlog('Setting Level Account', 'Update', strtoupper($req->nama));

            $daftar_menu = DB::table('d_daftar_menu')
                             ->orderBy('dm_id','ASC')
                             ->get();

            for ($i=0; $i < count($daftar_menu); $i++) {

              $hak_akses1 = DB::table('d_hak_akses')
                             ->where('ha_id',$daftar_menu[$i]->dm_id)
                             ->where('ha_level',strtoupper($req->nama))
                             ->first();

              if ($hak_akses1 == null) {
                $aktif = 0;
                $tambah = 0;
                $ubah = 0;
                $hapus = 0;
                $print = 0;
              }else{
                $aktif  = $hak_akses1->aktif;
                $tambah = $hak_akses1->tambah;
                $ubah   = $hak_akses1->ubah;
                $hapus  = $hak_akses1->hapus;
                $print  = $hak_akses1->print;
              }
              // dd($hak_akses1);
              $hak_akses = DB::table('d_hak_akses')
                             ->where('ha_id',$daftar_menu[$i]->dm_id)
                             ->where('ha_level',strtoupper($req->nama))
                             ->update([
                                'ha_id'   => $daftar_menu[$i]->dm_id,
                                'ha_dt'   => $i+1,
                                'ha_level'=> strtoupper($req->nama),
                                'ha_menu' => $daftar_menu[$i]->dm_nama,
                                'aktif'   => $aktif,
                                'tambah'  => $tambah,
                                'ubah'    => $ubah,
                                'hapus'   => $hapus,
                                'print'   => $print,
                             ]);
            }

            return response()->json(['status' => 2]);
         }
      });
   }

   public function hapus_jabatan(request $req)
   {
      $hapus = DB::table('d_jabatan')
                 ->where('j_id',$req->id)
                 ->first();

      if ($hapus->j_nama == 'SUPERUSER') {
         return response()->json(['status' => 2]);
      }else{
             logController::inputlog('Setting Level Account', 'Delete', $hapus->j_nama);

              DB::table('d_jabatan')
                 ->where('j_id',$req->id)
                 ->delete();

                 DB::table('d_hak_akses')
                    ->where('ha_level', $hapus->j_nama)
                    ->delete();

         return response()->json(['status' => 1]);
      }


   }

   // END
   // AKUN
   public function akun()
   {
     if (!mMember::akses('SETTING ACCOUNT', 'aktif')) {
        return redirect('error-404');
      }
      $level = DB::table('d_jabatan')
                 ->get();

      $pegawai = DB::table('m_pegawai')
                  ->get();

      return view('setting.akun.akun',compact('level','pegawai'));
   }

   public function datatable_akun()
   {
      $data = DB::table('d_mem')
                  ->leftjoin('m_pegawai', 'm_pegawai_id', '=', 'mp_id')
                  ->orderBy('m_id','ASC')
                  ->get();


        $data = collect($data);
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                          $ubah = '';
                          $hapus = '';
                          if (mMember::akses('SETTING ACCOUNT', 'ubah')) {
                            $ubah = '<button type="button" onclick="edit(this)" class="btn btn-info btn-lg" title="edit">'.
                            '<label class="fa fa-pencil "></label></button>';
                          }
                         if (mMember::akses('SETTING ACCOUNT', 'hapus')) {
                           $hapus = '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'.
                           '<label class="fa fa-trash"></label></button>';
                          }
                          return  '<div class="btn-group">'.
                                   $ubah.
                                   $hapus.
                                  '</div>';
                        })
                        ->addColumn('none', function ($data) {
                            return '-';
                        })
                        ->addColumn('image', function ($data) {
                            $thumb = route('thumbnail').'/'.$data->m_image;
                            return '<img style="width:50px;height:50px;" class="img-fluid img-thumbnail" src="'.$thumb.'">';
                        })
                        ->rawColumns(['aksi', 'image'])
                        ->make(true);
   }
   public function simpan_akun(request $req)
   {
      // return $user;
      return DB::transaction(function() use ($req) {
        // dd($req->all());
        if ($req->id == null) {
            $valid = DB::table('d_mem')
                       ->where('m_username',$req->username)
                       ->first();

            if ($valid == null) {

               $id = DB::table('d_mem')
                    ->max('m_id');
               if ($id != null) {
                  $id+=1;
               }else{
                  $id = 1;
               }

              $level = DB::table('d_jabatan')
                         ->where('j_id',$req->level)
                         ->first();

              $password = sha1(md5('passwordAllah').$req->password);

              $simpan = DB::table('d_mem')
                           ->insert([
                                    'm_id'      => $id,
                                    'm_username'=> $req->username,
                                    'm_password'=> $password,
                                    'm_name'    => $req->nama,
                                    'm_jabatan' => $level->j_nama,
                                    'm_pegawai_id' => $req->pegawai
                                    ]);

             logController::inputlog('Setting Account', 'Insert', $req->nama);

               $status = 1;
            }else{
               $status = 0;
            }

        }else{
            $id = $req->id;
            $password = sha1(md5('passwordAllah').$req->password);

            $level = DB::table('d_jabatan')
                         ->where('j_id',$req->level)
                         ->first();

            $simpan = DB::table('d_mem')
                           ->where('m_id',$id)
                           ->update([
                                    'm_username'=> $req->username,
                                    'm_password'=> $password,
                                    'm_name'    => $req->nama,
                                    'm_jabatan' => $level->j_nama,
                                    'm_pegawai_id' => $req->pegawai
                                    ]);
             logController::inputlog('Setting Account', 'Update', $req->nama);
            $status = 2;
        }

        $file = $req->file('files');
        if ($file != null) {
          mMember::where('m_id',$id)->first();

          $file_name = 'user_'. $id .'_' . '.' . $file->getClientOriginalExtension();

          if (!is_dir(storage_path('uploads/user/thumbnail/'))) {
            mkdir(storage_path('uploads/user/thumbnail/'), 0777, true);
          }

          if (!is_dir(storage_path('uploads/user/original/'))) {
            mkdir(storage_path('uploads/user/original/'), 0777, true);
          }


          $thumbnail_path = storage_path('uploads/user/thumbnail/');
          $original_path = storage_path('uploads/user/original/');
          // return $original_path;
          Image::make($file)
                  ->resize(261,null,function ($constraint) {
                    $constraint->aspectRatio();
                     })
                  ->save($original_path . $file_name)
                  ->resize(90, 90)
                  ->save($thumbnail_path . $file_name);

          $user = mMember::where('m_id',$id)->update(['m_image' => $file_name]);
        }


        return response()->json(['status' => $status]);

      });
   }

   public function hapus_akun(request $req)
   {
      $hapus = DB::table('d_mem')
                 ->where('m_id',$req->id)
                 ->first();
      if ($hapus->m_jabatan == 'SUPERUSER') {
         return response()->json(['status' => 2]);
      }else{
         logController::inputlog('Setting Account', 'Delete', $hapus->m_name);
         $hapus = DB::table('d_mem')
                 ->where('m_id',$req->id)
                 ->delete();
         return response()->json(['status' => 1]);
      }
   }
   public function edit_akun(request $req)
   {
      $data = mMember::where('m_id',$req->id)
                    ->first();
      $jabatan = DB::table('d_jabatan')
                   ->get();
      for ($i=0; $i < count($jabatan); $i++) {
        if ($jabatan[$i]->j_nama == $data->m_jabatan) {
          $data->kode_jabatan = $jabatan[$i]->j_id;
        }
      }
      return response()->json(['data' => $data]);
   }
   // END
   // DAFTAR MENU
   public function daftar_menu()
   {
     if (!mMember::akses('SETTING DAFTAR MENU', 'aktif')) {
        return redirect('error-404');
      }
      $grup_menu = DB::table('d_grup_menu')
                     ->get();
      return view('setting.daftar_menu.daftar_menu',compact('grup_menu'));
   }

   public function datatable_daftar_menu()
   {
      $data = DB::table('d_daftar_menu')
                  ->join('d_grup_menu','gm_id','=','dm_group')
                  ->orderBy('dm_id','ASC')
                  ->get();


      // return $data;
      $data = collect($data);
      // return $data;
      return Datatables::of($data)
                      ->addColumn('aksi', function ($data) {
                        $ubah = '';
                        $hapus = '';
                        if (mMember::akses('SETTING DAFTAR MENU', 'ubah')) {
                          $ubah = '<button type="button" onclick="edit(this)" class="btn btn-info btn-lg" title="edit">'.
                          '<label class="fa fa-pencil "></label></button>';
                        }
                       if (mMember::akses('SETTING DAFTAR MENU', 'hapus')) {
                         $hapus = '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'.
                         '<label class="fa fa-trash"></label></button>';
                        }
                        return  '<div class="btn-group">'.
                                 $ubah.
                                 $hapus.
                                '</div>';
                      })
                      ->addColumn('none', function ($data) {
                          return '-';
                      })
                      ->rawColumns(['aksi', 'confirmed'])
                      ->make(true);
   }

   public function simpan_daftar_menu(request $req)
   {
      return DB::transaction(function() use ($req) {
         if ($req->id == null) {
            $valid = DB::table('d_daftar_menu')
                       ->where('dm_nama',$req->nama)
                       ->where('dm_group',$req->grup_menu)
                       ->first();
            if ($valid == null) {
               $id = DB::table('d_daftar_menu')
                    ->max('dm_id');
               if ($id != null) {
                  $id+=1;
               }else{
                  $id = 1;
               }
               $simpan = DB::table('d_daftar_menu')
                           ->insert([
                                    'dm_id'=>$id,
                                    'dm_nama'=>strtoupper($req->nama),
                                    'dm_group'=>strtoupper($req->grup_menu),
                                    ]);

              $hak_akses = DB::table('d_hak_akses')
                             ->select('ha_level')
                             ->groupBy('ha_level')
                             ->get();

              for ($i=0; $i < count($hak_akses); $i++) {
                $simpan = DB::table('d_hak_akses')
                            ->insert([
                              'ha_id'=>$id,
                              'ha_dt'=>$id,
                              'ha_level'=>$hak_akses[$i]->ha_level,
                              'ha_menu'=>strtoupper($req->nama),
                            ]);
              }

              return response()->json(['status' => 1]);
            }else{
               return response()->json(['status' => 0]);
            }

         }else{


            $cari = DB::table('d_daftar_menu')
                        ->where('dm_id',$req->id)
                        ->first();


            $update = DB::table('d_hak_akses')
                          ->where('ha_menu',$cari->dm_nama)
                          ->update([
                            'ha_menu'=>strtoupper($req->nama),
                          ]);



            $update = DB::table('d_daftar_menu')
                        ->where('dm_id',$req->id)
                        ->update(['dm_nama'=>$req->nama,
                                 'dm_group'=>$req->grup_menu,
                                 ]);




            return response()->json(['status' => 2]);
        }
      });
   }
   public function hapus_daftar_menu(request $req)
   {

      $cari = DB::table('d_daftar_menu')
                        ->where('dm_id',$req->id)
                        ->first();

      $hapus_menu = DB::table('d_hak_akses')
                            ->where('ha_menu',$cari->dm_nama)
                            ->delete();

      $hapus = DB::table('d_daftar_menu')
               ->where('dm_id',$req->id)
               ->delete();

      return response()->json(['status' => 1]);
   }
   // END
   public function hak_akses()
   {
     if (!mMember::akses('SETTING HAK AKSES', 'aktif')) {
        return redirect('error-404');
      }

      $hak_akses = DB::table('d_hak_akses')
                ->select('ha_level')
                ->groupBy('ha_level')
                ->get();

      $daftar = DB::table('d_daftar_menu')
                ->get();

      $grup_menu = DB::table('d_grup_menu')
                ->get();

      for ($i=0; $i < count($grup_menu); $i++) {
         for ($a=0; $a < count($daftar); $a++) {
            if ($grup_menu[$i]->gm_id == $daftar[$a]->dm_group) {
              $data[$i][$a] = $daftar[$a]->dm_nama;
            }
         }
        $data[$i] = array_values($data[$i]);
      }

      return view('setting.hak_akses.hak_akses',compact('data','grup_menu','hak_akses'));
   }

   public function table_data(request $req)
   {
      $hak_akses = DB::table('d_hak_akses')
                     ->where('ha_level',$req->level)
                     ->get();

      $daftar = DB::table('d_daftar_menu')
                ->get();

      $grup_menu = DB::table('d_grup_menu')
                ->get();

      for ($i=0; $i < count($grup_menu); $i++) {
         for ($a=0; $a < count($daftar); $a++) {
            if ($grup_menu[$i]->gm_id == $daftar[$a]->dm_group) {
              $data[$i][$a] = $daftar[$a]->dm_nama;
            }
         }
        $data[$i] = array_values($data[$i]);
      }
      return view('setting.hak_akses.table_data',compact('data','grup_menu','hak_akses'));
   }
   public function centang(request $req)
   {

      if (isset($req->aksi)) {
        if ($req->aksi == 'true') {
          $aksi = 1;
        }else{
          $aksi = 0;
        }
        $rubah = DB::table('d_hak_akses')
                ->where('ha_level',$req->level)
                ->where('ha_menu',$req->tanda)
                ->update([
                  'aktif' =>$aksi
                ]);

                logController::inputlog('Setting Hak Akses', 'Akses Aksi', $req->tanda);

      }

      if (isset($req->tambah)) {
        if ($req->tambah == 'true') {
          $tambah = 1;
        }else{
          $tambah = 0;
        }
        $rubah = DB::table('d_hak_akses')
                ->where('ha_level',$req->level)
                ->where('ha_menu',$req->tanda)
                ->update([
                  'tambah' =>$tambah
                ]);

                logController::inputlog('Setting Hak Akses', 'Akses Tambah', $req->tanda);

      }

      if (isset($req->ubah)) {
        if ($req->ubah == 'true') {
          $ubah = 1;
        }else{
          $ubah = 0;
        }
        $rubah = DB::table('d_hak_akses')
                ->where('ha_level',$req->level)
                ->where('ha_menu',$req->tanda)
                ->update([
                  'ubah' =>$ubah
                ]);

                logController::inputlog('Setting Hak Akses', 'Akses Ubah', $req->tanda);

      }

      if (isset($req->print)) {
        if ($req->print == 'true') {
          $print = 1;
        }else{
          $print = 0;
        }
        $rprint = DB::table('d_hak_akses')
                ->where('ha_level',$req->level)
                ->where('ha_menu',$req->tanda)
                ->update([
                  'print' =>$print
                ]);

                logController::inputlog('Setting Hak Akses', 'Akses Print', $req->tanda);

      }

      if (isset($req->hapus)) {
        if ($req->hapus == 'true') {
          $hapus = 1;
        }else{
          $hapus = 0;
        }
        $hapus = DB::table('d_hak_akses')
                ->where('ha_level',$req->level)
                ->where('ha_menu',$req->tanda)
                ->update([
                  'hapus' =>$hapus
                ]);

                logController::inputlog('Setting Hak Akses', 'Akses Hapus', $req->tanda);

      }

      return response()->json(['status' => 1]);
   }
}
