<?php

use App\Http\Controllers\Api\V1\ProfilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/profil/{profil}', [ProfilController::class, 'update']);
    Route::apiResource('/profil', ProfilController::class);
});