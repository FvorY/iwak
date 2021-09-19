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

// Route::get('/', 'HomefrontController@index')->name('/');


Route::group(['middleware' => 'guest'], function () {

    Route::get('/', function () {
        return view('auth.login');
    })->name('admin');

    Route::get('login', 'loginController@authenticate')->name('login');
    Route::get('register', 'RegisterController@index')->name('register');
    Route::get('doregister', 'RegisterController@doregister')->name('doregister');
    Route::get("verification/{id}", 'VerificationController@index');
    Route::get("resendverification/{id}", 'VerificationController@resend');
    Route::get("doverification", 'VerificationController@doverification');
    Route::get("forgotpassword", 'ForgotpasswordController@index');
    Route::get("doforgot", 'ForgotpasswordController@doforgot');
    Route::get("forgotlink/{id}/{accesstoken}", 'ForgotpasswordController@forgotlink');
    Route::get("doforgotlink", 'ForgotpasswordController@doforgotlink');
    Route::get("forgotlogin/{id}", 'ForgotpasswordController@forgotlogin');

    Route::get("generatetagihan", 'TagihanController@generatetagihan');

    Route::get("tesemail", 'VerificationController@tesemail');
    // Route::post('login', 'loginController@authenticate')->name('login');
});


Route::group(['middleware' => 'auth'], function () {

Route::get('/home', 'HomeController@index')->name('index');
Route::get('logout', 'HomeController@logout')->name('logout');

Route::get('mastertagihan', 'MastertagihanController@index');
Route::get('mastertagihantable', 'MastertagihanController@datatable');
Route::get('simpanmastertagihan', 'MastertagihanController@simpan');
Route::get('hapusmastertagihan', 'MastertagihanController@hapus');
Route::get('editmastertagihan', 'MastertagihanController@edit');

Route::get('tagihan', 'TagihanController@index');
Route::get('tagihantable', 'TagihanController@datatable');
Route::get('bayartagihan', 'TagihanController@bayar');

Route::get('uangmasuk', 'UangmasukController@index');
Route::get('uangmasuktable', 'UangmasukController@datatable');
Route::get('simpanuangmasuk', 'UangmasukController@simpan');
Route::get('hapusuangmasuk', 'UangmasukController@hapus');
Route::get('edituangmasuk', 'UangmasukController@edit');

Route::get('uangkeluar', 'UangkeluarController@index');
Route::get('uangkeluartable', 'UangkeluarController@datatable');
Route::get('simpanuangkeluar', 'UangkeluarController@simpan');
Route::get('hapusuangkeluar', 'UangkeluarController@hapus');
Route::get('edituangkeluar', 'UangkeluarController@edit');

// Route::get("mutasi", "MutasiController@index");

Route::get("statistik", "StatistikController@index");
Route::get("getstatistik", "StatistikController@get");

}); // End Route Groub middleware auth
