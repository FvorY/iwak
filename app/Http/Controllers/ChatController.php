<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

use Yajra\Datatables\Datatables;

use Response;

class ChatController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
      return view('chat');
    }

    public function countchat() {
       $chat = DB::table('roomchat')
                ->where('account', 'like', '%' . Auth::user()->id_account . '%')
                ->sum('counter');

        return Response()->json($chat);
    }

    public function listroom(Request $req) {
        $chat = DB::table('roomchat')
                 ->where('account', 'like', '%' . Auth::user()->id_account . '%')
                 ->get();

        foreach ($chat as $key => $value) {
          $account = explode("-",$value->account);

          if ($account[0] != Auth::user()->id_account) {
            $value->account = DB::table("account")
                                ->where("id_account", $account[0])
                                ->first();
          } else if ($account[1] != Auth::user()->id_account) {
            $value->account = DB::table("account")
                                ->where("id_account", $account[1])
                                ->first();
          }

          $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
        }

         return Response()->json($chat);
    }

    public function listchat(Request $req) {
        $chat = DB::table('listchat')
                 ->where("id_roomchat", $req->id)
                 ->get();

         foreach ($chat as $key => $value) {
           $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
         }

         return Response()->json($chat);
    }

}
