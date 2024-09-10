<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ProductController;

//route from auth.php
require __DIR__.'/auth.php';

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);
});
