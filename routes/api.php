<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MegyeController;
use App\Http\Controllers\TelepulesController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/megyek', [MegyeController::class, 'index']);
Route::get('/telepulesek', [TelepulesController::class, 'index']);
Route::get('/telepulesek/{telepules}', [TelepulesController::class, 'show']);

// Adatmódosítás csak tokennel
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/telepulesek', [TelepulesController::class, 'store']);
    Route::put('/telepulesek/{telepules}', [TelepulesController::class, 'update']);
    Route::delete('/telepulesek/{telepules}', [TelepulesController::class, 'destroy']);
});
