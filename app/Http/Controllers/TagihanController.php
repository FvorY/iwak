<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use Yajra\Datatables\Datatables;

class TagihanController extends Controller
{
    public function index() {
      return view('tagihan.index');
    }

    public function datatable() {
      $data = DB::table('daftar_tagihan')
      ->join("tagihan", "tagihan_id", '=', "daftar_tagihan_tagihan_id")
      ->join("type", "type_id", "=", "tagihan_type")
      ->join("looptype", "looptype_id", '=', 'tagihan_loop_type')
      ->orderBy("daftar_tagihan_id", "desc")
      ->where("tagihan_users_id", Auth::user()->users_id)
      ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          ->addColumn("statusbayar", function($data) {
            if ($data->daftar_tagihan_bayar == "N") {
              return "Belom";
            } else {
              return "Sudah";
            }
          })
          ->addColumn("jatuhtempo", function($data) {
            if ($data->looptype_id == 1) {
              return Carbon::parse($data->daftar_tagihan_jatuhtempo)->format("d-m-Y");
            } else {
              return Carbon::parse($data->daftar_tagihan_jatuhtempo)->format("d-m-Y");
            }
          })
          ->addColumn("nominal", function($data) {
            return FormatRupiah($data->tagihan_nominal);
          })
          ->addColumn("autodebit", function($data) {
            if ($data->tagihan_autodebit == "Y") {
              return "Yes";
            } else {
              return "No";
            }

          })
          ->addColumn('aksi', function ($data) {

            if ($data->daftar_tagihan_bayar == "N") {
              return  '<div class="btn-group">'.
                       '<button type="button" onclick="bayar('.$data->daftar_tagihan_id.')" class="btn btn-success btn-lg" title="bayar">'.
                       '<label class="fa fa-dollar"></label></button>'.
                    '</div>';
            } else {
              return  '<div class="btn-group">'.
                       '<button type="button" onclick="lihat(this)" data-date="'.Carbon::parse($data->daftar_tagihan_tanggaldibayar)->format('Y-m-d').'" class="btn btn-info btn-lg" title="detail">'.
                       '<label class="fa fa-eye"></label></button>'.
                       '<button type="button" onclick="bayar('.$data->daftar_tagihan_id.')" class="btn btn-success btn-lg" title="bayar">'.
                       '<label class="fa fa-dollar"></label></button>'.
                    '</div>';
            }

          })
          ->rawColumns(['aksi'])
          ->addIndexColumn()
          ->make(true);
    }

