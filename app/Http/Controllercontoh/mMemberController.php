<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\mMember;
use App\d_access;
use Validator;
use DB;
use Session;
use Carbon\Carbon;
use App\Http\Controllers\logController;

class mMemberController extends Controller
{

	public function __construct() {
    	$this->middleware('guest')->except('logout','getLogout');
	}
    public function logousdfsdafdst() {
        //dd(Carbon::now());
        $user = mMember::find(Auth::user()->m_id);
        $use = $user->update([
            'm_lastlogout' => Carbon::now(),
        ]);
        Session::flush();
        Auth::logout();
        Session::forget('key');
        return Redirect('/');
    }
}
