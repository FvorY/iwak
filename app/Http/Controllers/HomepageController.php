<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Account;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use Response;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $backgroundheader = DB::table("backgroundheader")->where("id", 1)->first();

        $latest = DB::table("produk")
                    ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                    ->join("account", 'produk.id_account', 'account.id_account')
                    ->latest('produk.created_at')
                    ->where("account.istoko", 'Y')
                    ->where("produk.stock", '>' , 0)
                    ->groupby("imageproduk.id_produk")
                    ->limit(20)
                    ->get();

        $bestseller = DB::table("produk")
                    ->join('imageproduk', 'imageproduk.id_produk', '=', 'produk.id_produk')
                    ->join("account", 'produk.id_account', 'account.id_account')
                    ->where("account.istoko", 'Y')
                    ->where("produk.stock", '>' , 0)
                    ->groupby("imageproduk.id_produk")
                    ->orderby('produk.sold', 'DESC')
                    ->limit(10)
                    ->get();

        $forauction = DB::table("lelang")
                    ->join('imageproduk', 'imageproduk.id_produk', '=', 'lelang.id_produk')
                    ->join("account", 'lelang.id_account', 'account.id_account')
                    ->join('produk', 'produk.id_produk', '=', 'lelang.id_produk')
                    ->latest('lelang.created_at')
                    ->where("isactive", 'Y')
                    ->where("iswon", 'N')
                    ->where("account.istoko", 'Y')
                    ->where("produk.stock", '>' , 0)
                    ->groupby("imageproduk.id_produk")
                    ->select("lelang.*", 'produk.name', 'produk.price as produkprice', 'account.*', 'imageproduk.*')
                    ->limit(20)
                    ->get();


        foreach ($forauction as $key => $value) {
            $bid = DB::table("lelangbid")
                    ->where("id_lelang", $value->id_lelang)
                    ->max('price');

            if ($bid != null) {
              $forauction[$key]->price = $bid;
            }
        }

        return view("homepage", compact('backgroundheader', 'forauction', 'latest', 'bestseller'));
    }

    public function getinfo() {
      $info = DB::table("infotoko")->get();

      $category = DB::table("category")->get();

      return response()->json([
          'info' => $info,
          'category' => $category
        ]);
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