    public function simpan(Request $req) {
      $nominal = str_replace("Rp. ", "", $req->nominal);
      $nominal = str_replace(".", "", $nominal);
      if ($req->id == null) {
        DB::beginTransaction();
        try {

        $id = DB::table("tagihan")
            ->insertGetId([
              "tagihan_users_id" => Auth::user()->users_id,
              "tagihan_nominal" => $nominal,
              "tagihan_type" => $req->type,
              "tagihan_loop_type" => $req->looptype,
              "tagihan_autodebit" => $req->autodebit,
              "tagihan_jatuhtempo" => Carbon::parse($req->date)->format('Y-m-d'),
              "tagihan_note" => $req->note,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

            $now = Carbon::now("Asia/Jakarta");
            if ($req->looptype == 1) {
              $loop = Carbon::parse($now)->addMonths(1)->format("Y-m-d H:i:s");
            } //else {
            //   $loop = Carbon::parse($now)->addDays(30)->format("Y-m-d H:i:s");
            // }

          DB::table("daftar_tagihan")
              ->insert([
                "daftar_tagihan_tagihan_id" => $id,
                "daftar_tagihan_bayar" => "N",
                "daftar_tagihan_jatuhtempo" => $loop,
                "created_at" => Carbon::now("Asia/Jakarta")
              ]);

          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2]);
        }
      } else {
        DB::beginTransaction();
        try {

          DB::table("tagihan")
            ->where("tagihan_id", $req->id)
            ->update([
              "tagihan_nominal" => $nominal,
              "tagihan_type" => $req->type,
              "tagihan_loop_type" => $req->looptype,
              "tagihan_autodebit" => $req->autodebit,
              "tagihan_jatuhtempo" => Carbon::parse($req->date)->format('Y-m-d'),
              "tagihan_note" => $req->note,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 4]);
        }
      }

    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("tagihan")
            ->where("tagihan_id", $req->id)
            ->update([
              "tagihan_active" => "N"
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit(Request $req) {
      $data = DB::table("tagihan")
              ->where("tagihan_id", $req->id)
              ->first();

      return response()->json($data);
    }

    public function generatetagihan() {

      $now = Carbon::now("Asia/Jakarta");

      $tagihan = DB::table("daftar_tagihan")
                    ->whereDate('daftar_tagihan_jatuhtempo', '<', $now->toDateString())
                    ->orderBy("daftar_tagihan_id", "DESC")
                    ->groupby("daftar_tagihan_tagihan_id")
                    ->where("daftar_tagihan_bayar", "N")
                    ->get();

      foreach ($tagihan as $key => $value) {
        $tmpdata = DB::table("daftar_tagihan")->where("daftar_tagihan_tagihan_id", $value->daftar_tagihan_tagihan_id)->max("daftar_tagihan_id");

        $tmpdata1 = DB::table("daftar_tagihan")->where("daftar_tagihan_id", $tmpdata)->first();

        $tagihan[$key] = $tmpdata1;
      }

      foreach ($tagihan as $key => $value) {

          $active = DB::table("tagihan")
                    ->where("tagihan_id", $value->daftar_tagihan_tagihan_id)
                    ->first();

          $cekuser = DB::table("users")->where("users_id", $active->tagihan_users_id)->first();

          $ceksaldo = DB::table("uangmasuk")->where("uangmasuk_users_id", $cekuser->users_id)->sum("uangmasuk_nominal");

          if ( $ceksaldo >= $active->tagihan_nominal ) {
            DB::table("daftar_tagihan")
              ->where("daftar_tagihan_id", $value->daftar_tagihan_id)
              ->update([
                "daftar_tagihan_bayar" => "Y",
                "daftar_tagihan_tanggaldibayar" => Carbon::now("Asia/Jakarta")
              ]);

              MutasiController::kirim($cekuser->users_id, $value->daftar_tagihan_id, "tagihan", Carbon::now("Asia/Jakarta"));
          }

          $active = DB::table("tagihan")
                      ->where("tagihan_id", $value->daftar_tagihan_tagihan_id)
                      ->where("tagihan_active", 'Y')
                      ->first();

            $now = $value->daftar_tagihan_jatuhtempo;

            if ($active->tagihan_loop_type == 1) {
              $loop = Carbon::parse($now)->addMonths(1)->format("Y-m-d G:i:s");
            } //else {
            //   $loop = Carbon::parse($now)->addDays(30)->format("Y-m-d G:i:s");
            // }

            DB::table("daftar_tagihan")
              ->insert([
                "daftar_tagihan_tagihan_id" => $value->daftar_tagihan_tagihan_id,
                "daftar_tagihan_bayar" => "N",
                "daftar_tagihan_jatuhtempo" => $loop,
                "created_at" => Carbon::now("Asia/Jakarta")
            ]);
      }

    }

    public function bayar(Request $req) {
      DB::beginTransaction();

      try {

        $saldo = SaldoController::ceksaldo();

        $cektagihan = DB::table("daftar_tagihan")
                          ->join("tagihan", "tagihan_id", "=", "daftar_tagihan_tagihan_id")
                          ->where("daftar_tagihan_id", $req->id)
                          ->first();

        if ((int)$saldo >= (int)$cektagihan->tagihan_nominal) {
            $cektagihan = DB::table("daftar_tagihan")
                            ->where("daftar_tagihan_id", $req->id)
                            ->update([
                              "daftar_tagihan_bayar" => "Y",
                              "daftar_tagihan_tanggaldibayar" => Carbon::now('Asia/Jakarta')
                            ]);

            MutasiController::kirim(Auth::user()->users_id, $req->id, "tagihan", Carbon::now("Asia/Jakarta"));

        } else {
          return response()->json(["status" => 3]);
        }

        DB::commit();
        return response()->json(["status" => 1]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2]);
      }

    }
}
