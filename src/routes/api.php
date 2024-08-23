<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [APIController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{code}', [ProductController::class, 'get']);
Route::delete('/products/{code}', [ProductController::class, 'delete']);
Route::put('/products/{code}', [ProductController::class, 'update']);