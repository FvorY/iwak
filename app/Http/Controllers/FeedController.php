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

class FeedController extends Controller
{
    public function index() {
      return view('feedback.index');
    }

    public function penjualindex() {
      return view('penjualfeedback.index');
    }

    public function datatable() {
      $data = DB::table('feedback')
        ->select("feedback.star", "feedback.image", "feedback.id_feedback", "feedback.id_user as akun", "feedback.feedback", "feedback.id_toko as toko")
        ->orderBy("feedback.created_at", "desc")
        ->get();

        foreach ($data as $key => $value) {
          $data[$key]->akun = DB::table("account")->where("id_account", $data[$key]->akun)->first();
          $data[$key]->toko = DB::table("account")->where("id_account", $data[$key]->toko)->first();
        }
        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          ->addColumn("star", function($data) {
              if ($data->star == 0) {
                return '<span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 1) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 2) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 3) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 4) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 5) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
              }
          })
          ->addColumn("username", function($data) {
            if ($data->akun == null) {
              return "<span style='color: red;'> User tidak ditemukan (Dihapus dari sistem) <span>";
            } else {
              return $data->akun->fullname;
            }
          })
          ->addColumn("namatoko", function($data) {
            if ($data->toko == null) {
              return "<span style='color: red;'> Toko tidak ditemukan (Dihapus dari sistem) <span>";
            } else {
              return $data->toko->namatoko;
            }
          })
          ->addColumn("image", function($data) {
            return '<div> <img src="'.url('/').'/'.$data->image.'" style="height: 100px; width:100px; border-radius: 0px;" class="img-responsive"> </img> </div>';
          })
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="hapus('.$data->id_feedback.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi', 'image', 'username', 'star', 'namatoko'])
          ->addIndexColumn()
          ->make(true);
    }

    public function apifeed(Request $req) {
      $data = DB::table('produk')
        ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
        ->select('imageproduk.*', 'produk.*', 'produk.star as feedback')
        ->groupBy('produk.id_produk')
        ->where("id_account", $req->id_account)
        ->get();

        foreach ($data as $key => $value) {
          $value->star = DB::table("transaction_detail")
                      ->join('feedback', 'feedback.id_transaction','transaction_detail.id_transaction')
                      ->join("account", 'account.id_account', 'feedback.id_user')
                      ->where("transaction_detail.id_produk", $value->id_produk)
                      ->groupBy('feedback.id_feedback')
                      ->select('transaction_detail.id_produk','transaction_detail.price','feedback.id_feedback','feedback.id_user','feedback.id_toko','feedback.star','feedback.image','feedback.feedback','feedback.created_at','account.id_account','account.fullname','account.email')
                      // ->having('feedback.created_at')
                      ->avg('feedback.star');

          $value->feedback = DB::table('transaction_detail')
                                ->leftjoin('feedback', 'feedback.id_transaction', '=', 'transaction_detail.id_transaction')
                                ->where("id_produk", '=', $value->id_produk)
                                ->groupBy('feedback.id_feedback')
                                ->orderBy('feedback.created_at', 'desc')
                                ->get();
        }

        return response()->json([
          "code" => 200,
          "message" => "Sukses",
          "data" => $data,
        ]);
    }

    public function datatablewtoko() {
      $data = DB::table('feedback')
        ->join('transaction', 'transaction.id_transaction', '=', 'feedback.id_transaction')
        ->select("feedback.star", "feedback.image", 'transaction.nota', "feedback.id_feedback", "feedback.id_user as akun", "feedback.feedback", "feedback.id_toko as toko")
        ->orderBy("feedback.created_at", "desc")
        ->where("id_toko", Auth::user()->id_account)
        ->get();

        foreach ($data as $key => $value) {
          $data[$key]->akun = DB::table("account")->where("id_account", $data[$key]->akun)->first();
          $data[$key]->toko = DB::table("account")->where("id_account", $data[$key]->toko)->first();
        }

        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          ->addColumn("star", function($data) {
              if ($data->star == 0) {
                return '<span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 1) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 2) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 3) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 4) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span>';
              } else if ($data->star == 5) {
                return '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
              }
          })
          ->addColumn("username", function($data) {
            if ($data->akun == null) {
              return "<span style='color: red;'> User tidak ditemukan (Dihapus dari sistem) <span>";
            } else {
              return $data->akun->fullname;
            }
          })
          ->addColumn("image", function($data) {
            return '<div> <img src="'.url('/').'/'.$data->image.'" style="height: 100px; width:100px; border-radius: 0px;" class="img-responsive"> </img> </div>';
          })
          ->rawColumns(['image', 'username', 'star'])
          ->addIndexColumn()
          ->make(true);
    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("feedback")
            ->where("id_feedback", $req->id)
            ->delete();

        $dir = 'image/uploads/Feed/' . $req->id;

        $this->deleteDir($dir);

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
