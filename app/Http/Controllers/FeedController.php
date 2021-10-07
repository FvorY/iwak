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
        ->leftjoin("account", "id_account", '=', 'id_user')
        ->select("feedback.star", "feedback.image", "feedback.id_feedback", "account.fullname", "feedback.feedback")
        ->orderBy("feedback.created_at", "desc")
        ->get();


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
            if ($data->fullname == null) {
              return "<span style='color: red;'> User tidak ditemukan (Dihapus dari sistem) <span>";
            } else {
              return $data->fullname;
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
          ->rawColumns(['aksi', 'image', 'username', 'star'])
          ->addIndexColumn()
          ->make(true);
    }

    public function datatablewtoko() {
      $data = DB::table('feedback')
        ->leftjoin("account", "id_account", '=', 'id_user')
        ->select("feedback.star", "feedback.image", "feedback.id_feedback", "account.fullname", "feedback.feedback")
        ->orderBy("feedback.created_at", "desc")
        ->where("id_account", Auth::user()->id_account)
        ->get();


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
            if ($data->fullname == null) {
              return "<span style='color: red;'> User tidak ditemukan (Dihapus dari sistem) <span>";
            } else {
              return $data->fullname;
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
