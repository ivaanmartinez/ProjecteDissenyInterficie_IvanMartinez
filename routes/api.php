<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiMultimediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [ApiAuthController::class, 'login']);
Route::get('/multimedia', [ApiMultimediaController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/multimedia', [ApiMultimediaController::class, 'store']);

    Route::get('/multimedia/user/{userId}', [ApiMultimediaController::class, 'show']);

    Route::get('/multimedia/file/{id}', [ApiMultimediaController::class, 'showFile']);
    Route::put('/multimedia/file/{id}', [ApiMultimediaController::class, 'update']);
    Route::delete('/multimedia/{id}', [ApiMultimediaController::class, 'destroy']);
});
