<?php

use App\Http\Controllers\Api\V1\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::get("/products", [ProductController::class, "index"]);
Route::get("/products/{product}", [ProductController::class, "show"]);
Route::post("/products", [ProductController::class, "store"]);
Route::patch("/products/{product}", [ProductController::class, "update"]);
Route::delete("/products/{product}", [ProductController::class, "delete"]);