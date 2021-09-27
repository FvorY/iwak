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

class EditinfoController extends Controller
{

     public function index() {

       $data = DB::table("infotoko")->get();

       if (count($data) == 0) {
         return view("setting.editinfo.index");
       } else {
         return view("setting.editinfo.index", compact("data"));
       }

     }

     public function save(Request $req) {

       // dd($req);
       DB::beginTransaction();
       try {

            $data = DB::table("infotoko")->get();

            if (count($data) != 0) {

                DB::table("infotoko")
                  ->truncate();

                DB::table("infotoko")
                  ->insert([$req->all()]);

            } else {
              DB::table("infotoko")
                ->insert([$req->all()]);
            }

            DB::commit();
            Session::flash('sukses', 'sukses');

            return back()->with('sukses','sukses');
       } catch (\Exception $e) {
         // DD($e);
            DB::rollback();
            Session::flash('gagal', 'gagal');

            return back()->with('gagal','gagal');
       }

     }

}
