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
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', 'PostController@index');
Route::post('/posts/create', 'PostController@store');
Route::get('/posts/edit/{post:slug}', 'PostController@edit');
Route::put('/posts/update/{post:slug}', 'PostController@update');
Route::delete('/posts/{post:slug}', 'PostController@delete');
