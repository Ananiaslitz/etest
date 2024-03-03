<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [\Core\Infrastructure\Http\Controllers\DocumentationController::class, 'html']);
Route::get('/docs', [\Core\Infrastructure\Http\Controllers\DocumentationController::class, 'html']);
Route::get('/docs.json', [\Core\Infrastructure\Http\Controllers\DocumentationController::class, 'index']);
