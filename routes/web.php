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

    Route::get('/', 'HomeController@index');

    Route::get('homeadmin', 'HomeController@index')->name('homeadmin');

    Route::get('logoutadmin', 'HomeController@logout')->name('logoutadmin');

});

//Route untuk user pembeli / penjual
Route::group(['middleware' => 'member'], function () {



});
