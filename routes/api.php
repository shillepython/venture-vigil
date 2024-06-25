<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/callback-form', [\App\Http\Controllers\UserController::class, 'callbackForm'])->name('callback-form');
