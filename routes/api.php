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

});
