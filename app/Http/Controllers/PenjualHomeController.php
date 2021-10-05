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
                ->join("payment", "payment.id_transaction", '=', 'transaction.id_transaction')
                ->join("transaction_detail", "transaction_detail.id_transaction", '=', 'transaction.id_transaction')
                ->join("produk", "produk.id_produk", '=', 'transaction_detail.id_produk')
                ->sum("produk.price");

       $pesananbelomterbayar = DB::table("transaction")
                            ->where("id_penjual", Auth::user()->id_account)
                            ->where("pay", 'N')
                            ->count();

       $pesanansudahterbayar = DB::table("transaction")
                             ->where("id_penjual", Auth::user()->id_account)
                             ->where("pay", 'Y')
                             ->count();

       $pesananbelomterkirim = DB::table("transaction")
                            ->where("id_penjual", Auth::user()->id_account)
                            ->where("deliver", 'N')
                            ->count();

       return view("homepenjual", compact('omset', 'pesananbelomterbayar', 'pesanansudahterbayar', 'pesananbelomterkirim'));
     }
}
