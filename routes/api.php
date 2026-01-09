<?php

use App\Http\Controllers\Api\TransactionCategoryController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('transactions', TransactionController::class);
Route::apiResource('transaction-categories', TransactionCategoryController::class);
