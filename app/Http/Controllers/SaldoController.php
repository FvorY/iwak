<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

class SaldoController extends Controller
{
    public static function ceksaldo() {
      $uangmasuk = DB::table("uangmasuk")->where("uangmasuk_users_id", Auth::user()->users_id)->sum("uangmasuk_nominal");

      $uangkeluar = DB::table("uangkeluar")->where("uangkeluar_users_id", Auth::user()->users_id)->sum("uangkeluar_nominal");

      $tagihandibayar = DB::table("daftar_tagihan")->join('tagihan','tagihan_id','=','daftar_tagihan_tagihan_id')->where("tagihan_users_id", Auth::user()->users_id)->where("daftar_tagihan_bayar", "Y")->sum("tagihan_nominal");

      $saldo = $uangmasuk - ($uangkeluar + $tagihandibayar);

      return $saldo;
    }
}
