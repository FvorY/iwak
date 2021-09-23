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

//Route untuk umum
Route::group(['middleware' => 'guest'], function () {

    Route::get('/admin', function () {
        return view('auth.login');
    })->name('admin');

    Route::get('loginadmin', 'loginController@authenticate')->name('loginadmin');

});

//Route untuk user admin
Route::group(['middleware' => 'admin'], function () {

    //Admin Module
    Route::prefix('admin')->group(function () {

        Route::get('/home', 'HomeController@index')->name('homeadmin');

        Route::get('/logout', 'HomeController@logout')->name('logoutadmin');

        Route::get('/user', 'UserController@index');
        Route::get('/user/table', 'UserController@datatable');
        Route::post('/user/simpan', 'UserController@simpan');
        Route::get('/user/edit', 'UserController@edit');
        Route::get('/user/hapus', 'UserController@hapus');

        Route::get('/toko', 'TokoController@index');
        Route::get('/toko/table', 'TokoController@datatable');
        Route::post('/toko/simpan', 'TokoController@simpan');
        Route::get('/toko/edit', 'TokoController@edit');
        Route::get('/toko/aktif', 'TokoController@aktif');
        Route::get('/toko/nonaktif', 'TokoController@nonaktif');
        Route::get('/toko/autocompleteuser', 'TokoController@autocomplete');

    });

});

//Route untuk user pembeli / penjual
Route::group(['middleware' => 'member'], function () {



});
