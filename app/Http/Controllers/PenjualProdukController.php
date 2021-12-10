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

class PenjualProdukController extends Controller
{
    public function index() {
      return view('penjualproduk.index');
    }

    public function datatable() {
      $data = DB::table('produk')
        ->leftjoin('category', 'produk.id_category', '=', 'category.id_category')
        ->leftjoin('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
        ->select('imageproduk.image', 'produk.id_produk', 'produk.star', 'produk.price', 'produk.description', 'produk.sold', 'category.category_name', 'produk.stock', 'produk.name')
        ->where("id_account", Auth::user()->id_account)
        ->groupby("produk.id_produk")
        ->get();

        return Datatables::of($data)
          ->addColumn("image", function($data) {
            return '<div> <img src="'.url('/').'/'.$data->image.'" style="height: 100px; width:100px; border-radius: 0px;" class="img-responsive"> </img> </div>';
          })
          ->addColumn("price", function($data) {
            return FormatRupiahFront($data->price);
          })
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
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id_produk.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->id_produk.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi', 'star', 'image', 'price'])
          ->addIndexColumn()
          ->make(true);
    }

    public function tambah() {

      $category = DB::table("category")->get();

      return view('penjualproduk.tambah', compact('category'));
    }

    public function simpan(Request $req) {
      if ($req->id == null) {
        DB::beginTransaction();
        try {

          $max = DB::table("produk")->max('id_produk') + 1;

          $cek = DB::table("produk")->where("url_segment", strtolower(str_replace(" ", "-", $req->name)))->first();

          $urlsegment = strtolower(str_replace(" ", "-", $req->name));
          if ($cek != null) {
              $urlsegment = strtolower(str_replace(" ", "-", $req->name)) . "-" . unique_id(3);
          }

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp','',$price);

          DB::table("produk")
              ->insert([
              "id_produk" => $max,
              "id_account" => Auth::user()->id_account,
              "name" => $req->name,
              "id_category" => $req->category,
              "price" => $price,
              "stock" => $req->stock,
              "diskon" => is_null($req->diskon) ? 0 : $req->diskon,
              "isdiskon" => $req->isdiskon,
              "description" => $req->description,
              "url_segment" => $urlsegment,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          $file = $req->file('file');
          if (isset($file)) {
          foreach ($file as $key => $value) {

            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/Product/' . $max . '/' . ($key + 1) ;
            $childPath = $dir . '/';
            $path = $childPath;

            $name = null;
            if ($value != null) {
                $this->deleteDir($dir);
                $name = $folder . '.' . $value->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        $value->move($path, $name);
                        $imgPath = $childPath . $name;
                        if ($value->getClientOriginalExtension() == 'image/webp') {

                        } else if ($value->getClientOriginalExtension() == 'webp') {

                        } else {
                          compressImage($value->getClientOriginalExtension(),$imgPath,$imgPath,75);
                        }

                        DB::table("imageproduk")
                            ->insert([
                              'id_produk' => $max,
                              'id_image' => ($key + 1),
                              'image' => $imgPath,
                        ]);

                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }
          }
          }



          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2]);
        }
      } else {
        DB::beginTransaction();
        try {

          $max = DB::table('imageproduk')->where("id_produk", $req->id)->max('id_image');

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp','',$price);

          DB::table("produk")
              ->where("id_produk", $req->id)
              ->update([
                "id_account" => Auth::user()->id_account,
                "name" => $req->name,
                "id_category" => $req->category,
                "price" => $price,
                "stock" => $req->stock,
                "diskon" => $req->diskon,
                "isdiskon" => $req->isdiskon,
                "description" => $req->description,
            ]);

          $file = $req->file('file');

          if (isset($file)) {

            foreach ($file as $key => $value) {

              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;
              $dir = 'image/uploads/Product/' . $req->id . '/' . ($max + ($key + 1))  ;
              $childPath = $dir . '/';
              $path = $childPath;

              $name = null;
              if ($value != null) {
                  // $this->deleteDir($dir);
                  $name = $folder . '.' . $value->getClientOriginalExtension();
                  if (!File::exists($path)) {
                      if (File::makeDirectory($path, 0777, true)) {
                        $value->move($path, $name);
                        $imgPath = $childPath . $name;
                        if ($value->getClientOriginalExtension() == 'image/webp') {

                        } else if ($value->getClientOriginalExtension() == 'webp') {

                        } else {
                          compressImage($value->getClientOriginalExtension(),$imgPath,$imgPath,75);
                        }

                          DB::table("imageproduk")
                              ->insert([
                                'id_produk' => $req->id,
                                'id_image' => ($max + ($key + 1)),
                                'image' => $imgPath,
                          ]);

                      } else
                          $imgPath = null;
                  } else {
                      return 'already exist';
                  }
              }

            }
          }

          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 4]);
        }
      }

    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("produk")
            ->where("id_produk", $req->id)
            ->delete();

        DB::table("imageproduk")
          ->where("id_produk", $req->id)
          ->delete();

        $dir = 'image/uploads/Product/' . $req->id;
        $childPath = $dir . '/';

        $this->deleteDir($dir);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit($id) {
      $category = DB::table("category")->get();

      return view('penjualproduk.edit', compact('id', 'category'));
    }

    public function doedit(Request $req) {
      $id = $req->id;

      $dataproduct = DB::table("produk")->where("id_produk", $id)->first();

      $dataimage = DB::table("imageproduk")->join('produk', 'produk.id_produk', '=', 'imageproduk.id_produk')->where("produk.id_produk", $id)->get();

      return response()->json([
        'product' => $dataproduct,
        'image' => $dataimage
      ]);
    }

