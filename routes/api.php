<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\IdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']], function(){
    Route::get('/user', [AuthController::class, 'userLogin']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/id', IdController::class);
});