<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::GET('login', 'App\Http\Controllers\UserController@login');
Route::POST('register', 'App\Http\Controllers\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'App\Http\Controllers\UserController@details');


});