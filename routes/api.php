<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/profil/{profil}', [ProfilController::class, 'show']);
    Route::get('/profil', [ProfilController::class, 'index']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('/profil/{profil}', [ProfilController::class, 'update']);
        Route::post('/profil', [ProfilController::class, 'store']);
        Route::delete('/profil/{profil}', [ProfilController::class, 'destroy']);
    });

    Route::post('/auth', [AuthController::class, 'login']);
    Route::delete('/auth', [AuthController::class, 'logout']);
});