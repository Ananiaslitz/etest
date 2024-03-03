<?php

use Core\Infrastructure\Http\Controllers\ProductsController;
use Core\Infrastructure\Http\Controllers\SalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/products')->middleware('api')->name('products.')->group(function() {
    Route::get('', [ProductsController::class, 'getAll'])->name('all');
    Route::post('', [ProductsController::class, 'store'])->name('store');
});

Route::prefix('/sales')->middleware('api')->name('sales.')->group(function () {
    Route::post('', [SalesController::class, 'store'])->name('store');
    Route::get('/{id}', [SalesController::class, 'show'])->name('show');
    Route::get('', [SalesController::class, 'index'])->name('all');
    Route::patch('/{id}/cancel', [SalesController::class, 'cancel']);
    Route::patch('/{id}/complete', [SalesController::class, 'complete']);
    Route::patch('/{id}/add-product', [SalesController::class, 'addProduct']);
});
