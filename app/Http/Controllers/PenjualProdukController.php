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
        ->where("id_account", Auth::user()->id_account)
        ->get();


        return Datatables::of($data)
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id_produk.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->id_produk.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi'])
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

          $cek = DB::table("produk")->where("urlsegment", strtolower(str_replace(" ", "-", $req->name)))->first();

          $urlsegment = $req->name;
          if ($cek != null) {
              $urlsegment = strtolower(str_replace(" ", "-", $req->name)) + "-" + unique_id(3);
          }

          DB::table("produk")
              ->insert([
              "id_produk" => $max,
              "id_account" => Auth::user()->id_account,
              "name" => $req->name,
              "id_category" => $req->category,
              "price" => $req->price,
              "stock" => $req->stock,
              "diskon" => $req->diskon,
              "isdiskon" => $req->isdiskon,
              "description" => $req->description,
              "urlsegment" => $urlsegment,
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
                        compressImage($_FILES['file']['type'],$_FILES['file']['tmp_name'],$_FILES['file']['tmp_name'],60);
                        $value->move($path, $name);
                        $imgPath = $childPath . $name;

                        DB::table("imageproduk")
                            ->insert([
                              'id_produk' => $req->id,
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

          $cek = DB::table("produk")->where("urlsegment", strtolower(str_replace(" ", "-", $req->name)))->first();

          $urlsegment = $req->name;
          if ($cek != null) {
              $urlsegment = strtolower(str_replace(" ", "-", $req->name)) + "-" + unique_id(3);
          }

          DB::table("product")
              ->where("id", $req->id)
              ->update([
                "id_account" => Auth::user()->id_account,
                "name" => $req->name,
                "id_category" => $req->category,
                "price" => $req->price,
                "stock" => $req->stock,
                "diskon" => $req->diskon,
                "isdiskon" => $req->isdiskon,
                "description" => $req->description,
                "urlsegment" => $urlsegment,
                "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          $file = $req->file('file');
          if (isset($file)) {

            foreach ($file as $key => $value) {

              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;
              $dir = 'image/uploads/Product/' . $req->id . '/' . ($key + 1)  ;
              $childPath = $dir . '/';
              $path = $childPath;

              $name = null;
              if ($value != null) {
                  // $this->deleteDir($dir);
                  $name = $folder . '.' . $value->getClientOriginalExtension();
                  if (!File::exists($path)) {
                      if (File::makeDirectory($path, 0777, true)) {
                        compressImage($_FILES['file']['type'],$_FILES['file']['tmp_name'],$_FILES['file']['tmp_name'],60);
                          $value->move($path, $name);
                          $imgPath = $childPath . $name;

                          DB::table("imageproduk")
                            ->where("id_produk", $req->id)
                            ->delete();

                          DB::table("imageproduk")
                              ->insert([
                                'id_produk' => $req->id,
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

      $dataimage = DB::table("imageproduk")->join('produk', 'produk.id_produk', '=', 'imageproduk.id_produk')->where("id_produk", $id)->get();

      return response()->json([
        'product' => $dataproduct,
        'image' => $dataimage
      ]);
    }

    public function removeimage(Request $req) {
      DB::table("productdetailimage")->where("productimage", $req->id)->delete();

      $cek = DB::table("productimage")->where("id", $req->id)->first();

      DB::table("productimage")->where("id", $req->id)->delete();

      $dir = 'image/uploads/Product/' . $cek->id;
      $childPath = $dir . '/';

      $this->deleteDir($dir);

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
