<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FitnessActivityController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('fitness-activities', FitnessActivityController::class);
    Route::get('fitness/search', [FitnessActivityController::class, 'search'])->name('search');
    Route::get('fitness/analytics/{activity_type}/{property}/{aggregation}', [FitnessActivityController::class, 'analytics']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
      Route::get('logout', [AuthController::class, 'logout'])->name('logout');;
      Route::get('user', [AuthController::class, 'user']);
    });
});