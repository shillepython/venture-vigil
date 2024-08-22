<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TradingController;
use App\Http\Controllers\TradingOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.list');
        Route::get('/verification', [VerificationController::class, 'list'])->name('verification.list');
        Route::get('/withdrawal', [WithdrawalController::class, 'list'])->name('withdrawal.list');
        Route::get('/users', [UserController::class, 'list'])->name('users.list');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier');
    Route::get('/cashier/{id}', [CashierController::class, 'show'])->name('cashier.show');
});
