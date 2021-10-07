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

class BackgroundheaderController extends Controller
{

     public function index() {

       $data = DB::table("backgroundheader")
         ->where('id', 1)->first();

         if ($data == null) {
           return view("setting.backgroundheader.index");
         } else {
           return view("setting.backgroundheader.index", compact("data"));
         }
     }

     public function save(Request $req) {
       DB::beginTransaction();
       try {

            $imgPath = null;
            $tgl = carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/BackgroundHeader';
            $childPath = $dir . '/';
            $path = $childPath;

            $file = $req->file('image');
            $name = null;
            if ($file != null) {
                $this->deleteDir($dir);
                $name = $folder . '.' . $file->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        compressImage($_FILES['image']['type'],$_FILES['image']['tmp_name'],$_FILES['image']['tmp_name'],75);
                        $file->move($path, $name);
                        $imgPath = $childPath . $name;
                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }

            $data = DB::table("backgroundheader")->get();

            if (count($data) != 0) {

              if ($file != null) {
                DB::table("backgroundheader")
                  ->where('id', 1)
                  ->update([
                    'image' => $imgPath,
                    'updated_at' => Carbon::now('Asia/Jakarta')
                  ]);
              }
            } else {
              DB::table("backgroundheader")
                ->insert([
                  'image' => $imgPath,
                  'created_at' => Carbon::now('Asia/Jakarta')
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
