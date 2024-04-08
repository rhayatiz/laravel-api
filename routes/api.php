<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/profil', [ProfilController::class, 'index']);
    Route::get('/profil/{profil}', [ProfilController::class, 'show']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        // les méthodes put/patch ne prennent pas en compte le format multipart/form par défaut
        // on doit ajouter ?_method=PUT ou ?_method=PATCH à la fin de l'URL
        // d'une requête POST pour que ça fonctionne (https://stackoverflow.com/a/61960048)
        // j'ai gardé qu'une route POST
        Route::post('/profil/{profil}', [ProfilController::class, 'update']);
        Route::post('/profil', [ProfilController::class, 'store']);
        Route::delete('/profil/{profil}', [ProfilController::class, 'destroy']);
    });

    Route::post('/auth', [AuthController::class, 'login']);
    Route::delete('/auth', [AuthController::class, 'logout']);
});