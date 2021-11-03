<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Account;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use Response;

class PenjualHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index() {
       $omset = DB::table("transaction")
                ->where("id_penjual", Auth::user()->id_account)
                ->where("pay", "Y")
                ->sum("transaction.subtotal");

       $pesananbelomterbayar = DB::table("transaction")
                            ->where("id_penjual", Auth::user()->id_account)
                            ->where("cancelled", 'N')
                            ->where("pay", 'N')
                            ->count();

       $pesanansudahterbayar = DB::table("transaction")
                             ->where("id_penjual", Auth::user()->id_account)
                             ->where("cancelled", 'N')
                             ->where("pay", 'Y')
                             ->count();

       $pesananbelomterkirim = DB::table("transaction")
                            ->where("id_penjual", Auth::user()->id_account)
                            ->where("cancelled", 'N')
                            ->where("deliver", 'N')
                            ->count();

      $feedback = DB::table("feedback")->where("id_toko", Auth::user()->id_account)->count();

       return view("homepenjual", compact('omset', 'pesananbelomterbayar', 'pesanansudahterbayar', 'pesananbelomterkirim', 'feedback'));
     }

     public function apilaporan(Request $req) {
         $omset = DB::table("transaction")
                  ->where("id_penjual", $req->id_account)
                  ->where("pay", "Y")
                  ->sum("transaction.subtotal");

         $pesananbelomterbayar = DB::table("transaction")
                              ->where("id_penjual", $req->id_account)
                              ->where("cancelled", 'N')
                              ->where("pay", 'N')
                              ->count();

         $pesanansudahterbayar = DB::table("transaction")
                               ->where("id_penjual", $req->id_account)
                               ->where("cancelled", 'N')
                               ->where("pay", 'Y')
                               ->count();

         $pesananbelomterkirim = DB::table("transaction")
                              ->where("id_penjual", $req->id_account)
                              ->where("cancelled", 'N')
                              ->where("deliver", 'N')
                              ->count();

        $feedback = DB::table("feedback")->where("id_toko", $req->id_account)->count();

        return response()->json([
          "code" => 200,
          "message" => "Sukses",
          "omset" => $omset,
          "pesananbelomterbayar" => $pesananbelomterbayar,
          "pesanansudahterbayar" => $pesanansudahterbayar,
          "pesananbelomterkirim" => $pesananbelomterkirim,
          "pesananbelomterkirim" => $pesananbelomterkirim,
          "feedback" => $feedback
        ]);
     }
}
