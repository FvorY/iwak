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

class MastertagihanController extends Controller
{
    public function index() {
      $type = DB::table("type")->get();
      $looptype = DB::table("looptype")->get();

      return view('mastertagihan.index', compact("type", "looptype"));
    }

    public function datatable() {
      $data = DB::table('tagihan')
      ->join("type", "type_id", "=", "tagihan_type")
      ->join("looptype", "looptype_id", '=', 'tagihan_loop_type')
      ->where("tagihan_active", "Y")
      ->where("tagihan_users_id", Auth::user()->users_id)
      ->orderBy("tagihan_id", "desc")
      ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
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
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->tagihan_id.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->tagihan_id.')" class="btn btn-danger btn-lg" title="hapus">'.
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
              "updated_at" => Carbon::now('Asia/Jakarta'),
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
}
