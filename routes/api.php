<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CourierController;
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
    Route::get('/recipientsForUser/{user}', [RecipientController::class, 'recipientsForUser'])->name('recipients.forUser');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.create');
    Route::post('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    Route::middleware(['admin'])->group(function() {
        // Clients
        Route::get('/clients', [UserController::class, 'index'])->name('clients.index');
        Route::get('/clients/{user}', [UserController::class, 'show'])->name('clients.show');
        Route::post('/clients', [UserController::class, 'store'])->name('clients.store');
        Route::post('/clients/{user}', [UserController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{user}', [UserController::class, 'destroy'])->name('clients.destroy');

        // Orders
        Route::get('/allOrders', [OrderController::class, 'allOrders'])->name('orders.all');

        // Couriers
        Route::get('/couriers', [CourierController::class, 'index'])->name('couriers.index');
        Route::get('/couriers/{courier}', [CourierController::class, 'show'])->name('couriers.show');
        Route::post('/couriers', [CourierController::class, 'store'])->name('couriers.store');
        Route::post('/couriers/{courier}', [CourierController::class, 'update'])->name('couriers.update');
        Route::delete('/couriers/{courier}', [CourierController::class, 'destroy'])->name('couriers.destroy');
    });
});
