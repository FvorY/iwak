<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomepageController@index');
Route::get('/getinfo', 'HomepageController@getinfo');
// Route::get('/admin', 'HomeController@checklogin');
Route::get('/product', 'ProductController@index');
Route::get('/lelang', 'LelangController@index');
Route::get('/contact', 'KontakController@index');
Route::get('loginmember', 'MemberController@login')->name('loginmember');
Route::get('/logoutmember', 'MemberController@logout');

Route::post('/admin/toko/simpan', 'TokoController@simpan');

//Route untuk umum
Route::group(['middleware' => 'guest'], function () {

    Route::get('/admin', function () {
        return view('auth.login');
    })->name('adminlogin');

    Route::get('loginadmin', 'loginController@authenticate')->name('loginadmin');

});

//Route untuk user admin
Route::group(['middleware' => 'admin'], function () {

    //Admin Module
    Route::prefix('admin')->group(function () {

        Route::get('/home', 'HomeController@index')->name('homeadmin');

        Route::get('/logout', 'HomeController@logout')->name('logoutadmin');

        //User
        Route::get('/user', 'UserController@index');
        Route::get('/user/table', 'UserController@datatable');
        Route::post('/user/simpan', 'UserController@simpan');
        Route::get('/user/edit', 'UserController@edit');
        Route::get('/user/hapus', 'UserController@hapus');

        //Toko
        Route::get('/toko', 'TokoController@index');
        Route::get('/toko/table', 'TokoController@datatable');

        Route::get('/toko/edit', 'TokoController@edit');
        Route::get('/toko/aktif', 'TokoController@aktif');
        Route::get('/toko/nonaktif', 'TokoController@nonaktif');
        Route::get('/toko/autocompleteuser', 'TokoController@autocomplete');

        //Feedback
        Route::get('/feed', 'FeedController@index');
        Route::get('/feed/table', 'FeedController@datatable');
        Route::get('/feed/hapus', 'FeedController@hapus');

        //Category
        Route::get('/category', 'CategoryController@index');
        Route::get('/category/simpan', 'CategoryController@dosavecategory');
        Route::get('/category/edit', 'CategoryController@doeditcategory');
        Route::get('/category/update', 'CategoryController@doupdatecategory');
        Route::get('/category/hapus', 'CategoryController@dodeletecategory');

        //Setting backgroundheader
        Route::get('/setting/backgroundheader', 'BackgroundheaderController@index');
        Route::post('/setting/backgroundheader/save', 'BackgroundheaderController@save');

        //Setting edit info
        Route::get('/setting/editinfo', 'EditinfoController@index');
        Route::get('/setting/editinfo/save', 'EditinfoController@save');

        //Social
        Route::get('/setting/social', 'SocialController@index');
        Route::get('/setting/social/simpan', 'SocialController@dosavecategory');
        Route::get('/setting/social/edit', 'SocialController@doeditcategory');
        Route::get('/setting/social/update', 'SocialController@doupdatecategory');
        Route::get('/setting/social/hapus', 'SocialController@dodeletecategory');
    });

});

//Route untuk user pembeli / penjual
Route::group(['middleware' => 'penjual'], function () {



});
