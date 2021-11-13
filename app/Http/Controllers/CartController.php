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

class CartController extends Controller
{
    public function countcart() {
       $cart = DB::table('cart')
                ->where("id_account", Auth::user()->id_account)
                ->count();

        return Response()->json($cart);
    }

    public function apicountcart(Request $req) {
       $cart = DB::table('cart')
                ->where("id_account", $req->id_account)
                ->count();

        return Response()->json($cart);
    }

    public function viewcart() {
      $cart = DB::table('cart')
               ->join('produk', 'produk.id_produk', '=', 'cart.id_produk')
               ->join('account', 'account.id_account', '=', 'produk.id_account')
               ->leftjoin('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
               ->where("cart.id_account", Auth::user()->id_account)
               ->groupby("cart.id_produk")
               ->get();

      return view('checkout', compact('cart'));
    }

    public function opencart() {
       $cart = DB::table('cart')
                ->join('produk', 'produk.id_produk', '=', 'cart.id_produk')
                ->leftjoin('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                ->where("cart.id_account", Auth::user()->id_account)
                ->groupby("cart.id_produk")
                ->get();

        return Response()->json($cart);
    }

    public function apiopencart(Request $req) {
       $cart = DB::table('cart')
                ->join('produk', 'produk.id_produk', '=', 'cart.id_produk')
                ->leftjoin('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                ->where("cart.id_account", $req->id_account)
                ->groupby("cart.id_produk")
                ->get();

        return Response()->json($cart);
    }

    public function deletecart(Request $req) {
        DB::table('cart')
                ->where('id_cart', $req->id)
                ->delete();

        return Response()->json('sukses');
    }

    public function changetoko(Request $req) {
        DB::table('cart')
          ->where('id_account', Auth::user()->id_account)
          ->delete();

        DB::table("cart")
          ->insert([
            "id_produk" => $req->id,
            "id_account" => Auth::user()->id_account,
            "qty" => 1,
            "created_at" => Carbon::now('Asia/Jakarta'),
          ]);

        return Response()->json('sukses');
    }

    public function addcart(Request $req) {
      DB::beginTransaction();
      try {

        $cekcart = DB::table("cart")
                    ->join('produk', 'produk.id_produk', '=', 'cart.id_produk')
                    ->where("cart.id_account", Auth::user()->id_account)
                    ->first();

        $cekexist = DB::table("produk")
                      ->where("produk.id_produk", $req->id)
                      ->first();

        if ($cekcart != null && $cekexist != null) {
          if ($cekexist->id_account != $cekcart->id_account) {
            return response()->json(["status" => 7]);
          }
        }

        $cek = DB::table("cart")->join('produk', 'produk.id_produk', '=', 'cart.id_produk')->where("cart.id_account", Auth::user()->id_account)->where("produk.id_produk", $req->id)->first();

        if ($cek == null) {
          DB::table("cart")
            ->insert([
              "id_produk" => $req->id,
              "id_account" => Auth::user()->id_account,
              "qty" => 1,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

            DB::commit();
            return response()->json(["status" => 1]);
        } else {
          DB::table("cart")
            ->where("id_cart", $cek->id_cart)
            ->update([
              "qty" => (int)$cek->qty + 1,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

            DB::commit();
            return response()->json(["status" => 3]);
        }

      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function apiaddcart(Request $req) {
      DB::beginTransaction();
      try {

        $cekcart = DB::table("cart")
                    ->join('produk', 'produk.id_produk', '=', 'cart.id_produk')
                    ->where("cart.id_account", $req->id_account)
                    ->first();

        $cekexist = DB::table("produk")
                      ->where("produk.id_produk", $req->id)
                      ->first();

        if ($cekcart != null && $cekexist != null) {
          if ($cekexist->id_account != $cekcart->id_account) {
            return response()->json([
              "code" => 400,
              "message" => "Mau ganti card ke toko lain?",
            ]);
          }
        }

        $cek = DB::table("cart")->join('produk', 'produk.id_produk', '=', 'cart.id_produk')->where("cart.id_account", Auth::user()->id_account)->where("produk.id_produk", $req->id)->first();

        if ($cek == null) {
          DB::table("cart")
            ->insert([
              "id_produk" => $req->id,
              "id_account" => $req->id_account,
              "qty" => 1,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

            DB::commit();
            return response()->json(["status" => 1]);
        } else {
          DB::table("cart")
            ->where("id_cart", $cek->id_cart)
            ->update([
              "qty" => (int)$cek->qty + 1,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

            DB::commit();
            return response()->json([
              "code" => 200,
              "message" => "Sukses",
            ]);
        }

      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "code" => 400,
          "message" => $e,
        ]);
      }

    }

    public function checkout(Request $req) {
        DB::beginTransaction();
        try {

          $arridproduk = json_decode($req->arridproduk);
          $arrqty = json_decode($req->arrqty);
          $arrprice = json_decode($req->arrprice);

          $max = DB::table("transaction")->max('id_transaction') + 1;

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
          } else {
              return response()->json(["status" => 7, "message" => "Upload bukti pembayaran terlebih dahulu!"]);
          }

          $index = str_pad($max, 3, '0', STR_PAD_LEFT);
          $date = date('my');
          $nota = 'PO-'.$index.'/'.$date;

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp ','',$price);

          $subtotal = str_replace('.','',$req->subtotal);
          $subtotal = str_replace('Rp ','',$subtotal);

          DB::table("transaction")
              ->insert([
              "id_transaction" => $max,
              "nota" => $nota,
              "id_pembeli" => Auth::user()->id_account,
              "id_penjual" => $req->id_penjual,
              "date" => Carbon::now('Asia/Jakarta'),
              "subtotal" => $subtotal,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          DB::table("payment")
              ->insert([
              "id_transaction" => $max,
              "image" => $imgPath,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          for ($i=0; $i < count($arridproduk); $i++) {
              $price = str_replace('.','',$arrprice[$i]);
              $price = str_replace('Rp ','',$price);

              $max1 = DB::table("transaction_detail")->max('id_detail') + 1;

              DB::table("transaction_detail")
                  ->insert([
                  "id_detail" => $max1,
                  "id_transaction" => $max,
                  "id_produk" => $arridproduk[$i],
                  "price" => $price,
                  "qty" => $arrqty[$i],
                ]);

              $cekproduk = DB::table('produk')
                          ->where("id_produk", $arridproduk[$i])
                          ->first();

              DB::table('produk')
                ->where("id_produk", $arridproduk[$i])
                ->update([
                  'stock' => $cekproduk->stock - $arrqty[$i],
                  'sold' => $cekproduk->sold + $arrqty[$i],
                ]);

              DB::table('cart')
                  ->where('id_account', Auth::user()->id_account)
                  ->delete();
          }

          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 4]);
        }
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
