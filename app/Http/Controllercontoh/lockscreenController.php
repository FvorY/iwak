<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Validator;

use Auth;

use App\mMember;

use Session;

use App\Http\Controllers\logController;

class lockscreenController extends Controller
{
    public function error404(){
      return view('error-404');
    }

    public function lockscreen(Request $request){
      Session::put(['lockscreen' => 'yes']);
      $url = decrypt($request->url);

      return view('lock-screen', compact('url'));
    }

    public function unlock(Request $request){
      $rules = array(
          'password' => 'required|min:2' // password can only be alphanumeric and has to be greater than 3 characters
      );
    // dd($req->all());
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
          return Redirect('/lockscreen')
                          ->withErrors($validator) // send back all errors to the login form
                          ->withInput($request->except('password')); // send back the input (not the password) so that we can repopulate the form
      } else {
          $username  = Auth::user()->m_username;
          $password  = $request->password;
          $pass_benar=sha1(md5('passwordAllah').$password);
          // $username = str_replace('\'', '', $username);

          $user = mMember::where("m_username", $username)->first();

          $user_valid = [];
          // dd($req->all());

          if ($user != null) {
            $user_pass = mMember::where('m_username',$username)
                            ->where('m_password',$pass_benar)
                            ->first();

            if ($user_pass != null) {
              Session::put(['lockscreen' => 'no']);
              return Redirect($request->url);
            }else{
              Session::flash('password','Password Yang Anda Masukan Salah!');
              return back()->with('password');
            }
          }else{
          }


      }
    }
}
