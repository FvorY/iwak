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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index() {

       $uangkeluar = DB::table("uangkeluar")->where("uangkeluar_users_id", Auth::user()->users_id)->whereMonth("created_at", date('m'))->whereYear("created_at", date('Y'))->sum("uangkeluar_nominal");

       $tagihan = DB::table("daftar_tagihan")->join('tagihan','tagihan_id','=','daftar_tagihan_tagihan_id')->where("tagihan_users_id", Auth::user()->users_id)->where("daftar_tagihan_bayar", "N")->whereMonth("daftar_tagihan.created_at", date('m'))->whereYear("daftar_tagihan.created_at", date('Y'))->sum("tagihan_nominal");

       $saldo = SaldoController::ceksaldo();

       return view("home", compact("saldo", "uangkeluar", "tagihan"));
     }

    public function logout(){
        Session::flush();
        mMember::where('users_id', Auth::user()->users_id)->update([
             'users_lastlogout' => Carbon::now('Asia/Jakarta'),
             "users_accesstoken" => md5(uniqid(Auth::user()->users_username, true)),
        ]);

        // mMember::where('m_id', Auth::user()->m_id)->update([
        //      'm_statuslogin' => 'N'
        //     ]);

        // logController::inputlog('Logout', 'Logout', Auth::user()->m_username);
        Auth::logout();

        Session::forget('key');
        return Redirect('/login');
    }
}
