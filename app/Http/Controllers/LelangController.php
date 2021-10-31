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

        $categorydata = DB::table('category')
                    ->select('id_category', 'id_category as total', 'category_name')
                    ->get();

        foreach ($categorydata as $key => $value) {
            $value->total = DB::table('lelang')
                              ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                              ->join("account", 'produk.id_account', 'account.id_account')
                              ->where("account.istoko", 'Y')
                              ->where("produk.stock", '>' , 0)
                              ->where("account.id_account", '!=', Auth::user()->id_account)
                              ->where("id_category", $value->id_category)
                              ->count();
        }

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
    public function show($id)
    {
        //
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
