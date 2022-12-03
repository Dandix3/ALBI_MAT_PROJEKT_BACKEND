<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFriendController;
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

    /**
     * Auth endpoints
     */
    $endPoint = AuthController::getEndpointUrl();
    $controller = AuthController::class;

    Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
        Route::post('/register', [$controller, 'register'])->name($endPoint . '.register');
        Route::post('/login', [$controller, 'login'])->name('login');
    });


    Route::middleware('auth:sanctum')->group(function () {

        /**
         * Auth endpoints
         */
        $endPoint = AuthController::getEndpointUrl();
        $controller = AuthController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
            Route::post('/logout', [$controller, 'logout'])->name($endPoint . '.logout');
        });


        /**
         * Game endpoints
         */
        $endPoint = GameController::getEndpointUrl();
        $controller = GameController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
            Route::get('/scan', [$controller, 'scanGame'])->name($endPoint . '.scan');
        });


        /**
         * Game endpoints
         */
        $endPoint = UserController::getEndpointUrl();
        $controller = UserController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
            Route::get('/', [$controller, 'users']);
            Route::get('/user', [$controller, 'user']);
            Route::get('/{id}', [$controller, 'getUser']);
        });


        /**
         * UserGame endpoints
         */
        $endPoint = UserGamesController::getEndpointUrl();
        $controller = UserGamesController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
            Route::get('/', [$controller, 'getUsersGames']);
        });


        /**
         * Achievements endpoints
         */
        $endPoint = AchievementController::getEndpointUrl();
        $controller = AchievementController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
            Route::put('/{id}', [$controller, 'updateUserAchievement'])->name($endPoint . '.update');
        });


        /**
         * User Friends endpoints
         */
        $endPoint = UserFriendController::getEndpointUrl();
        $controller = UserFriendController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
            Route::get('/', [$controller, 'getFriends'])->name($endPoint. '.friends');
            Route::post('/add', [$controller, 'addFriend'])->name($endPoint. '.add');
            Route::post('/remove', [$controller, 'removeFriend'])->name($endPoint. '.remove');
            Route::get('/requests', [$controller, 'getFriendRequests'])->name($endPoint. '.requests');
            Route::post('/accept', [$controller, 'acceptFriendRequest'])->name($endPoint. '.accept');
            Route::post('/decline', [$controller, 'declineFriendRequest'])->name($endPoint. '.decline');
        });

    });

});



