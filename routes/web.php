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

    Route::get('admin', function () {
        return view('auth.login');
    })->name('admin');

    Route::get('loginadmin', 'loginController@authenticate')->name('loginadmin');

});

//Route untuk user admin
Route::group(['middleware' => 'admin'], function () {

    Route::get('/', 'HomeController@index');

    Route::get('admin/home', 'HomeController@index')->name('homeadmin');

    Route::get('admin/logout', 'HomeController@logout')->name('logoutadmin');

    //User
    Route::get('admin/user', 'UserController@index');
    Route::get('admin/user/table', 'UserController@datatable');
    Route::post('admin/user/simpan', 'UserController@simpan');
    Route::get('admin/user/edit', 'UserController@edit');
    Route::get('admin/user/hapus', 'UserController@hapus');


});

//Route untuk user pembeli / penjual
Route::group(['middleware' => 'member'], function () {



});
