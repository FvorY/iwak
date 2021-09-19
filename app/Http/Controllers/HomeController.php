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
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index() {
       return view("home");
     }

    public function logout(){
        Session::flush();
        // mMember::where('users_id', Auth::user()->id_account)->update([
        //      'users_lastlogout' => Carbon::now('Asia/Jakarta'),
        //      "users_accesstoken" => md5(uniqid(Auth::user()->users_username, true)),
        // ]);

        // mMember::where('m_id', Auth::user()->m_id)->update([
        //      'm_statuslogin' => 'N'
        //     ]);

        // logController::inputlog('Logout', 'Logout', Auth::user()->m_username);
        Auth::logout();

        Session::forget('key');
        return Redirect('/');
    }
}
