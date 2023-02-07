<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::group([
    
    'prefix' => 'auth',
    'middleware' => ['auth:api']
    
], function ($router) {
    
    Route::get('logout', [AuthController::class, 'logout']);

    Route::group([
        'prefix' => 'stores'
    ], function () {
        Route::get('/', [StoreController::class, 'index']);
        Route::get('/{id}', [StoreController::class, 'show']);
        Route::post('/store', [StoreController::class, 'store']);
        Route::put('/update/{id}', [StoreController::class, 'update']);
        Route::delete('delete/{id}', [StoreController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'products'
    ], function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::post('/store', [ProductController::class, 'store']);
        Route::put('/update/{id}', [ProductController::class, 'update']);
        Route::delete('delete/{id}', [ProductController::class, 'destroy']);
    });

});