<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

class CategoryController extends Controller
{
    public function index() {

      $data = DB::table("category")
                ->get();

      return view('category.index', compact('data'));

    }

    public function dosavecategory(Request $request) {
      DB::beginTransaction();
      try {

        $id = DB::table("category")->max('id_category') + 1;

        DB::table("category")
            ->insert([
              "id_category" => $id,
              "category_name" => $request->category
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
      $data = DB::table("category")
                ->where("id_category", $request->id)
                ->first();

      return response()->json($data);
    }

    public function doupdatecategory(Request $request) {
      DB::beginTransaction();
      try {

        DB::table("category")
            ->where("id_category", $request->id)
            ->update([
              "category_name" => $request->category
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

        DB::table("category")
            ->where("id_category", $request->id)
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
