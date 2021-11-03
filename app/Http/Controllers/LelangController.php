<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;

use DB;

use Auth;

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
                            ->where("lelang.iswon", 'N')
                            ->where("account.istoko", 'Y')
                            ->where("produk.stock", '>' , 0)
                            ->where("produk.id_category", $category)
                            ->where("account.id_account", '!=', Auth::user()->id_account)
                            ->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('namatoko', 'like', '%' . $keyword . '%')
                            ->orWhere('address', 'like', '%' . $keyword . '%')
                            ->groupby("imageproduk.id_produk")
                            ->orderby('produk.'.$sortfield, $sort)
                            ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko')
                            ->paginate(10);
              } else {
                $data = DB::table("lelang")
                            ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                            ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                            ->join("account", 'lelang.id_account', 'account.id_account')
                            ->where("lelang.isactive", 'Y')
                            ->where("lelang.iswon", 'N')
                            ->where("account.istoko", 'Y')
                            ->where("produk.stock", '>' , 0)
                            ->where("produk.id_category", $category)
                            ->where("account.id_account", '!=', Auth::user()->id_account)
                            ->groupby("imageproduk.id_produk")
                            ->orderby('produk.'.$sortfield, $sort)
                            ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko')
                            ->paginate(10);
              }
          } else {
                if ($keyword != "") {
                  $data = DB::table("lelang")
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                              ->join("account", 'lelang.id_account', 'account.id_account')
                              ->where("lelang.isactive", 'Y')
                              ->where("lelang.iswon", 'N')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where('name', 'like', '%' . $keyword . '%')
                              ->where("account.id_account", '!=', Auth::user()->id_account)
                              ->orWhere('namatoko', 'like', '%' . $keyword . '%')
                              ->orWhere('address', 'like', '%' . $keyword . '%')
                              ->groupby("imageproduk.id_produk")
                              ->orderby('produk.'.$sortfield, $sort)
                              ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko')
                              ->paginate(10);
                } else {
                  $data = DB::table("lelang")
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                              ->join("account", 'lelang.id_account', 'account.id_account')
                              ->where("lelang.isactive", 'Y')
                              ->where("lelang.iswon", 'N')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where("account.id_account", '!=', Auth::user()->id_account)
                              ->groupby("imageproduk.id_produk")
                              ->orderby('produk.'.$sortfield, $sort)
                              ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko')
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
                            ->where("lelang.iswon", 'N')
                            ->where("account.istoko", 'Y')
                            ->where("produk.stock", '>' , 0)
                            ->where("produk.id_category", $category)
                            ->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('namatoko', 'like', '%' . $keyword . '%')
                            ->orWhere('address', 'like', '%' . $keyword . '%')
                            ->groupby("imageproduk.id_produk")
                            ->orderby('produk.'.$sortfield, $sort)
                            ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko')
                            ->paginate(10);
              } else {
                $data = DB::table("lelang")
                            ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                            ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                            ->join("account", 'lelang.id_account', 'account.id_account')
                            ->where("lelang.isactive", 'Y')
                            ->where("lelang.iswon", 'N')
                            ->where("account.istoko", 'Y')
                            ->where("produk.stock", '>' , 0)
                            ->where("produk.id_category", $category)
                            ->groupby("imageproduk.id_produk")
                            ->orderby('produk.'.$sortfield, $sort)
                            ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko')
                            ->paginate(10);
              }
          } else {
                if ($keyword != "") {
                  $data = DB::table("lelang")
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                              ->join("account", 'lelang.id_account', 'account.id_account')
                              ->where("lelang.isactive", 'Y')
                              ->where("lelang.iswon", 'N')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where('name', 'like', '%' . $keyword . '%')
                              ->orWhere('namatoko', 'like', '%' . $keyword . '%')
                              ->orWhere('address', 'like', '%' . $keyword . '%')
                              ->groupby("imageproduk.id_produk")
                              ->orderby('produk.'.$sortfield, $sort)
                              ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko')
                              ->paginate(10);
                } else {
                  $data = DB::table("lelang")
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                              ->join("account", 'lelang.id_account', 'account.id_account')
                              ->where("lelang.isactive", 'Y')
                              ->where("lelang.iswon", 'N')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->groupby("imageproduk.id_produk")
                              ->orderby('produk.'.$sortfield, $sort)
                              ->select('produk.name', 'imageproduk.image', 'lelang.price', 'lelang.isactive', 'lelang.id_lelang', 'lelang.iswon', 'produk.star', 'account.address', 'account.namatoko')
                              ->paginate(10);
                }
          }
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
                        ->get();
        // dd($get_id_produk[0]);
        $data = DB::table("lelang")
                ->join("produk", 'lelang.id_produk', 'produk.id_produk')
                ->join("account", 'lelang.id_account', 'account.id_account')
                ->where("lelang.id_produk", $get_id_produk[0]->id_produk)
                ->select('produk.*','lelang.*','account.id_account','account.fullname','account.email','account.namatoko','account.profile_toko')
                ->get();
        // dd($data);

        $get_id_related = DB::table("produk")
                  // ->join("account", 'produk.id_account', 'account.id_account')
                  ->where("produk.id_produk", $get_id_produk[0]->id_produk)
                  ->select("produk.id_category")
                  ->get();
                  

        $related = DB::table("produk")
                            ->join('imageproduk', 'imageproduk.id_produk', 'produk.id_produk')
                            ->join("account", 'produk.id_account', 'account.id_account')
                            ->where("produk.id_category", $get_id_related[0]->id_category)
                            // ->select("produk.id_category","produk.name")
                            ->get();  
        
        $image = DB::table("imageproduk")
                ->join('produk', 'produk.id_produk', '=', 'imageproduk.id_produk')
                // ->join("account", 'produk.id_account', 'account.id_account')
                ->where("produk.id_produk", $get_id_produk[0]->id_produk)
                ->get();

        $feedback =  DB::table("transaction_detail")
                    ->join('feedback', 'feedback.id_transaction','transaction_detail.id_transaction')
                    ->join("account", 'account.id_account', 'feedback.id_user')
                    ->where("transaction_detail.id_produk", $get_id_produk[0]->id_produk)
                    ->groupBy('feedback.id_feedback')
                    ->select('transaction_detail.id_produk','transaction_detail.price','feedback.id_feedback','feedback.id_user','feedback.id_toko','feedback.star','feedback.image','feedback.feedback','feedback.created_at','account.id_account','account.fullname','account.email')
                    // ->having('feedback.created_at')
                    ->get();
    
        // dd(count($feedback));
        // dd($feedback);
        // dd($get_id_related[0]->id_category);

        return view('lelang/detail', compact('data', 'image','related','feedback'));
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
}
