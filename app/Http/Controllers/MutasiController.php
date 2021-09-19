<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

class MutasiController extends Controller
{

    public function index() {
      $tmpdata = DB::table("mutasi")->where("mutasi_users_id", Auth::user()->users_id)->orderBy("mutasi_id", "desc")->get();

      $result = [];
      foreach ($tmpdata as $key => $value) {
          if ($value->mutasi_type == "masuk") {
            $tmp = DB::table("mutasi")->where("mutasi_users_id", Auth::user()->users_id)->join("uangmasuk", "uangmasuk_id", "=", "mutasi_data_id")->first();
            $result[$key]["nominal"] = FormatRupiah($tmp->uangmasuk_nominal);
            $result[$key]["note"] = $tmp->uangmasuk_note;
            $result[$key]["type"] = strtoupper($tmp->mutasi_type);
            $result[$key]["date"] = Carbon::parse($tmp->created_at)->format('Y-m-d');
          } elseif ($value->mutasi_type == "keluar") {
            $tmp = DB::table("mutasi")->where("mutasi_users_id", Auth::user()->users_id)->join("uangkeluar", "uangkeluar_id", "=", "mutasi_data_id")->first();
            $result[$key]["nominal"] = FormatRupiah($tmp->uangkeluar_nominal);
            $result[$key]["note"] = $tmp->uangkeluar_note;
            $result[$key]["type"] = strtoupper($tmp->mutasi_type);
            $result[$key]["date"] = Carbon::parse($tmp->created_at)->format('Y-m-d');
          } elseif ($value->mutasi_type == "tagihan") {
            $tmp = DB::table("mutasi")->where("mutasi_users_id", Auth::user()->users_id)->join("tagihan", "tagihan_id", "=", "mutasi_data_id")->first();
            $result[$key]["nominal"] = FormatRupiah($tmp->tagihan_nominal);
            $result[$key]["note"] = $tmp->tagihan_note;
            $result[$key]["type"] = strtoupper($tmp->mutasi_type);
            $result[$key]["date"] = Carbon::parse($tmp->created_at)->format('Y-m-d');
          }
      }

      return view("mutasi.index", compact('result'));
    }

    public static function kirim($userid, $dataid, $mutasitype, $created_at) {
      DB::beginTransaction();
      try {

        $cekmutasi = DB::table("mutasi")->where("mutasi_users_id", $userid)->where("mutasi_data_id", $dataid)->first();

        // dd($cekmutasi);

        if ($cekmutasi == null) {
          DB::table("mutasi")
              ->insert([
                "mutasi_users_id" => $userid,
                "mutasi_data_id" => $dataid,
                "mutasi_type" => $mutasitype,
                "created_at" => Carbon::parse($created_at)->format('Y-m-d')
              ]);

        } else {
          DB::table("mutasi")
              ->where("mutasi_data_id", $dataid)
              ->update([
                "mutasi_type" => $mutasitype,
                "created_at" => Carbon::parse($created_at)->format('Y-m-d')
              ]);
        }

        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
      }


    }
}
