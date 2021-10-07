<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Account;
use Validator;
use Carbon\Carbon;
use Session;
use DB;

class MemberController extends Controller
{
    //
    public function login(Request $req) {

        $rules = array(
            'username' => 'required|min:3', // make sure the email is an actual email
            'password' => 'required|min:2' // password can only be alphanumeric and has to be greater than 3 characters
        );
        // dd($req->all());
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return Redirect('/')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput($req->except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $username  = $req->username;
            $password  = $req->password;
            $pass_benar = $password;
            // $pass_benar=$password;
            // $username = str_replace('\'', '', $username);

            $user = Account::where("email", $username)->where("role", "member")->first();

            $user_valid = [];
            // dd($req->all());

            if ($user != null) {
                $user_pass = Account::where('email',$username)
                                      ->where('password',$pass_benar)
                                      ->first();

                if ($user_pass != null) {
                    // Account::where('email',$username)->update([
                //      'users_lastlogin'=>Carbon::now(),
                //        ]);

                    Account::where('email',$username)->update([
                         'last_online'=>Carbon::now(),
                         'islogin'=>'Y',
                          ]);
            // $user = Account::where("email", $username)->where("role", "member")->first();

                    Auth::login($user);
                    // Session::put('username',$data->fullname);
                    // dd(Session::put('username',$user->fullname));
                    // Session::put('email',$data->email);
                    // logController::inputlog('Login', 'Login', $username);
                    return Redirect('/')->with('message', 'IT WORKS!');
                    }else{
                    Session::flash('password','Password Yang Anda Masukan Salah!');
                    return back()->with('password','username');
                      // Session()->now('message', 'gagal password salah.');
                      // session()->reflash();
                    }
                }else{
                    Session::flash('username','Username Tidak Ada');
                    return back()->with('password','username');
                        // session()->now('message', 'gagal username salah.');
                        // session()->reflash();

                }


        }
    }

    public function register(Request $req){
        $this->validate($req, [
            'fullname' => 'required|string|min:4',
            'email' => 'required|min:4|email',
            'password' => 'required|min:4',
        ]);


          $max = DB::table("account")->max('id_account') + 1;
          $email = $req['email'];
          // $user = Account::where("email", $email)->where("role", "member")->first();

       
         $regis = Account::create([
            'id_account' => $max,
            'fullname' => $req['fullname'],
            'email' => $req['email'],
            'password' => $req['password'],
            'confirm_password' => $req['password'],
            'role' => 'member',
            'islogin' => 'Y',
            'last_online'=>Carbon::now(),
        ]);
   
        //     ]);
         if ($regis != null) {
          $user = Account::where("email", $email)->where("role", "member")->first();
        Auth::login($user);
        return redirect('/')->with('alert-success','Kamu berhasil Register');

             // code...
         }
        // Auth::login($user);

        // return redirect('/')->with('alert-success','Kamu berhasil Register');

    }
    public function logout(){

      Account::where('id_account', Auth::user()->id_account)->update([
           'last_online' => Carbon::now(),
           'islogin' => "N",
      ]);

      Auth::logout();

      return Redirect('/');
    }

    public function logoutjson(){

      Account::where('id_account', Auth::user()->id_account)->update([
           'last_online' => Carbon::now(),
           'islogin' => "N",
      ]);

      Auth::logout();

      return response()->json(200);
    }

}
