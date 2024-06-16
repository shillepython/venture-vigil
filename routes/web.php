<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier');
    Route::get('/cashier/{id}', [CashierController::class, 'show'])->name('cashier.show');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.list');

});
