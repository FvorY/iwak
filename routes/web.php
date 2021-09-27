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

Route::get('/admin', 'HomeController@checklogin');
Route::get('/', 'HomepageController@index');


//Route untuk umum
Route::group(['middleware' => 'guest'], function () {

    Route::get('/admin/login', function () {
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
        Route::post('/toko/simpan', 'TokoController@simpan');
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

    });

});

//Route untuk user pembeli / penjual
Route::group(['middleware' => 'member'], function () {



});
