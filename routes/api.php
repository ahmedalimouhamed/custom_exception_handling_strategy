<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);
Route::apiResource('admins', AdminController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('fournisseurs', FournisseurController::class);
Route::apiResource('clients', ClientController::class);
Route::apiResource('orders', OrderController::class);

