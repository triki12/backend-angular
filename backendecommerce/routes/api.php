<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Product routes
Route::delete('delete/{id}',[ProductController::class,"delete"]);
Route::put('update/{id}',[ProductController::class,"update"]);

Route::get('show',[ProductController::class,"show"]);
Route::get('products',[ProductController::class,"getProduct"]);
Route::get('product/{id}',[ProductController::class,"getproductbyid"]);

Route::post('add',[ProductController::class,"file"]);

//user routes

Route::post('register','UserController@register');
Route::any('login','UserController@login');





