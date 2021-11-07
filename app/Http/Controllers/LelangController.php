<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;

use DB;

use Auth;

use Carbon\Carbon;

use File;

class LelangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
      $sort = "DESC";
      $sortfield = "name";
      $category = "all";
      $keyword = "";

      if ($req->sortfield != null) {
        $sortfield = $req->sortfield;
      }

      if ($req->sort != null) {
        $sort = $req->sort;
      }

      if ($req->category != null) {
        $category = $req->category;
      }

      if ($req->keyword != null || $req->keyword != "") {
        $keyword = $req->keyword;
      }

      if (Auth::check()) {
          if ($category != "all") {
              if ($keyword != "") {
                $data = DB::table("lelang")
                            ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                            ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                            ->join("account", 'lelang.id_account', 'account.id_account')
                            ->where("lelang.isactive", 'Y')
                            ->where("account.istoko", 'Y')
                            ->where("produk.stock", '>' , 0)
                            ->where("produk.id_category", $category)
                            ->where("account.id_account", '!=', Auth::user()->id_account)
                            ->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('namatoko', 'like', '%' . $keyword . '%')
                            ->orWhere('address', 'like', '%' . $keyword . '%')
                            ->groupby("imageproduk.id_produk")
                            ->orderby('produk.'.$sortfield, $sort)
                            ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko', 'produk.url_segment')
                            ->paginate(10);
              } else {
                $data = DB::table("lelang")
                            ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                            ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                            ->join("account", 'lelang.id_account', 'account.id_account')
                            ->where("lelang.isactive", 'Y')
                            ->where("account.istoko", 'Y')
                            ->where("produk.stock", '>' , 0)
                            ->where("produk.id_category", $category)
                            ->where("account.id_account", '!=', Auth::user()->id_account)
                            ->groupby("imageproduk.id_produk")
                            ->orderby('produk.'.$sortfield, $sort)
                            ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko', 'produk.url_segment')
                            ->paginate(10);
              }
          } else {
                if ($keyword != "") {
                  $data = DB::table("lelang")
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                              ->join("account", 'lelang.id_account', 'account.id_account')
                              ->where("lelang.isactive", 'Y')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where('name', 'like', '%' . $keyword . '%')
                              ->where("account.id_account", '!=', Auth::user()->id_account)
                              ->orWhere('namatoko', 'like', '%' . $keyword . '%')
                              ->orWhere('address', 'like', '%' . $keyword . '%')
                              ->groupby("imageproduk.id_produk")
                              ->orderby('produk.'.$sortfield, $sort)
                              ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko', 'produk.url_segment')
                              ->paginate(10);
                } else {
                  $data = DB::table("lelang")
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                              ->join("account", 'lelang.id_account', 'account.id_account')
                              ->where("lelang.isactive", 'Y')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where("account.id_account", '!=', Auth::user()->id_account)
                              ->groupby("imageproduk.id_produk")
                              ->orderby('produk.'.$sortfield, $sort)
                              ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko', 'produk.url_segment')
                              ->paginate(10);
                }
          }
        } else {
          if ($category != "all") {
              if ($keyword != "") {
                $data = DB::table("lelang")
                            ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                            ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                            ->join("account", 'lelang.id_account', 'account.id_account')
                            ->where("lelang.isactive", 'Y')
                            ->where("account.istoko", 'Y')
                            ->where("produk.stock", '>' , 0)
                            ->where("produk.id_category", $category)
                            ->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('namatoko', 'like', '%' . $keyword . '%')
                            ->orWhere('address', 'like', '%' . $keyword . '%')
                            ->groupby("imageproduk.id_produk")
                            ->orderby('produk.'.$sortfield, $sort)
                            ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko', 'produk.url_segment')
                            ->paginate(10);
              } else {
                $data = DB::table("lelang")
                            ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                            ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                            ->join("account", 'lelang.id_account', 'account.id_account')
                            ->where("lelang.isactive", 'Y')
                            ->where("account.istoko", 'Y')
                            ->where("produk.stock", '>' , 0)
                            ->where("produk.id_category", $category)
                            ->groupby("imageproduk.id_produk")
                            ->orderby('produk.'.$sortfield, $sort)
                            ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko', 'produk.url_segment')
                            ->paginate(10);
              }
          } else {
                if ($keyword != "") {
                  $data = DB::table("lelang")
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                              ->join("account", 'lelang.id_account', 'account.id_account')
                              ->where("lelang.isactive", 'Y')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where('name', 'like', '%' . $keyword . '%')
                              ->orWhere('namatoko', 'like', '%' . $keyword . '%')
                              ->orWhere('address', 'like', '%' . $keyword . '%')
                              ->groupby("imageproduk.id_produk")
                              ->orderby('produk.'.$sortfield, $sort)
                              ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko', 'produk.url_segment')
                              ->paginate(10);
                } else {
                  $data = DB::table("lelang")
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                              ->join("account", 'lelang.id_account', 'account.id_account')
                              ->where("lelang.isactive", 'Y')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->groupby("imageproduk.id_produk")
                              ->orderby('produk.'.$sortfield, $sort)
                              ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko', 'produk.url_segment')
                              ->paginate(10);
                }
          }
        }

        foreach ($data as $key => $value) {
            $value->price = DB::table("lelangbid")
                              ->where("id_lelang", $value->id_lelang)
                              ->max('price');
        }

        $categorydata = DB::table('category')
                    ->select('id_category', 'id_category as total', 'category_name')
                    ->get();

        foreach ($categorydata as $key => $value) {
          if (Auth::check()) {
            $value->total = DB::table('lelang')
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join("account", 'produk.id_account', 'account.id_account')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where("account.id_account", '!=', Auth::user()->id_account)
                              ->where("id_category", $value->id_category)
                              ->count();
          } else {
            $value->total = DB::table('lelang')
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join("account", 'produk.id_account', 'account.id_account')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where("id_category", $value->id_category)
                              ->count();
          }
        }
        // dd($data);
        return view('lelang', compact('data', 'sort', 'sortfield', 'categorydata', 'category', 'keyword'));
    }

    public function lelangupdate(Request $req) {
      $res = DB::table("lelangbid")
              ->whereIn("id_lelang", $req->arrid)
              ->get();

      return response()->json($res);
    }

    public function updateprice(Request $req) {
      $res = DB::table("lelangbid")
              ->where("id_lelang", $req->id)
              ->max('price');

      $lastbid = DB::table("lelangbid")
              ->where("id_lelang", $req->id)
              ->orderby("price", 'desc')
              ->limit(1)
              ->first();

      $pemenang = DB::table("lelangbid")
              ->where("id_lelang", $req->id)
              ->where("status", 'Y')
              ->first();

      return response()->json([
          'price' => $res,
          'lastbid' => $lastbid,
          'pemenang' => $pemenang
        ]);
    }

    public function addbid(Request $req) {

      DB::beginTransaction();
      try {

        $price = str_replace('.','',$req->price);
        $price = str_replace('Rp ','',$price);

        $lastbid = DB::table("lelangbid")
                ->where("id_lelang", $req->id)
                ->orderby("price", 'desc')
                ->limit(1)
                ->first();

        if ($price <= $lastbid->price){
            return response()->json(["status" => 7, "message" => "Silahkan bid diatas harga terakhir!"]);
        }

        DB::table("lelangbid")
            ->insert([
              'id_lelang' => $req->id,
              'id_account' => Auth::user()->id_account,
              'price' => $price,
              'created_at' => Carbon::now('Asia/Jakarta')
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($url_segment)
    {
        //

        $get_id_produk = DB::table("produk")
                        // ->join("account", 'produk.id_account', 'account.id_account')
                        ->where("produk.url_segment", $url_segment)
                        ->select('produk.id_produk')
                        ->first();
        // dd($get_id_produk[0]);
        if($get_id_produk == null){
          return view('error-404');
        }else{
        $data = DB::table("lelang")
                ->join("produk", 'lelang.id_produk', 'produk.id_produk')
                ->join("account", 'lelang.id_account', 'account.id_account')
                ->where("lelang.id_produk", $get_id_produk->id_produk)
                ->select('produk.*','lelang.*','account.id_account','account.fullname','account.email','account.namatoko','account.profile_toko', 'account.bank', 'account.nomor_rekening')
                ->get();
        // dd($data);

        // $get_id_related = DB::table("produk")
        //           // ->join("account", 'produk.id_account', 'account.id_account')
        //           ->where("produk.id_produk", $get_id_produk[0]->id_produk)
        //           ->select("produk.id_category")
        //           ->get();


        // $related = DB::table("produk")
        //                     ->join('imageproduk', 'imageproduk.id_produk', 'produk.id_produk')
        //                     ->join("account", 'produk.id_account', 'account.id_account')
        //                     ->where("produk.id_category", $get_id_related[0]->id_category)
        //                     // ->select("produk.id_category","produk.name")
        //                     ->get();

        $image = DB::table("imageproduk")
                ->join('produk', 'produk.id_produk', '=', 'imageproduk.id_produk')
                // ->join("account", 'produk.id_account', 'account.id_account')
                ->where("produk.id_produk", $get_id_produk->id_produk)
                ->get();

        $feedback =  DB::table("transaction_detail")
                    ->join('feedback', 'feedback.id_transaction','transaction_detail.id_transaction')
                    ->join("account", 'account.id_account', 'feedback.id_user')
                    ->where("transaction_detail.id_produk", $get_id_produk->id_produk)
                    ->groupBy('feedback.id_feedback')
                    ->select('transaction_detail.id_produk','transaction_detail.price','feedback.id_feedback','feedback.id_user','feedback.id_toko','feedback.star','feedback.image','feedback.feedback','feedback.created_at','account.id_account','account.fullname','account.email')
                    // ->having('feedback.created_at')
                    ->get();

        if ($data[0] != null) {
          $data[0]->price = DB::table("lelangbid")
                            ->where("id_lelang", $data[0]->id_lelang)
                            ->max('price');
        }

        return view('lelang/detail', compact('data', 'image','feedback'));

      }
        // dd(count($feedback));
        // dd($feedback);
        // dd($get_id_related[0]->id_category);

    }

    public function checkoutlelang(Request $req) {
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

              DB::table('lelang')
                  ->where('id_lelang', $req->id_lelang)
                  ->update([
                    'isactive' => 'N'
                  ]);
          }

          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 4]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
