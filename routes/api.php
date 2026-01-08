<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClockController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Clock API routes
Route::prefix('clock')->group(function () {
    Route::get('/current', [ClockController::class, 'getCurrentState']);
    Route::get('/current-type', [ClockController::class, 'getCurrentType']);
    Route::post('/set', [ClockController::class, 'setQuestion']);
    Route::post('/update', [ClockController::class, 'updateQuestion']);
    Route::post('/random', [ClockController::class, 'randomTime']);
    Route::post('/show-answer', [ClockController::class, 'showAnswer']);
    Route::post('/clear', [ClockController::class, 'clearQuestion']);
});
