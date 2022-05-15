<?php

use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\MethodController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('balances', BalanceController::class);
    Route::apiResource('expenses', ExpenseController::class);
    Route::apiResource('methods', MethodController::class);
    Route::apiResource('loans', LoanController::class);

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('stats', [DashboardController::class, 'stats']);
    });
});
