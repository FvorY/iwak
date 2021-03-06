<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

use Yajra\Datatables\Datatables;

class PenjualListpesananController extends Controller
{
    public function index() {
      return view('penjualpesanan.index');
    }

    public function datatable() {
      $data = DB::table('transaction')
        ->leftjoin('account', 'account.id_account', '=', 'transaction.id_pembeli')
        ->where("id_penjual", Auth::user()->id_account)
        ->select("transaction.id_transaction", "transaction.subtotal", "transaction.pay", "transaction.deliver", "transaction.cancelled", "transaction.created_at", "account.fullname", "transaction.nota", "account.id_account")
        ->orderby("date", "DESC")
        ->get();

        return Datatables::of($data)
          ->addColumn("date", function($data) {
            return Carbon::parse($data->created_at)->format("d F y G:i:s");
          })
          ->addColumn("subtotal", function($data) {
            return FormatRupiahFront($data->subtotal);
          })
          ->addColumn("status", function($data) {
              $stat = '<span class="badge badge-warning"> Order Made </span>';

              if ($data->pay == "Y") {
                $stat = '<span class="badge badge-success"> Already paid </span>';
              }

              if ($data->deliver == "P") {
                $stat = '<span class="badge badge-warning"> Delivery process </span>';
              }

              if ($data->deliver == "Y") {
                $stat = '<span class="badge badge-success"> It has been sent </span>';
              }

              if ($data->cancelled == "Y") {
                $stat = '<span class="badge badge-danger"> Order Canceled </span>';
              }

              return $stat;
          })
          ->addColumn('aksi', function ($data) {
            $aksi = '<div class="btn-group">';

            $aksi = $aksi . '<button type="button" onclick="detail('.$data->id_transaction.')" class="btn btn-info btn-lg" title="Detail">'.
            '<label class="fa fa-folder"></label></button>';

            $aksi = $aksi . '<button type="button" onclick="showChat('.$data->id_account.')" class="btn btn-info btn-lg" title="Detail">'.
            '<label class="fa fa-comment"></label></button>';

            $aksi = $aksi . '<button type="button" onclick="showpayment('.$data->id_transaction.')" class="btn btn-success btn-lg" title="Show Payment">'.
            '<label class="fa fa-dollar"></label></button>';

            if ($data->cancelled == "N") {
              if ($data->pay == "Y") {
                if ($data->deliver == "N") {
                  $aksi = $aksi . '<button type="button" onclick="deliver('.$data->id_transaction.')" class="btn btn-primary btn-lg" title="Deliver">'.
                  '<label class="fa fa-truck"></label></button>';
                } else if ($data->deliver == "P") {
                  $aksi = $aksi . '<button type="button" onclick="deliverdone('.$data->id_transaction.')" class="btn btn-primary btn-lg" title="Deliver Done">'.
                  '<label class="fa fa-truck-loading"></label></button>';
                }
              } else {
                $aksi = $aksi . '<button type="button" onclick="cancel('.$data->id_transaction.')" class="btn btn-warning btn-lg" title="Cancel">'.
                '<label class="fa fa-close"></label></button>';
              }
            }

            $aksi = $aksi . '<button type="button" onclick="hapus('.$data->id_transaction.')" class="btn btn-danger btn-lg" title="Hapus">'.
            '<label class="fa fa-trash"></label></button>';

            return $aksi;
          })
          ->rawColumns(['aksi', 'status'])
          ->addIndexColumn()
          ->make(true);
    }

