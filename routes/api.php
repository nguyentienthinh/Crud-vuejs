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

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

// User
Route::post('/user/login', 'UserController@login');
Route::post('/user/register', 'UserController@register');

// Post
Route::get('/posts', 'PostController@index');
// Route::delete('/posts/{slug}', 'PostController@delete');

Route::middleware('auth:api')->group(
    function () {
        // User
        Route::get('/user/info', 'UserController@getInfo');
        Route::post('/user/logout', 'UserController@logout');

        // Post
        Route::post('/posts/create', 'PostController@store');
        Route::get('/posts/edit/{slug}', 'PostController@edit');
        Route::put('/posts/update/{slug}', 'PostController@update');
        Route::delete('/posts/{slug}', 'PostController@delete');
    }
);
