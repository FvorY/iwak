<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {

    Route::any('/login', 'MemberController@apilogin');
    Route::any('/register', 'MemberController@apiregister');
    Route::any('/logout', 'MemberController@apilogout');
    Route::any('/profile', 'MemberController@apiprofile');
    Route::any('/editprofile', 'MemberController@apiedit');
    Route::any('/getinfo', 'HomepageController@getinfo');

    Route::any('/pembeli/product', 'ProductController@apiproduk');
    Route::any('/pembeli/product/detail/{url_segment}', 'ProductController@apishow');
    Route::any('/pembeli/lelang', 'LelangController@apilelang');
    Route::any('/pembeli/lelang/detail/{url_segment}', 'LelangController@apishow');

    Route::any('/pembeli/history', 'HistoryController@apihistory');
    Route::post('/pembeli/pay', 'HistoryController@apipay');

    Route::any('/pembeli/lelangupdate', 'LelangController@apilelangupdate');
    Route::any('/pembeli/countcart', 'CartController@apicountcart');
    Route::any('/pembeli/addcart', 'CartController@apiaddcart');
    Route::any('/pembeli/opencart', 'CartController@apiopencart');
    Route::any('/pembeli/deletecart', 'CartController@deletecart');
    Route::post('/pembeli/bukatoko', 'TokoController@simpan');

    Route::get('/pembeli/viewcart', 'CartController@viewcart');
    Route::get('/pembeli/addcart', 'CartController@addcart');
    Route::get('/pembeli/changetoko', 'CartController@changetoko');
    Route::post('/pembeli/checkout', 'CartController@checkout');

    Route::get('/chat', 'ChatController@index');
    Route::get('/listroom', 'ChatController@listroom');
    Route::get('/countchat', 'ChatController@countchat');
    Route::get('/listchat', 'ChatController@listchat');
    Route::get('/sendchat', 'ChatController@sendchat');
    Route::get('/newchat', 'ChatController@newchat');
    Route::post('/sendimgchat', 'ChatController@sendimgchat');

    Route::post('pembeli/inputulasan', 'HistoryController@inputulasan');

    Route::get('/toko/{id}', 'ProfileTokoController@index')->name('profilToko');

    Route::get('/updateprice', 'LelangController@updateprice');

    Route::get('/addbid', 'LelangController@addbid');

    Route::post('/checkoutlelang', 'LelangController@checkoutlelang');

    //Penjual
    Route::any('/penjual/laporan', 'PenjualHomeController@apilaporan');

    //Penjual Toko
    Route::any('/penjual/toko', 'EdittokoController@apitoko');
    Route::any('/penjual/toko/simpan', 'EdittokoController@apisimpan');

    //List Feedback / Review
    Route::any('/penjual/feed', 'FeedController@apifeed');

    //Manage Produk
    Route::any('/penjual/produk', 'PenjualProdukController@apiproduk');
    Route::any('/penjual/produk/simpan', 'PenjualProdukController@apisimpan');
    Route::any('/penjual/produk/view', 'PenjualProdukController@apiget');
    Route::any('/penjual/produk/removeimage', 'PenjualProdukController@apiremoveimage');
    Route::any('/penjual/produk/hapus', 'PenjualProdukController@apihapus');

    //Manage Lelang
    Route::any('penjual/lelang', 'PenjualLelangController@apilelang');
    Route::any('penjual/lelang/listbid/{id}', 'PenjualLelangController@apilistbid');
    Route::any('penjual/lelang/hapus', 'PenjualLelangController@apihapus');
    Route::any('penjual/lelang/aktif', 'PenjualLelangController@apiaktif');
    Route::any('penjual/lelang/nonaktif', 'PenjualLelangController@apinonaktif');
    Route::any('penjual/lelang/view', 'PenjualLelangController@apiview');
    Route::any('penjual/lelang/simpan', 'PenjualLelangController@apisimpan');
    Route::any('penjual/lelang/update', 'PenjualLelangController@apiupdate');
    Route::any('penjual/lelang/pemenang', 'PenjualLelangController@apipemenang');
    Route::any('penjual/lelang/won', 'PenjualLelangController@apiwon');

    //List Pesanan
    Route::any('penjual/listorder', 'PenjualListpesananController@apilistorder');
    Route::any('penjual/listorder/cancel', 'PenjualListpesananController@apicancel');
    Route::any('penjual/listorder/hapus', 'PenjualListpesananController@apihapus');
    Route::any('penjual/listorder/detail', 'PenjualListpesananController@apidetail');
    Route::any('penjual/listorder/deliver', 'PenjualListpesananController@apideliver');
    Route::any('penjual/listorder/deliverdone', 'PenjualListpesananController@apideliverdone');
    Route::any('penjual/listorder/showpayment/{id}', 'PenjualListpesananController@apishowpayment');
    Route::any('penjual/listorder/approve', 'PenjualListpesananController@apiapprove');

});
