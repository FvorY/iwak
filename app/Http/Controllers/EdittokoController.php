<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

class EdittokoController extends Controller
{

     public function index() {

       $data = DB::table("account")->where("id_account", Auth::user()->id_account)->first();

       if ($data == null) {
         return view("penjualedittoko.editinfo.index");
       } else {
         return view("penjualedittoko.index", compact("data"));
       }

     }

     public function simpan(Request $req) {

         if ($req->namatoko == null) {
           // dd($req);
           Session::flash('gagal', 'gagal');

           return back()->with('gagal','gagal');
         }

         DB::beginTransaction();
         try {

           if ($req->namatoko == "") {
             // dd($req);
             Session::flash('gagal', 'gagal');

             return back()->with('gagal','gagal');
           }

           // dd($req);
           $imgPath = null;
           $tgl = Carbon::now('Asia/Jakarta');
           $folder = $tgl->year . $tgl->month . $tgl->timestamp;
           $dir = 'image/uploads/Toko/' . $req->id;
           $childPath = $dir . '/';
           $path = $childPath;

           $file = $req->file('image');
           $name = null;
           if ($file != null) {
               $this->deleteDir($dir);
               $name = $folder . '.' . $file->getClientOriginalExtension();
               if (!File::exists($path)) {
                   if (File::makeDirectory($path, 0777, true)) {
                       compressImage($_FILES['image']['type'],$_FILES['image']['tmp_name'],$_FILES['image']['tmp_name'],90);
                       $file->move($path, $name);
                       $imgPath = $childPath . $name;
                   } else
                       $imgPath = null;
               } else {
                   return 'already exist';
               }
           }

           if ($imgPath == null) {
             DB::table("account")
                 ->where('id_account', Auth::user()->id_account)
                 ->update([
                 "namatoko" => $req->namatoko,
                 "bank" => $req->bank,
                 "updated_at" => Carbon::now('Asia/Jakarta'),
               ]);
           } else {
             DB::table("account")
                 ->where('id_account', Auth::user()->id_account)
                 ->update([
                 "namatoko" => $req->namatoko,
                 "nomor_rekening" => $req->nomor_rekening,
                 "bank" => $req->bank,
                 "profile_toko" => $imgPath,
                 "updated_at" => Carbon::now('Asia/Jakarta'),
               ]);
           }

           DB::commit();
           Session::flash('sukses', 'sukses');

           return back()->with('sukses','sukses');
         } catch (\Exception $e) {
           DB::rollback();
           Session::flash('gagal', 'gagal');

           return back()->with('gagal','gagal');
         }

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
