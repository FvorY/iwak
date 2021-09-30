<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

class SocialController extends Controller
{
    public function index() {

      $data = DB::table("social")
                ->get();

      return view('social.index', compact('data'));

    }

    public function dosavecategory(Request $request) {
      DB::beginTransaction();
      try {

        $id = DB::table("social")->max('id') + 1;

        DB::table("social")
            ->insert([
              "id" => $id,
              "socialname" => $request->socialname,
              "sociallink" => $request->sociallink
            ]);

        DB::commit();
        return response()->json([
          "status" => "sukses"
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "status" => "gagal",
        ]);
      }
    }

    public function doeditcategory(Request $request) {
      $data = DB::table("social")
                ->where("id", $request->id)
                ->first();

      return response()->json($data);
    }

    public function doupdatecategory(Request $request) {
      DB::beginTransaction();
      try {

        DB::table("social")
            ->where("id", $request->id)
            ->update([
              "socialname" => $request->socialname,
              "sociallink" => $request->sociallink
            ]);

        DB::commit();
        return response()->json([
          "status" => "sukses"
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "status" => "gagal",
        ]);
      }
    }

    public function dodeletecategory(Request $request) {
      DB::beginTransaction();
      try {

        DB::table("social")
            ->where("id", $request->id)
            ->delete();

        DB::commit();
        return response()->json([
          "status" => "sukses"
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "status" => "gagal",
        ]);
      }
    }
}
