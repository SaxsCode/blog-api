<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::post('/article/create', [ArticleController::class, "store"])->name("article.create");
