<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

route::middleware('auth:sanctum')->group(function () {

    Route::get('/authenticated', function () {
        return true;
    })->name('authenticated');

    Route::apiResource('articles', ArticleController::class);
});
