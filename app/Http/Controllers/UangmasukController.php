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

class UangmasukController extends Controller
{
    public function index() {
      return view('uangmasuk.index');
    }

    public function datatable() {
      $data = DB::table('uangmasuk')
        ->where("uangmasuk_users_id", Auth::user()->users_id)
        ->orderBy("uangmasuk_id", "desc")
        ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          ->addColumn("nominal", function($data) {
            return FormatRupiah($data->uangmasuk_nominal);
          })
          ->addColumn("tanggal", function($data) {
            return Carbon::parse($data->created_at)->format("d-m-Y");
          })
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->uangmasuk_id.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->uangmasuk_id.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
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

        $id = DB::table("uangmasuk")
              ->insertGetId([
              "uangmasuk_users_id" => Auth::user()->users_id,
              "uangmasuk_nominal" => $nominal,
              "uangmasuk_note" => $req->note,
              "created_at" => Carbon::parse($req->date)->format("Y-m-d G:i:s"),
            ]);

          MutasiController::kirim(Auth::user()->users_id, $id, "masuk", Carbon::now("Asia/Jakarta"));

          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2]);
        }
      } else {
        DB::beginTransaction();
        try {

          DB::table("uangmasuk")
            ->where("uangmasuk_id", $req->id)
            ->update([
              "uangmasuk_nominal" => $nominal,
              "uangmasuk_note" => $req->note,
              "created_at" => Carbon::parse($req->date)->format("Y-m-d G:i:s"),
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

          MutasiController::kirim(Auth::user()->users_id, $req->id, "masuk", Carbon::now("Asia/Jakarta"));

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

        DB::table("uangmasuk")
            ->where("uangmasuk_id", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit(Request $req) {
      $data = DB::table("uangmasuk")
              ->where("uangmasuk_id", $req->id)
              ->first();

      $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($data);
    }
}
