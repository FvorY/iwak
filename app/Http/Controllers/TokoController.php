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

class TokoController extends Controller
{
    public function index() {
      return view('toko.index');
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
      $data = DB::table('account')
        ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          ->addColumn("image", function($data) {
            return '<div> <img src="'.url('/').'/'.$data->profile_toko.'" style="height: 100px; width:100px; border-radius: 0px;" class="img-responsive"> </img> </div>';
          })
          ->addColumn("status", function($data) {
              if ($data->istoko == "Y") {
                return '<span class="badge badge-success"> Aktif </span>';
              } else {
                return '<span class="badge badge-warning"> Nonaktif </span>';
              }
          })
          ->addColumn('aksi', function ($data) {
            if ($data->istoko == "Y") {
              return  '<div class="btn-group">'.
                       '<button type="button" onclick="edit('.$data->id_account.')" class="btn btn-info btn-lg" title="edit">'.
                       '<label class="fa fa-pencil-alt"></label></button>'.
                       '<button type="button" onclick="nonaktif('.$data->id_account.')" class="btn btn-danger btn-lg" title="Nonaktifan">'.
                       '<label class="fa fa-close"></label></button>'.
                    '</div>';
            } else {
              return  '<div class="btn-group">'.
                       '<button type="button" onclick="edit('.$data->id_account.')" class="btn btn-info btn-lg" title="edit">'.
                       '<label class="fa fa-pencil-alt"></label></button>'.
                       '<button type="button" onclick="aktif('.$data->id_account.')" class="btn btn-primary btn-lg" title="Aktikan">'.
                       '<label class="fa fa-check"></label></button>'.
                    '</div>';
            }
          })
          ->rawColumns(['aksi', 'status', 'image'])
          ->addIndexColumn()
          ->make(true);
    }

    public function simpan(Request $req) {

        if ($req->namatoko == null) {
            return response()->json(["status" => 7, "message" => "Isi nama toko anda terlebih dahulu, tidak dapat disimpan!"]);
        }

        if ($req->namatoko == "") {
            return response()->json(["status" => 7, "message" => "Isi nama toko anda terlebih dahulu, tidak dapat disimpan!"]);
        }

        DB::beginTransaction();
        try {
          $imgPath = null;
          $tgl = Carbon::now('Asia/Jakarta');
          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/Toko/' . $req->id;
          $childPath = $dir . '/';
          $path = $childPath;

          $file = $req->file('image');
          $name = null;
          if ($file != null) {
              $this->deleteDir($dir);
              $name = $folder . '.' . $file->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      compressImage($_FILES['image']['type'],$_FILES['image']['tmp_name'],$_FILES['image']['tmp_name'],75);
                      $file->move($path, $name);
                      $imgPath = $childPath . $name;
                  } else
                      $imgPath = null;
              } else {
                  return 'already exist';
              }
          }

          if ($imgPath == null) {
            DB::table("account")
                ->where('id_account', $req->id)
                ->update([
                "namatoko" => $req->namatoko,
                "star" => $req->star,
                "bank" => $req->bank,
                "updated_at" => Carbon::now('Asia/Jakarta'),
              ]);
          } else {
            DB::table("account")
                ->where('id_account', $req->id)
                ->update([
                "namatoko" => $req->namatoko,
                "star" => $req->star,
                "nomor_rekening" => $req->nomor_rekening,
                "bank" => $req->bank,
                "profile_toko" => $imgPath,
                "updated_at" => Carbon::now('Asia/Jakarta'),
              ]);
          }

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

        $cek = DB::table("account")
            ->where("id_account", $req->id)->first();

        if ($cek->namatoko == "") {
          return response()->json(["status" => 7, "message" => "Silahkan lengkapi nama toko terlebih dahulu!"]);
        } else if ($cek->profile_toko == "") {
          return response()->json(["status" => 7, "message" => "Silahkan lengkapi image profil toko terlebih dahulu!"]);
        } else {
          DB::table("account")
              ->where("id_account", $req->id)
              ->update([
                'istoko' => "Y"
              ]);
        }

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

        DB::table("account")
            ->where("id_account", $req->id)
            ->update([
              'istoko' => "N"
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit(Request $req) {
      $data = DB::table("account")
              ->where("id_account", $req->id)
              ->first();

      return response()->json($data);
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
