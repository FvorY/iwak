<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

use Yajra\Datatables\Datatables;

use Response;

class ProfileTokoController extends Controller
{
    public function index($id) {
      if (Auth::check()) {
        if (Auth::user()->id_account == $id) {
          return view('error-404');
        } else {
          $sort = "DESC";
          $sortfield = "name";

          $cek = DB::table("account")
                  ->where("id_account", $id)
                  ->first();

          $produk = DB::table("produk")
                    ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                    ->join("account", 'produk.id_account', 'account.id_account')
                    ->where("produk.id_account", $id)
                    ->groupby("imageproduk.id_produk")
                    ->orderby('produk.'.$sortfield, $sort)
                    ->paginate(10);
                    // dd($produk);
          if (substr($cek->phone, 0, 1) == "+") {
            $cek->phone = str_replace("+", "", $cek->phone);
          } else if (substr($cek->phone, 0, 1) == "0") {
            $cek->phone = str_replace("0", "62", $cek->phone);
          }

          if ($cek == null) {
              return redirect('/');
          } else {
            if ($cek->namatoko == null || $cek->istoko == "N") {
              return redirect('/');
            } else {
              $countproduk = DB::table("produk")
                            ->where("produk.stock", '>' , 0)
                            ->orderby('produk.sold', 'DESC')
                            ->where("id_account", $id)
                            ->count();

              $countreview = DB::table("feedback")
                            ->where("id_toko", $id)
                            ->count();

              $avgstar = DB::table("feedback")
                            ->where("id_toko", $id)
                            ->avg('star');

              return view('toko_profile', compact('cek', 'countproduk', 'countreview', 'avgstar','produk'));
            }
          }
        }
      } else {
        $sort = "DESC";
        $sortfield = "name";

        $cek = DB::table("account")
                ->where("id_account", $id)
                ->first();

        $produk = DB::table("produk")
                  ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                  ->join("account", 'produk.id_account', 'account.id_account')
                  ->where("produk.id_account", $id)
                  ->groupby("imageproduk.id_produk")
                  ->orderby('produk.'.$sortfield, $sort)
                  ->paginate(10);
                  // dd($produk);
        if (substr($cek->phone, 0, 1) == "+") {
          $cek->phone = str_replace("+", "", $cek->phone);
        } else if (substr($cek->phone, 0, 1) == "0") {
          $cek->phone = str_replace("0", "62", $cek->phone);
        }

        if ($cek == null) {
            return redirect('/');
        } else {
          if ($cek->namatoko == null || $cek->istoko == "N") {
            return redirect('/');
          } else {
            $countproduk = DB::table("produk")
                          ->where("produk.stock", '>' , 0)
                          ->orderby('produk.sold', 'DESC')
                          ->where("id_account", $id)
                          ->count();

            $countreview = DB::table("feedback")
                          ->where("id_toko", $id)
                          ->count();

            $avgstar = DB::table("feedback")
                          ->where("id_toko", $id)
                          ->avg('star');

            return view('toko_profile', compact('cek', 'countproduk', 'countreview', 'avgstar','produk'));
          }
        }
      }

    }

    public function apitoko(Request $req) {
      $id = $req->id;
      if ($req->id_account == $id) {
        return view('error-404');
      } else {
        $sort = "DESC";
        $sortfield = "name";

        $cek = DB::table("account")
                ->where("id_account", $id)
                ->first();

        $produk = DB::table("produk")
                  ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                  ->join("account", 'produk.id_account', 'account.id_account')
                  ->where("produk.id_account", $id)
                  ->groupby("imageproduk.id_produk")
                  ->orderby('produk.'.$sortfield, $sort)
                  ->paginate(10);
                  // dd($produk);
        if (substr($cek->phone, 0, 1) == "+") {
          $cek->phone = str_replace("+", "", $cek->phone);
        } else if (substr($cek->phone, 0, 1) == "0") {
          $cek->phone = str_replace("0", "62", $cek->phone);
        }

        if ($cek == null) {
            return redirect('/');
        } else {
          if ($cek->namatoko == null || $cek->istoko == "N") {
            return redirect('/');
          } else {
            $countproduk = DB::table("produk")
                          ->where("produk.stock", '>' , 0)
                          ->orderby('produk.sold', 'DESC')
                          ->where("id_account", $id)
                          ->count();

            $countreview = DB::table("feedback")
                          ->where("id_toko", $id)
                          ->count();

            $avgstar = DB::table("feedback")
                          ->where("id_toko", $id)
                          ->avg('star');

            return view('toko_profile', compact('cek', 'countproduk', 'countreview', 'avgstar','produk'));
          }
        }
      }
    }
}
