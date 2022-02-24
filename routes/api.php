<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products;

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

Route::group([],function(){
    Route::post('create',[Products::class,'CreateProduct']);
});
Route::group([],function(){
    Route::get('Getall',[Products::class,'GetProducts']);
});
Route::group([],function(){
    Route::get('getfromapi',[Products::class,'getProductsAPI']);
});


Route::group([],function(){
    Route::post('update',[Products::class,'updateProduct']);
});
Route::group([],function(){
    Route::get('inactivateProduct',[Products::class,'inactivateProduct']);
});