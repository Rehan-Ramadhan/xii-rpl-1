<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\AktorController;
use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\AktorFilmController;

route::post('register', [AuthController::class, 'register']);

route::post('/login', [AuthController::class, 'login']);

route::middleware('auth:sanctum')->group(function () {
    route::get('/profile', [AuthController::class, 'profile']);
    route::post('/logout', [AuthController::class, 'logout']);

    // route genre
    route::get('/genre', [GenreController::class, 'index']);
    route::post('/genre', [GenreController::class, 'store']);
    route::get('/genre/{id}', [GenreController::class, 'show']);
    route::put('/genre/{id}', [GenreController::class, 'update']);
    route::delete('/genre/{id}', [GenreController::class, 'destroy']);

    // route aktor
    route::get('/aktor', [AktorController::class, 'index']);
    route::post('/aktor', [AktorController::class, 'store']);
    route::get('/aktor/{id}', [AktorController::class, 'show']);
    route::put('/aktor/{id}', [AktorController::class, 'update']);
    route::delete('/aktor/{id}', [AktorController::class, 'destroy']);

    // route film
    route::get('/film', [FilmController::class, 'index']);
    route::post('/film', [FilmController::class, 'store']);
    route::get('/film/{id}', [FilmController::class, 'show']);
    route::put('/film/{id}', [FilmController::class, 'update']);
    route::delete('/film/{id}', [FilmController::class, 'destroy']);

    // route aktor film
    route::get('/aktor-film', [AktorFilmController::class, 'index']);
    route::post('/aktor-film', [AktorFilmController::class, 'store']);
    route::get('/aktor-film/{id}', [AktorFilmController::class, 'show']);
    route::put('/aktor-film/{id}', [AktorFilmController::class, 'update']);
    route::delete('/aktor-film/{id}', [AktorFilmController::class, 'destroy']);
});
