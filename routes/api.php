<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGamesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    // Auth
    Route::post(AuthController::getEndpointUrl() . '/register', [AuthController::class, 'register']);
    Route::post(AuthController::getEndpointUrl() . '/login', [AuthController::class, 'login'])->name('login');


    Route::middleware('auth:sanctum')->group(function () {
        // Game
        Route::get(GameController::getEndpointUrl() . '/scan', [GameController::class, 'scanGame']);

        // Auth
        Route::post(AuthController::getEndpointUrl() . '/logout', [AuthController::class, 'logout']);

        // User
        Route::get(UserController::getEndpointUrl(), [UserController::class, 'users']);
        Route::get(UserController::getEndpointUrl() . '/user', [UserController::class, 'user']);
        Route::get(UserController::getEndpointUrl() . '/{id}', [UserController::class, 'getUser']);

        // UserGames
        Route::get(UserGamesController::getEndpointUrl(), [UserGamesController::class, 'getUsersGames']);

        // Game Achievements
        Route::get(AchievementController::getEndpointUrl() . '/{id}', [AchievementController::class, 'getGameAchievements']);
        Route::put(AchievementController::getEndpointUrl() . '/{id}', [AchievementController::class, 'updateGameAchievements']);

    });

});



