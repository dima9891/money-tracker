<?php

use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/transactions/create', [TransactionController::class, 'store']);
Route::get('/transactions/list', [TransactionController::class, 'list']);
