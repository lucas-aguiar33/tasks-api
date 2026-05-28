<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::apiResource('tasks', TaskController::class);
});


