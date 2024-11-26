<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('api')->group(function () {
    Route::apiResource('fitness-activities', App\Http\Controllers\FitnessActivityController::class);
});