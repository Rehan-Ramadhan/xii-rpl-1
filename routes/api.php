<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\AktorController;
use App\Http\Controllers\Api\FilmController;

Route::post('register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // route genre
    Route::get('/genres', [GenreController::class, 'index']);
    Route::post('/genres', [GenreController::class, 'store']);
    Route::get('/genres/{id}', [GenreController::class, 'show']);
    Route::put('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

    // route aktor
    Route::get('/aktors', [AktorController::class, 'index']);
    Route::post('/aktors', [AktorController::class, 'store']);
    Route::get('/aktors/{id}', [AktorController::class, 'show']);
    Route::put('/aktors/{id}', [AktorController::class, 'update']);
    Route::delete('/aktors/{id}', [AktorController::class, 'destroy']);

    // route film
    Route::get('/films', [FilmController::class, 'index']);
    Route::post('/films', [FilmController::class, 'store']);
    Route::get('/films/{id}', [FilmController::class, 'show']);
    Route::put('/films/{id}', [FilmController::class, 'update']);
    Route::delete('/films/{id}', [FilmController::class, 'destroy']);
});

Route::prefix('public')->group(function () {
    Route::get('/films', [PublicController::class, 'index']);
    Route::get('/films/{id}', [PublicController::class, 'show']);
    Route::get('/genres', [PublicController::class, 'index']);
    Route::get('/genres/{id}/films', [PublicController::class, 'filmByGenre']);
    Route::get('/actors', [PublicController::class, 'index']);
    Route::get('/actors/{id}/films', [PublicController::class, 'filmByActor']);

    Route::get('/search', [PublicController::class, 'search']);
});
