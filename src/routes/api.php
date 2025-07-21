<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;

Route::patch('/users/{id}', [UserController::class, 'update']);
Route::post('/accounts/{id}/deposit-balance', [AccountController::class, 'depositBalance']);
Route::post('/transfer-balance', [AccountController::class, 'transferBalance']);
