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

class ChatController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
      return view('chat');
    }

    public function newchat(Request $req) {
      DB::beginTransaction();
      try {

          $cek = DB::table("roomchat")
                  ->Orwhere("account", Auth::user()->id_account . "-" . $req->idtoko)
                  ->Orwhere('account', $req->idtoko . "-" . Auth::user()->id_account)
                  ->first();

          if ($cek != null) {
            DB::table("listchat")
               ->insert([
                 'id_roomchat' => $cek->id_roomchat,
                 'account' => Auth::user()->id_account . "-" . $req->idtoko,
                 'message' => $req->message,
                 'created_at' => Carbon::now('Asia/Jakarta'),
               ]);
          } else {
              $id = DB::table('roomchat')
                    ->insertGetId([
                      'account' => Auth::user()->id_account . "-" . $req->idtoko,
                      'last_message' => $req->message,
                      'counter' => 1,
                      'created_at' => Carbon::now('Asia/Jakarta'),
                    ]);

              DB::table("listchat")
                 ->insert([
                   'id_roomchat' => $id,
                   'account' => Auth::user()->id_account . "-" . $req->idtoko,
                   'message' => $req->message,
                   'created_at' => Carbon::now('Asia/Jakarta'),
                 ]);
          }
           DB::commit();
      } catch (\Exception $e) {
           DB::rollback();
      }
    }

    public function apinewchat(Request $req) {
      DB::beginTransaction();
      try {

          $cek = DB::table("roomchat")
                  ->Orwhere("account", $req->id_account . "-" . $req->idtoko)
                  ->Orwhere('account', $req->idtoko . "-" . $req->id_account)
                  ->first();

          if ($cek != null) {
            DB::table("listchat")
               ->insert([
                 'id_roomchat' => $cek->id_roomchat,
                 'account' => $req->id_account . "-" . $req->idtoko,
                 'message' => $req->message,
                 'created_at' => Carbon::now('Asia/Jakarta'),
               ]);
          } else {
              $id = DB::table('roomchat')
                    ->insertGetId([
                      'account' => $req->id_account . "-" . $req->idtoko,
                      'last_message' => $req->message,
                      'counter' => 1,
                      'created_at' => Carbon::now('Asia/Jakarta'),
                    ]);

              DB::table("listchat")
                 ->insert([
                   'id_roomchat' => $id,
                   'account' => $req->id_account . "-" . $req->idtoko,
                   'message' => $req->message,
                   'created_at' => Carbon::now('Asia/Jakarta'),
                 ]);
          }
           DB::commit();
      } catch (\Exception $e) {
           DB::rollback();
      }
    }

    public function countchat() {
       $chat = DB::table('roomchat')
                ->where('account', 'like', '%' . Auth::user()->id_account . '%')
                ->sum('counter');

        return Response()->json($chat);
    }

    public function apicountchat(Request $req) {
       $chat = DB::table('roomchat')
                ->where('account', 'like', '%' . $req->id_account . '%')
                ->sum('counter');

        return Response()->json($chat);
    }

    public function listroom(Request $req) {
        $chat = DB::table('roomchat')
                 ->where('account', 'like', '%' . Auth::user()->id_account . '%')
                 ->orderby("id_roomchat", "DESC")
                 ->get();

        foreach ($chat as $key => $value) {
          $account = explode("-",$value->account);

          if ($account[0] != Auth::user()->id_account) {
            $value->account = DB::table("account")
                                ->where("id_account", $account[0])
                                ->first();
          } else if ($account[1] != Auth::user()->id_account) {
            $value->account = DB::table("account")
                                ->where("id_account", $account[1])
                                ->first();
          }

          $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
        }

         return Response()->json($chat);
    }

    public function apilistroom(Request $req) {
        $chat = DB::table('roomchat')
                 ->where('account', 'like', '%' . $req->id_account . '%')
                 ->orderby("id_roomchat", "DESC")
                 ->get();

        foreach ($chat as $key => $value) {
          $account = explode("-",$value->account);

          if ($account[0] != $req->id_account) {
            $value->account = DB::table("account")
                                ->where("id_account", $account[0])
                                ->first();
          } else if ($account[1] != $req->id_account) {
            $value->account = DB::table("account")
                                ->where("id_account", $account[1])
                                ->first();
          }

          $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
        }

         return Response()->json($chat);
    }

    public function listchat(Request $req) {
         $chat = DB::table('listchat')
                 ->where("id_roomchat", $req->id)
                 ->get();

         DB::table('listchat')
                 ->where("id_roomchat", $req->id)
                 ->update([
                   'read' => 1,
                 ]);

         DB::table('roomchat')
                  ->where("id_roomchat", $req->id)
                  ->update([
                    'counter' => 0,
                  ]);

         foreach ($chat as $key => $value) {
           $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
         }

         return Response()->json($chat);
    }

    public function sendchat(Request $req) {
      DB::beginTransaction();
      try {

          $chat = DB::table('listchat')
                  ->where("id_roomchat", $req->id)
                  ->get();

           DB::table("listchat")
              ->insert([
                'id_roomchat' => $req->id,
                'account' => Auth::user()->id_account . "-" . $req->penerima,
                'message' => $req->message,
                'created_at' => Carbon::now('Asia/Jakarta'),
              ]);

           $count = 0;
           foreach ($chat as $key => $value) {
             $account = explode("-",$value->account);

             DB::table('roomchat')
                  ->where("id_roomchat", $req->id)
                  ->update([
                    'counter' => $count,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                  ]);
           }

           DB::commit();
      } catch (\Exception $e) {
           DB::rollback();
      }
    }

    public function apisendchat(Request $req) {
      DB::beginTransaction();
      try {

          $chat = DB::table('listchat')
                  ->where("id_roomchat", $req->id)
                  ->get();

           DB::table("listchat")
              ->insert([
                'id_roomchat' => $req->id,
                'account' => $req->id_account . "-" . $req->penerima,
                'message' => $req->message,
                'created_at' => Carbon::now('Asia/Jakarta'),
              ]);

           $count = 0;
           foreach ($chat as $key => $value) {
             $account = explode("-",$value->account);

             DB::table('roomchat')
                  ->where("id_roomchat", $req->id)
                  ->update([
                    'counter' => $count,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                  ]);
           }

           DB::commit();
      } catch (\Exception $e) {
           DB::rollback();
      }
    }

    public function sendimgchat(Request $req) {

        DB::beginTransaction();
        try {
              // dd($req);
              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;
              $dir = 'image/uploads/Chat/' . $req->id;
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
                }

                  if ($imgPath != null) {
                      $chat = DB::table('listchat')
                              ->where("id_roomchat", $req->id)
                              ->get();

                       DB::table("listchat")
                          ->insert([
                            'id_roomchat' => $req->id,
                            'account' => Auth::user()->id_account . "-" . $req->penerima,
                            'photourl' => $imgPath,
                            'created_at' => Carbon::now('Asia/Jakarta'),
                          ]);

                       $count = 0;
                       foreach ($chat as $key => $value) {
                         $account = explode("-",$value->account);

                         DB::table('roomchat')
                              ->where("id_roomchat", $req->id)
                              ->update([
                                'counter' => $count,
                                'created_at' => Carbon::now('Asia/Jakarta'),
                              ]);
                       }
                  }

              DB::commit();
            } catch (\Exception $e) {
              DB::rollback();
            }

    }

    public function apisendimgchat(Request $req) {

        DB::beginTransaction();
        try {
              // dd($req);
              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;
              $dir = 'image/uploads/Chat/' . $req->id;
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
                }

                  if ($imgPath != null) {
                      $chat = DB::table('listchat')
                              ->where("id_roomchat", $req->id)
                              ->get();

                       DB::table("listchat")
                          ->insert([
                            'id_roomchat' => $req->id,
                            'account' => $req->id_account . "-" . $req->penerima,
                            'photourl' => $imgPath,
                            'created_at' => Carbon::now('Asia/Jakarta'),
                          ]);

                       $count = 0;
                       foreach ($chat as $key => $value) {
                         $account = explode("-",$value->account);

                         DB::table('roomchat')
                              ->where("id_roomchat", $req->id)
                              ->update([
                                'counter' => $count,
                                'created_at' => Carbon::now('Asia/Jakarta'),
                              ]);
                       }
                  }

              DB::commit();
            } catch (\Exception $e) {
              DB::rollback();
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
