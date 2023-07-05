<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Models\Product;
use App\Models\Category;
use Darryldecode\Cart\Facades\Cart;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// CRUD для продукта
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

// Добавление/удаление продукта в корзину
Route::post('/products/{product}/add-to-cart', [ProductController::class, 'addToCart'])->middleware('auth:api');
Route::post('/products/{product}/remove-from-cart', [ProductController::class, 'removeFromCart'])->middleware('auth:api');

// Фильтрация продуктов
Route::post('/products/filter', [ProductController::class, 'filter']);

// Создание категории
Route::post('/categories', [CategoryController::class, 'store']);
