<?php

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

Route::apiResource('users', \App\Http\Controllers\UserController::class)
    ->only('index', 'store', 'update', 'destroy');

Route::apiResource('transaction', \App\Http\Controllers\TransactionController::class)
    ->only('index', 'store');
