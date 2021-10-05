<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Account;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index() {
       dd("asdasda");

       // $cekuseronline = DB::table("account")->where("islogin", 'Y')->get();

       // foreach ($cekuseronline as $key => $value) {
       //    if (Carbon::now()->diffInMinutes($value->last_online) == 120) {
       //        DB::table('account')->update(['islogin'=>'N']);
       //    }
       // }

       $useronline = DB::table("account")->where("islogin", 'Y')->count();

       $alluser = DB::table("account")->count();

       $alltoko = DB::table("account")->where("istoko", 'Y')->count();

       return view("home", compact('useronline', 'alluser', 'alltoko'));
     }

    public function logout(){
        Session::flush();
        // mMember::where('users_id', Auth::user()->id_account)->update([
        //      'users_lastlogout' => Carbon::now('Asia/Jakarta'),
        //      "users_accesstoken" => md5(uniqid(Auth::user()->users_username, true)),
        // ]);

        Account::where('id_account', Auth::user()->id_account)->update([
             'last_online' => Carbon::now(),
             'islogin' => "N",
        ]);

        // logController::inputlog('Logout', 'Logout', Auth::user()->m_username);
        Auth::logout();

        Session::forget('key');
        return Redirect('/');
    }

    public function checklogin() {
      // dd("asd");
      dd(Auth::user());
      if (Auth::check()) {
        if(Auth::user()->role == "admin") {
          return Redirect('/admin/home');
        } else {
          Account::where('id_account', Auth::user()->id_account)->update([
               'last_online' => Carbon::now(),
               'islogin' => "N",
          ]);

          Auth::logout();

          return Redirect('/admin/login');
        }
      } else {
        return Redirect('/admin/login');
      }
    }
}
