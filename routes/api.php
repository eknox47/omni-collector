<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

Route::apiResource('users', UserController::class);
Route::apiResource('books', BookController::class);