    public function removeimage(Request $req) {
      DB::table("imageproduk")->where("id_image", $req->id_image)->where('id_produk', $req->id_produk)->delete();

      $dir = 'image/uploads/Product/' . $req->id_produk . '/' . $req->id_image;
      $childPath = $dir . '/';

      $this->deleteDir($dir);
    }

    public function apiproduk(Request $req) {
        $data = DB::table('produk')
          ->leftjoin('category', 'produk.id_category', '=', 'category.id_category')
          ->leftjoin('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
          ->select('imageproduk.image', 'produk.id_produk', 'produk.star', 'produk.price', 'produk.description', 'produk.sold', 'category.category_name', 'produk.stock', 'produk.name')
          ->where("produk.id_account", $req->id_account)
          ->groupby("produk.id_produk")
          ->get();


        return response()->json([
          "code" => 200,
          "message" => "Sukses",
          "data" => $data
        ]);
    }

    public function apisimpan(Request $req) {
      if ($req->id == null) {
        DB::beginTransaction();
        try {

          $max = DB::table("produk")->max('id_produk') + 1;

          $cek = DB::table("produk")->where("url_segment", strtolower(str_replace(" ", "-", $req->name)))->first();

          $urlsegment = strtolower(str_replace(" ", "-", $req->name));
          if ($cek != null) {
              $urlsegment = strtolower(str_replace(" ", "-", $req->name)) . "-" . unique_id(3);
          }

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp','',$price);

          DB::table("produk")
              ->insert([
              "id_produk" => $max,
              "id_account" => $req->id_account,
              "name" => $req->name,
              "id_category" => $req->category,
              "price" => $price,
              "stock" => $req->stock,
              "diskon" => is_null($req->diskon) ? 0 : $req->diskon,
              "isdiskon" => $req->isdiskon,
              "description" => $req->description,
              "url_segment" => $urlsegment,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          $file = $req->file('file');
          if (isset($file)) {
          foreach ($file as $key => $value) {

            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/Product/' . $max . '/' . ($key + 1) ;
            $childPath = $dir . '/';
            $path = $childPath;

            $name = null;
            if ($value != null) {
                $this->deleteDir($dir);
                $name = $folder . '.' . $value->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        $value->move($path, $name);
                        $imgPath = $childPath . $name;
                        if ($value->getClientOriginalExtension() == 'image/webp') {

                        } else if ($value->getClientOriginalExtension() == 'webp') {

                        } else {
                          compressImage($value->getClientOriginalExtension(),$imgPath,$imgPath,75);
                        }

                        DB::table("imageproduk")
                            ->insert([
                              'id_produk' => $max,
                              'id_image' => ($key + 1),
                              'image' => $imgPath,
                        ]);

                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }
          }
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
            "message" => $e,
          ]);
        }
      } else {
        DB::beginTransaction();
        try {

          $max = DB::table('imageproduk')->where("id_produk", $req->id)->max('id_image');

          $price = str_replace('.','',$req->price);
          $price = str_replace('Rp','',$price);

          DB::table("produk")
              ->where("id_produk", $req->id)
              ->update([
                "id_account" => $req->id_account,
                "name" => $req->name,
                "id_category" => $req->category,
                "price" => $price,
                "stock" => $req->stock,
                "diskon" => $req->diskon,
                "isdiskon" => $req->isdiskon,
                "description" => $req->description,
            ]);

          $file = $req->file('file');

          if (isset($file)) {

            foreach ($file as $key => $value) {

              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;
              $dir = 'image/uploads/Product/' . $req->id . '/' . ($max + ($key + 1))  ;
              $childPath = $dir . '/';
              $path = $childPath;

              $name = null;
              if ($value != null) {
                  // $this->deleteDir($dir);
                  $name = $folder . '.' . $value->getClientOriginalExtension();
                  if (!File::exists($path)) {
                      if (File::makeDirectory($path, 0777, true)) {
                        $value->move($path, $name);
                        $imgPath = $childPath . $name;
                        if ($value->getClientOriginalExtension() == 'image/webp') {

                        } else if ($value->getClientOriginalExtension() == 'webp') {

                        } else {
                          compressImage($value->getClientOriginalExtension(),$imgPath,$imgPath,75);
                        }

                          DB::table("imageproduk")
                              ->insert([
                                'id_produk' => $req->id,
                                'id_image' => ($max + ($key + 1)),
                                'image' => $imgPath,
                          ]);

                      } else
                          $imgPath = null;
                  } else {
                      return 'already exist';
                  }
              }

            }
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
            "message" => $e,
          ]);
        }
      }

    }

    public function apiget(Request $req) {
      $id = $req->id;

      $dataproduct = DB::table("produk")->where("id_produk", $id)->first();

      $dataimage = DB::table("imageproduk")->join('produk', 'produk.id_produk', '=', 'imageproduk.id_produk')->where("produk.id_produk", $id)->get();

      return response()->json([
        "code" => 200,
        'product' => $dataproduct,
        'image' => $dataimage
      ]);
    }

    public function apiremoveimage(Request $req) {
      DB::table("imageproduk")->where("id_image", $req->id_image)->where('id_produk', $req->id_produk)->delete();

      $dir = 'image/uploads/Product/' . $req->id_produk . '/' . $req->id_image;
      $childPath = $dir . '/';

      $this->deleteDir($dir);

      return response()->json([
        "code" => 200,
        "message" => "Sukses"
      ]);
    }

    public function apihapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("produk")
            ->where("id_produk", $req->id)
            ->delete();

        DB::table("imageproduk")
          ->where("id_produk", $req->id)
          ->delete();

        $dir = 'image/uploads/Product/' . $req->id;
        $childPath = $dir . '/';

        $this->deleteDir($dir);

        DB::commit();
        return response()->json([
          "code" => 200,
          "message" => "Sukses"
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          "code" => 400,
          "message" => $e
        ]);
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
