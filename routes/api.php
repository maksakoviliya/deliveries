<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sanctum/token', TokenController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users/auth', AuthController::class);

    // Companies
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');

    // Recipients
    Route::get('/recipients', [RecipientController::class, 'index'])->name('recipients.index');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.create');

    // Clients
    Route::middleware(['admin'])->group(function() {
        Route::get('/clients', [UserController::class, 'index'])->name('clients.index');
        Route::get('/clients/{user}', [UserController::class, 'show'])->name('clients.show');
        Route::post('/clients', [UserController::class, 'store'])->name('clients.store');
        Route::post('/clients/{user}', [UserController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{user}', [UserController::class, 'destroy'])->name('clients.destroy');
    });
});
