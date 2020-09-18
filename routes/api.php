<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
|
|
*/

//authentication routes
Route::group([
    	'prefix'  => 'auth'
    ],
    function(){
Route::post('login', 'App\Http\Controllers\UserController@login');
Route::post('register', 'App\Http\Controllers\UserController@register');
Route::put('updateprofile/{id}', 'App\Http\Controllers\UserController@update');
Route::get('allusers', 'App\Http\Controllers\UserController@index');
Route::delete('/deleteuser/{id}','App\Http\Controllers\UserController@destroy');
Route::post('/restoreuser/{id}','App\Http\Controllers\UserController@restore');

});

Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'App\Http\Controllers\UserController@details');

    });



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




//saccos routes
Route::get('/allsaccos','App\Http\Controllers\saccosController@index' );
Route::get('/allsaccos/{sacco}','App\Http\Controllers\saccosController@show' );
Route::post('/createsacco','App\Http\Controllers\saccosController@store');
Route::put('/updatesacco/{sacco}','App\Http\Controllers\saccosController@update');
Route::delete('/deletesacco/{sacco}','App\Http\Controllers\saccosController@destroy');
Route::post('/restoresacco/{id}','App\Http\Controllers\saccosController@restore');



/*
end points 

authentication 
POST http://127.0.0.1:8000/api/auth/login
POST http://127.0.0.1:8000/api/auth/register
PUT  http://127.0.0.1:8000/api/auth/updateprofile/{id}
GET  http://127.0.0.1:8000/api/auth/allusers
DELETE http://127.0.0.1:8000/api/auth/deleteuser/{id}
POST http://127.0.0.1:8000/api/auth/restoreuser/{id} 

GET  http://127.0.0.1:8000/api/allsaccos      getallsaccos
GET  http://127.0.0.1:8000/api/allsaccos/{id}  get circle with id eg 2
POST http://127.0.0.1:8000/api/createsacco     create new cicle
PUT    http://127.0.0.1:8000/api/allsaccos/{id}     update sacco with id eg 2
DELETE http://127.0.0.1:8000/api/deletesacco/{id}  delete sacco with id eg 2
POST http://127.0.0.1:8000/api/restoresacco/{id}  restore deleted sacco with id eg 2


*/