    public function showpayment($id) {
      $data = DB::table("payment")
              ->join('transaction', 'transaction.id_transaction', '=', 'payment.id_transaction')
              ->orderby('payment.created_at', "DESC")
              ->where("payment.id_transaction", $id)
              ->get();

      return Datatables::of($data)
        ->addColumn("image", function($data) {
          return '<div> <img src="'.url('/').'/'.$data->image.'" style="height: 100px; width:100px; border-radius: 0px;" class="img-responsive"> </img> </div>';
        })
        ->addColumn('aksi', function ($data) {
          return '<a class="btn btn-primary" href="'.url('/').'/'.$data->image.'" target="_blank"> Preview </a>';
        })
        ->addColumn('approve', function ($data) {
          if ($data->cancelled == "N") {
            if ($data->pay == "N") {
              return '<button type="button" onclick="approve('.$data->id_payment.')" class="btn btn-success btn-lg" title="Approve">'.
              '<label class="fa fa-check"></label></button>';
            }
          }
        })
        ->rawColumns(['aksi', 'image', 'approve'])
        ->addIndexColumn()
        ->make(true);
    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        $transaction = DB::table("transaction")
                      ->where("id_transaction", $req->id)
                      ->first();

        if ($transaction->cancelled == "N") {
          $cekdetail = DB::table('transaction_detail')
                        ->where('id_transaction', $req->id)
                        ->get();

          for ($i=0; $i < count($cekdetail); $i++) {

            $cekproduk = DB::table('produk')
                        ->where("id_produk", $cekdetail[$i]->id_produk)
                        ->first();

            DB::table('produk')
              ->where("id_produk", $cekdetail[$i]->id_produk)
              ->update([
                'stock' => $cekproduk->stock + $cekdetail[$i]->qty,
                'sold' => $cekproduk->sold - $cekdetail[$i]->qty,
              ]);
          }
        }

        DB::table("transaction")
            ->where("id_transaction", $req->id)
            ->delete();

        DB::table("transaction_detail")
          ->where("id_transaction", $req->id)
          ->delete();

        DB::table("payment")
          ->where("id_transaction", $req->id)
          ->delete();

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function cancel(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("transaction")
            ->where("id_transaction", $req->id)
            ->update([
              "cancelled" => "Y"
            ]);

        $cekdetail = DB::table('transaction_detail')
                      ->where('id_transaction', $req->id)
                      ->get();

        for ($i=0; $i < count($cekdetail); $i++) {

          $cekproduk = DB::table('produk')
                      ->where("id_produk", $cekdetail[$i]->id_produk)
                      ->first();

          DB::table('produk')
            ->where("id_produk", $cekdetail[$i]->id_produk)
            ->update([
              'stock' => $cekproduk->stock + $cekdetail[$i]->qty,
              'sold' => $cekproduk->sold - $cekdetail[$i]->qty,
            ]);
        }

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function approve(Request $req) {
      DB::beginTransaction();
      try {

        $payment = DB::table("payment")
                      ->where("id_payment", $req->id)
                      ->first();

        DB::table("payment")
            ->where("id_payment", $req->id)
            ->update([
              "confirm" => "Y"
            ]);

        DB::table("transaction")
            ->where("id_transaction", $payment->id_transaction)
            ->update([
              "pay" => "Y"
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function apiapprove(Request $req) {
      DB::beginTransaction();
      try {

        $payment = DB::table("payment")
                      ->where("id_payment", $req->id)
                      ->first();

        DB::table("payment")
            ->where("id_payment", $req->id)
            ->update([
              "confirm" => "Y"
            ]);

        DB::table("transaction")
            ->where("id_transaction", $payment->id_transaction)
            ->update([
              "pay" => "Y"
            ]);

        DB::commit();
        return response()->json([
          "code" => 200,
          "message" => "Sukses",
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "code" => 200,
          "message" => $e->getMessage(),
        ]);
      }

    }

    public function deliver(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("transaction")
            ->where("id_transaction", $req->id)
            ->update([
              "deliver" => "P"
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function deliverdone(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("transaction")
            ->where("id_transaction", $req->id)
            ->update([
              "deliver" => "Y"
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function detail(Request $req) {

        $data = DB::table("transaction_detail")
            ->join('produk', 'produk.id_produk', '=', 'transaction_detail.id_produk')
            ->join("transaction", 'transaction.id_transaction', '=', 'transaction_detail.id_transaction')
            ->join('account', 'account.id_account', '=', 'transaction.id_pembeli')
            ->select('produk.name', 'transaction_detail.qty', 'transaction_detail.price', 'account.address', 'account.bank', 'account.nomor_rekening')
            ->where("transaction_detail.id_transaction", $req->id)
            ->get();

        return response()->json($data);

    }

    public function apilistorder(Request $req) {
      $data = DB::table('transaction')
        ->leftjoin('account', 'account.id_account', '=', 'transaction.id_pembeli')
        ->where("id_penjual", $req->id_account)
        ->select("transaction.id_transaction", "transaction.subtotal", "transaction.pay", "transaction.deliver", "transaction.cancelled", "transaction.created_at", "account.fullname", "transaction.nota")
        ->orderby("date", "DESC")
        ->get();

        return response()->json([
          "code" => 200,
          "message" => "Sukses",
          "data" => $data
        ]);
    }

    public function apicancel(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("transaction")
            ->where("id_transaction", $req->id)
            ->update([
              "cancelled" => "Y"
            ]);

        $cekdetail = DB::table('transaction_detail')
                      ->where('id_transaction', $req->id)
                      ->get();

        for ($i=0; $i < count($cekdetail); $i++) {

          $cekproduk = DB::table('produk')
                      ->where("id_produk", $cekdetail[$i]->id_produk)
                      ->first();

          DB::table('produk')
            ->where("id_produk", $cekdetail[$i]->id_produk)
            ->update([
              'stock' => $cekproduk->stock + $cekdetail[$i]->qty,
              'sold' => $cekproduk->sold - $cekdetail[$i]->qty,
            ]);
        }

        DB::commit();
        return response()->json([
          "code" => 200,
          "message" => "Sukses",
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "code" => 400,
          "message" => "Gagal",
        ]);
      }

    }

    public function apihapus(Request $req) {
      DB::beginTransaction();
      try {

        $transaction = DB::table("transaction")
                      ->where("id_transaction", $req->id)
                      ->first();

        if ($transaction->cancelled == "N") {
          $cekdetail = DB::table('transaction_detail')
                        ->where('id_transaction', $req->id)
                        ->get();

          for ($i=0; $i < count($cekdetail); $i++) {

            $cekproduk = DB::table('produk')
                        ->where("id_produk", $cekdetail[$i]->id_produk)
                        ->first();

            DB::table('produk')
              ->where("id_produk", $cekdetail[$i]->id_produk)
              ->update([
                'stock' => $cekproduk->stock + $cekdetail[$i]->qty,
                'sold' => $cekproduk->sold - $cekdetail[$i]->qty,
              ]);
          }
        }

        DB::table("transaction")
            ->where("id_transaction", $req->id)
            ->delete();

        DB::table("transaction_detail")
          ->where("id_transaction", $req->id)
          ->delete();

        DB::table("payment")
          ->where("id_transaction", $req->id)
          ->delete();

        DB::commit();
        return response()->json([
          "code" => 200,
          "message" => "Sukses",
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "code" => 400,
          "message" => "Gagal",
        ]);
      }

    }

    public function apidetail(Request $req) {

        $data = DB::table("transaction_detail")
            ->join('produk', 'produk.id_produk', '=', 'transaction_detail.id_produk')
            ->select('produk.name', 'transaction_detail.qty', 'transaction_detail.price')
            ->where("id_transaction", $req->id)
            ->get();

        return response()->json($data);

    }

    public function apideliver(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("transaction")
            ->where("id_transaction", $req->id)
            ->update([
              "deliver" => "P"
            ]);

            DB::commit();
            return response()->json([
              "code" => 200,
              "message" => "Sukses",
            ]);
          } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
              "code" => 200,
              "message" => $e->getMessage(),
            ]);
      }

    }

    public function apideliverdone(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("transaction")
            ->where("id_transaction", $req->id)
            ->update([
              "deliver" => "Y"
            ]);

            DB::commit();
            return response()->json([
              "code" => 200,
              "message" => "Sukses",
            ]);
          } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
              "code" => 200,
              "message" => $e->getMessage(),
            ]);
      }

    }

    public function apishowpayment($id) {
      $data = DB::table("payment")
              ->join('transaction', 'transaction.id_transaction', '=', 'payment.id_transaction')
              ->orderby('payment.created_at', "DESC")
              ->where("payment.id_transaction", $id)
              ->get();

      return response()->json([
        "code" => 200,
        "message" => "Sukses",
        "data" => $data
      ]);
    }

    // public function apiapprove(Request $req) {
    //   DB::beginTransaction();
    //   try {
    //
    //     $payment = DB::table("payment")
    //                   ->where("id_payment", $req->id)
    //                   ->first();
    //
    //     DB::table("payment")
    //         ->where("id_payment", $req->id)
    //         ->update([
    //           "confirm" => "Y"
    //         ]);
    //
    //     DB::table("transaction")
    //         ->where("id_transaction", $payment->id_transaction)
    //         ->update([
    //           "pay" => "Y"
    //         ]);
    //
    //     DB::commit();
    //     return response()->json(["status" => 3]);
    //   } catch (\Exception $e) {
    //     DB::rollback();
    //     return response()->json(["status" => 4]);
    //   }
    // }

    public function pesanannotif() {
      $data = DB::table("transaction")
                ->where("id_penjual", Auth::user()->id_account)
                ->whereDate('created_at', Carbon::today())
                ->get();

      return response()->json(count($data));
    }
}
