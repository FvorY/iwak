<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Account;
use Validator;
use Carbon\Carbon;
use Session;
use DB;
use File;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('transaction')
                  ->leftjoin('account', 'account.id_account', '=', 'transaction.id_pembeli')
                  ->where("id_pembeli", Auth::user()->id_account)
                  ->select("transaction.id_transaction", "transaction.subtotal", "transaction.pay", "transaction.deliver", "transaction.cancelled", "transaction.created_at", "transaction.id_penjual", "account.fullname", "transaction.nota","transaction.date", "account.id_account as penjual", "account.id_account as ulasan")
                  ->orderby("date", "DESC")
                  ->get();

        foreach ($data as $key => $value) {
            $value->penjual = DB::table("account")
                                ->where("id_account", $value->id_penjual)
                                ->first();

            $value->ulasan = DB::table("feedback")
                                ->where("id_user", Auth::user()->id_account)
                                ->where("id_toko", $value->id_penjual)
                                ->where("id_transaction", $value->id_transaction)
                                ->first();
        }

        return view('pembelihistory/index', compact('data'));
    }

    public function apihistory(Request $req)
    {
        //
        $data = DB::table('transaction')
                  ->leftjoin('account', 'account.id_account', '=', 'transaction.id_pembeli')
                  ->where("id_pembeli", $req->id_account)
                  ->select("transaction.id_transaction", "transaction.subtotal", "transaction.pay", "transaction.deliver", "transaction.cancelled", "transaction.created_at", "transaction.id_penjual", "account.fullname", "transaction.nota","transaction.date", "account.id_account as penjual", "account.id_account as ulasan")
                  ->orderby("date", "DESC")
                  ->get();

        foreach ($data as $key => $value) {
            $value->penjual = DB::table("account")
                                ->where("id_account", $value->id_penjual)
                                ->first();

            $value->ulasan = DB::table("feedback")
                                ->where("id_user", $req->id_account)
                                ->where("id_toko", $value->id_penjual)
                                ->where("id_transaction", $value->id_transaction)
                                ->first();
        }

        return Response()->json([
          "code" => 200,
          "message" => "Sukses",
          'data' => $data
        ])
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function pay(Request $req) {
        DB::beginTransaction();
        try {

          $max = $req->id;

          $imgPath = null;
          $tgl = Carbon::now('Asia/Jakarta');
          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/Payment/' . $max;
          $childPath = $dir . '/';
          $path = $childPath;

          $file = $req->file('image');
          $name = null;
          if ($file != null) {
              $this->deleteDir($dir);
              $name = $folder . '.' . $file->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      if ($_FILES['image']['type'] == 'image/webp') {

                      } else if ($_FILES['image']['type'] == 'webp') {

                      } else {
                        compressImage($_FILES['image']['type'],$_FILES['image']['tmp_name'],$_FILES['image']['tmp_name'],75);
                      }
                      $file->move($path, $name);
                      $imgPath = $childPath . $name;
                  } else
                      $imgPath = null;
              } else {
                  return 'already exist';
              }
          }

          DB::table("payment")
              ->insert([
              "id_transaction" => $max,
              "image" => $imgPath,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 4]);
        }
    }

    public function apipay(Request $req) {
        DB::beginTransaction();
        try {

          $max = $req->id;

          $imgPath = null;
          $tgl = Carbon::now('Asia/Jakarta');
          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/Payment/' . $max;
          $childPath = $dir . '/';
          $path = $childPath;

          $file = $req->file('image');
          $name = null;
          if ($file != null) {
              $this->deleteDir($dir);
              $name = $folder . '.' . $file->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      if ($_FILES['image']['type'] == 'image/webp') {

                      } else if ($_FILES['image']['type'] == 'webp') {

                      } else {
                        compressImage($_FILES['image']['type'],$_FILES['image']['tmp_name'],$_FILES['image']['tmp_name'],75);
                      }
                      $file->move($path, $name);
                      $imgPath = $childPath . $name;
                  } else
                      $imgPath = null;
              } else {
                  return 'already exist';
              }
          }

          DB::table("payment")
              ->insert([
              "id_transaction" => $max,
              "image" => $imgPath,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

            DB::commit();
            return response()->json([
              "code" => 200,
              "message" => "Sukses",
            ]);
          } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
              "code" => 400,
              "message" => $e,
            ]);
        }
    }

    public function inputulasan(Request $req) {
        DB::beginTransaction();
        try {

          $max = DB::table("feedback")->max('id_feedback') + 1;

          $imgPath = null;
          $tgl = Carbon::now('Asia/Jakarta');
          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/Ulasan/' . $max;
          $childPath = $dir . '/';
          $path = $childPath;

          $file = $req->file('image');
          $name = null;
          if ($file != null) {
              $this->deleteDir($dir);
              $name = $folder . '.' . $file->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      if ($_FILES['image']['type'] == 'image/webp') {

                      } else if ($_FILES['image']['type'] == 'webp') {

                      } else {
                        compressImage($_FILES['image']['type'],$_FILES['image']['tmp_name'],$_FILES['image']['tmp_name'],75);
                      }
                      $file->move($path, $name);
                      $imgPath = $childPath . $name;
                  } else
                      $imgPath = null;
              } else {
                  return 'already exist';
              }
          }

          $toko = DB::table('transaction')->where("id_transaction", $req->id)->first();
          if ($imgPath == null) {
            DB::table("feedback")
              ->insert([
                'id_feedback' => $max,
                'id_user' => Auth::user()->id_account,
                'id_toko' => $toko->id_penjual,
                'id_transaction' => $req->id,
                'star' => $req->rating,
                'feedback' => $req->ulasan,
                'created_at' => Carbon::now('Asia/Jakarta'),
              ]);
          } else {
            DB::table("feedback")
              ->insert([
                'id_feedback' => $max,
                'id_user' => Auth::user()->id_account,
                'id_toko' => $toko->id_penjual,
                'id_transaction' => $req->id,
                'star' => $req->rating,
                'image' => $imgPath,
                'feedback' => $req->ulasan,
                'created_at' => Carbon::now('Asia/Jakarta'),
              ]);
          }

          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 4]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteDir($dirPath)
     {
         if (!is_dir($dirPath)) {
             return false;
         }
         if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
             $dirPath .= '/';
         }
         $files = glob($dirPath . '*', GLOB_MARK);
         foreach ($files as $file) {
             if (is_dir($file)) {
                 self::deleteDir($file);
             } else {
                 unlink($file);
             }
         }
         rmdir($dirPath);
     }
}
