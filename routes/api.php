<?php

use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\StokController;
use App\Http\Controllers\API\LoginController;
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

Route::post('login', [LoginController::class, 'login']);


Route::get('/barang/search/{barang}', [BarangController::class, 'search']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('barang', BarangController::class)->except("create", "edit");
    Route::resource('stok', StokController::class)->except("create", "edit"); 
    Route::post('logout', [LoginController::class, 'logout']);
});

Route::get('login', function () {
    return response()->json(['error' => 'Unauthenticted'], 401);
})->name('login');

Route::fallback(function(){
    return response()->json(['status' => 404, 'message' => 'Not Found.']);
})->name('api.fallback.404');