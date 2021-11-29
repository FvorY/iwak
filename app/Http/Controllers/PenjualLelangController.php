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

class PenjualLelangController extends Controller
{
    public function index() {
      $produk = DB::table('produk')
                  ->where('id_account', Auth::user()->id_account)
                  ->get();

      return view('penjuallelang.index', compact('produk'));
    }

    public function autocomplete(request $request)
    {
      $results = array();
      $queries = DB::table('account')
                    ->where('fullname', 'like', '%'.strtoupper($request->term).'%')
                    ->orWhere('email', 'like', '%'.strtoupper($request->term).'%')
                    ->orWhere('phone', 'like', '%'.strtoupper($request->term).'%')
                    ->orWhere('address', 'like', '%'.strtoupper($request->term).'%')
                    ->take(10)->get();

      if ($queries == null){
          $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
      } else {

          foreach ($queries as $query)
          {
              $results[] = [ 'id' => $query->id_account,
                      'label' => $query->fullname . ' - ' . $query->email,
                      'namatoko'=>$query->namatoko,
                      'star'=>$query->star,
                      'profile_toko'=>$query->profile_toko,
                    ];
          }
      }

      return Response::json($results);
    }

    public function datatable() {
      $data = DB::table('lelang')
        ->leftjoin('produk', 'produk.id_produk', '=', 'lelang.id_produk')
        ->leftjoin('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
        ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon')
        ->where('lelang.id_account', Auth::user()->id_account)
        ->groupby("lelang.id_lelang")
        ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          ->addColumn("pemenang", function($data) {
            if ($data->iswon == "Y") {
              return  '<div class="btn-group">'.
                       '<button type="button" onclick="pemenang('.$data->id_lelang.')" class="btn btn-info btn-lg" title="Pilih Pemenang">'.
                       '<label> Lihat Pemenang </label></button>'.
                    '</div>';
            } else {
              return "<span class='badge badge-warning'> Belom Ada Pemenang <span>";
            }
          })
          ->addColumn("name", function($data) {
            if ($data->name == null) {
              return "<span style='color: red;'> Produk tidak ditemukan (Dihapus dari sistem) <span>";
            } else {
              return $data->name;
            }
          })
          ->addColumn("image", function($data) {
            return '<div> <img src="'.url('/').'/'.$data->image.'" style="height: 100px; width:100px; border-radius: 0px;" class="img-responsive"> </img> </div>';
          })
          ->addColumn("status", function($data) {
              if ($data->isactive == "Y") {
                return '<span class="badge badge-success"> Aktif </span>';
              } else {
                return '<span class="badge badge-warning"> Nonaktif </span>';
              }
          })
          ->addColumn("price", function($data) {
            return FormatRupiahFront($data->price);
          })
          ->addColumn('aksi', function ($data) {
            if ($data->isactive == "Y") {
              if ($data->name == null) {
                return  '<div class="btn-group">'.
                         '<button type="button" onclick="hapus('.$data->id_lelang.')" class="btn btn-danger btn-lg" title="Nonaktifan">'.
                         '<label class="fa fa-trash"></label></button>'.
                      '</div>';
              } else {
                return  '<div class="btn-group">'.
                         '<button type="button" onclick="listbid('.$data->id_lelang.')" class="btn btn-success btn-lg" title="edit">'.
                         '<label class="fa fa-dollar"></label></button>'.
                         '<button type="button" onclick="edit('.$data->id_lelang.')" class="btn btn-info btn-lg" title="edit">'.
                         '<label class="fa fa-pencil-alt"></label></button>'.
                         '<button type="button" onclick="nonaktif('.$data->id_lelang.')" class="btn btn-warning btn-lg" title="Nonaktifan">'.
                         '<label class="fa fa-close"></label></button>'.
                         '<button type="button" onclick="hapus('.$data->id_lelang.')" class="btn btn-danger btn-lg" title="Nonaktifan">'.
                         '<label class="fa fa-trash"></label></button>'.
                      '</div>';
              }
            } else {
              if ($data->name == null) {
                return  '<div class="btn-group">'.
                         '<button type="button" onclick="hapus('.$data->id_lelang.')" class="btn btn-danger btn-lg" title="Nonaktifan">'.
                         '<label class="fa fa-trash"></label></button>'.
                      '</div>';
              } else {
                if ($data->iswon == "Y") {
                    return  '<div class="btn-group">'.
                             '<button type="button" onclick="listbid('.$data->id_lelang.')" class="btn btn-success btn-lg" title="edit">'.
                             '<label class="fa fa-dollar"></label></button>'.
                             '<button type="button" onclick="hapus('.$data->id_lelang.')" class="btn btn-danger btn-lg" title="Nonaktifan">'.
                             '<label class="fa fa-trash"></label></button>'.
                          '</div>';
                } else {
                  return  '<div class="btn-group">'.
                           '<button type="button" onclick="listbid('.$data->id_lelang.')" class="btn btn-success btn-lg" title="edit">'.
                           '<label class="fa fa-dollar"></label></button>'.
                           '<button type="button" onclick="edit('.$data->id_lelang.')" class="btn btn-info btn-lg" title="edit">'.
                           '<label class="fa fa-pencil-alt"></label></button>'.
                           '<button type="button" onclick="aktif('.$data->id_lelang.')" class="btn btn-primary btn-lg" title="Aktikan">'.
                           '<label class="fa fa-check"></label></button>'.
                           '<button type="button" onclick="hapus('.$data->id_lelang.')" class="btn btn-danger btn-lg" title="Nonaktifan">'.
                           '<label class="fa fa-trash"></label></button>'.
                        '</div>';
                }
              }
            }
          })
          ->rawColumns(['aksi', 'status', 'image', 'name', 'pemenang'])
          ->addIndexColumn()
          ->make(true);
    }

    public function simpan(Request $req) {

        if ($req->price == null) {
            return response()->json(["status" => 7, "message" => "Isi harga awal terlebih dahulu, tidak dapat disimpan!"]);
        }

        if ($req->price == "") {
            return response()->json(["status" => 7, "message" => "Isi harga awal terlebih dahulu, tidak dapat disimpan!"]);
        }

        DB::beginTransaction();
        try {

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp ','',$price);

          DB::table("lelang")
              ->insert([
              "id_produk" => $req->id_produk,
              "id_account" => Auth::user()->id_account,
              "price" => $price,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2]);
        }

    }

    public function update(Request $req) {

        if ($req->price == null) {
            return response()->json(["status" => 7, "message" => "Isi harga awal terlebih dahulu, tidak dapat disimpan!"]);
        }

        if ($req->price == "") {
            return response()->json(["status" => 7, "message" => "Isi harga awal terlebih dahulu, tidak dapat disimpan!"]);
        }

        DB::beginTransaction();
        try {

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp ','',$price);

          DB::table("lelang")
              ->where("id_lelang", $req->id)
              ->update([
              "price" => $price,
              "updated_at" => Carbon::now('Asia/Jakarta'),
            ]);

          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2]);
        }

    }

    public function aktif(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("lelang")
            ->where("id_lelang", $req->id)
            ->update([
              'isactive' => "Y"
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function nonaktif(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("lelang")
            ->where("id_lelang", $req->id)
            ->update([
              'isactive' => "N"
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit(Request $req) {
      $data = DB::table("lelang")
              ->leftjoin('produk', 'produk.id_produk', '=', 'lelang.id_produk')
              ->select("produk.name", "lelang.price", 'id_lelang')
              ->where("id_lelang", $req->id)
              ->first();

      return response()->json($data);
    }

    public function pemenang(Request $req) {
      $data = DB::table("lelangbid")
              ->leftjoin('account', 'account.id_account', '=', 'lelangbid.id_account')
              ->where("id_lelang", $req->id)
              ->where("status", "Y")
              ->first();

      return response()->json($data);
    }

    public function listbid($id) {
      $data = DB::table("lelang")
              ->join('lelangbid', 'lelangbid.id_lelang', '=', 'lelang.id_lelang')
              ->leftjoin('account', 'account.id_account', '=', 'lelangbid.id_account')
              ->select('lelangbid.price', 'account.fullname', 'lelang.iswon', 'lelangbid.id_lelangbid', 'lelangbid.status')
              ->groupby('lelangbid.id_lelangbid')
              ->orderby('lelangbid.id_lelangbid', "DESC")
              ->where("lelang.id_lelang", $id)
              ->get();

      return Datatables::of($data)
        ->addColumn("name", function($data) {
          if ($data->fullname == null) {
            return "<span style='color: red;'> Produk tidak ditemukan (Dihapus dari sistem) <span>";
          } else {
            return $data->fullname;
          }
        })
        ->addColumn("status", function($data) {
          if ($data->status == 'Y') {
            return "<span class='badge badge-success'> Pemenang <span>";
          } else {
            return "";
          }
        })
        ->addColumn("price", function($data) {
          return FormatRupiahFront($data->price);
        })
        ->addColumn('aksi', function ($data) {
          // if ($data->iswon == "Y") {
          //   return "";
          // } else {
          //   if ($data->fullname == null) {
          //     return "";
          //   } else {
              return  '<div class="btn-group">'.
                       '<button type="button" onclick="won('.$data->id_lelangbid.')" class="btn btn-success btn-lg" title="Pilih Pemenang">'.
                       '<label class="fa fa-check"></label></button>'.
                    '</div>';
            // }
          // }
        })
        ->rawColumns(['aksi', 'status', 'image', 'name', 'status'])
        ->addIndexColumn()
        ->make(true);
    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("lelang")
            ->where("id_lelang", $req->id)
            ->delete();

        DB::table("lelangbid")
            ->where("id_lelang", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }
    }

    public function won(Request $req) {
      DB::beginTransaction();
      try {

        $getlelang = DB::table("lelangbid")
                      ->where("id_lelangbid", $req->id)
                      ->first();

        DB::table("lelangbid")
          ->where("id_lelang", $getlelang->id_lelang)
          ->update([
            'status' => 'N',
          ]);

        DB::table("lelangbid")
            ->where("id_lelangbid", $req->id)
            ->update([
              'status' => "Y"
            ]);

        DB::table("lelang")
            ->where("id_lelang", $getlelang->id_lelang)
            ->update([
              'iswon' => "Y",
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function apilelang(Request $req) {
        $data = DB::table('lelang')
          ->leftjoin('produk', 'produk.id_produk', '=', 'lelang.id_produk')
          ->leftjoin('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
          ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon')
          ->where('lelang.id_account', $req->id_account)
          ->groupby("lelang.id_lelang")
          ->get();

        return response()->json([
          "code" => 200,
          "message" => "Sukses",
          "data" => $data
        ]);
    }

    public function apilistbid($id) {
      $data = DB::table("lelang")
              ->join('lelangbid', 'lelangbid.id_lelang', '=', 'lelang.id_lelang')
              ->leftjoin('account', 'account.id_account', '=', 'lelangbid.id_account')
              ->select('lelangbid.price', 'account.fullname', 'lelang.iswon', 'lelangbid.id_lelangbid')
              ->groupby('lelangbid.id_lelangbid')
              ->orderby('lelangbid.id_lelangbid', "DESC")
              ->where("lelang.id_lelang", $id)
              ->get();

        return response()->json([
          "code" => 200,
          "message" => "Sukses",
          "data" => $data
        ]);
    }

    public function apihapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("lelang")
            ->where("id_lelang", $req->id)
            ->delete();

        DB::table("lelangbid")
            ->where("id_lelang", $req->id)
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
          "message" => $e,
        ]);
      }
    }

    public function apiaktif(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("lelang")
            ->where("id_lelang", $req->id)
            ->update([
              'isactive' => "Y"
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

    public function apinonaktif(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("lelang")
            ->where("id_lelang", $req->id)
            ->update([
              'isactive' => "N"
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

    public function apiview(Request $req) {
      $data = DB::table("lelang")
              ->leftjoin('produk', 'produk.id_produk', '=', 'lelang.id_produk')
              ->select("produk.name", "lelang.price", 'id_lelang')
              ->where("id_lelang", $req->id)
              ->first();

      return response()->json([
        "code" => 200,
        "message" => "Sukses",
        "data" => $data
      ]);
    }

    public function apisimpan(Request $req) {

        if ($req->price == null) {
            return response()->json(["code" => 400, "message" => "Isi harga awal terlebih dahulu, tidak dapat disimpan!"]);
        }

        if ($req->price == "") {
            return response()->json(["code" => 400, "message" => "Isi harga awal terlebih dahulu, tidak dapat disimpan!"]);
        }

        DB::beginTransaction();
        try {

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp ','',$price);

          DB::table("lelang")
              ->insert([
              "id_produk" => $req->id_produk,
              "id_account" => $req->id_account,
              "price" => $price,
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

    public function apiupdate(Request $req) {

        if ($req->price == null) {
            return response()->json(["code" => 400, "message" => "Isi harga awal terlebih dahulu, tidak dapat disimpan!"]);
        }

        if ($req->price == "") {
            return response()->json(["code" => 400, "message" => "Isi harga awal terlebih dahulu, tidak dapat disimpan!"]);
        }

        DB::beginTransaction();
        try {

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp ','',$price);

          DB::table("lelang")
              ->where("id_lelang", $req->id)
              ->update([
              "price" => $price,
              "updated_at" => Carbon::now('Asia/Jakarta'),
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

    public function apipemenang(Request $req) {
      $data = DB::table("lelangbid")
              ->leftjoin('account', 'account.id_account', '=', 'lelangbid.id_account')
              ->where("id_lelang", $req->id)
              ->where("status", "Y")
              ->first();

      return response()->json([
        "code" => 200,
        "message" => "Sukses",
        "data" => $data
      ]);
    }

    public function apiwon(Request $req) {
      DB::beginTransaction();
      try {

        $getlelang = DB::table("lelangbid")
                      ->where("id_lelangbid", $req->id)
                      ->first();

        DB::table("lelangbid")
          ->where("id_lelang", $getlelang->id_lelang)
          ->update([
            'status' => 'N',
          ]);

        DB::table("lelangbid")
            ->where("id_lelangbid", $req->id)
            ->update([
              'status' => "Y"
            ]);

        DB::table("lelang")
            ->where("id_lelang", $getlelang->id_lelang)
            ->update([
              'iswon' => "Y",
            ]);

        DB::commit();
        return response()->json([
          "code" => 200,
          "message" => "Sukses",
          "data" => $data
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "code" => 400,
          "message" => $e,
        ]);
      }

    }

}
