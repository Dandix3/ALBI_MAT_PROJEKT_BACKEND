<?php

use App\Http\Controllers\AchievementActionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ClubController;
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

Route::group(['middleware' => 'cors', 'prefix' => 'v1'], function () {

    /**
     * Auth endpoints
     */
    $endPoint = AuthController::getEndpointUrl();
    $controller = AuthController::class;

    Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
        Route::post('/register', [$controller, 'register'])->name($endPoint . '.register');
        Route::post('/login', [$controller, 'login'])->name('login');
    });


    /**
     * User endpoints
     */
    $endPoint = UserController::getEndpointUrl();
    $controller = UserController::class;

    Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
        Route::get('/nickname/{nickname}', [$controller, 'findUserByNickname'])->name($endPoint . '.nickname');
        Route::get('/', [$controller, 'users'])->name($endPoint . '.users');
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
            Route::post('/add/{id}', [$controller, 'addGame'])->name($endPoint . '.add');
        });


        /**
         * User endpoints
         */
        $endPoint = UserController::getEndpointUrl();
        $controller = UserController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
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
            Route::post('/add/{id}', [$controller, 'addFriend'])->name($endPoint. '.add');
            Route::post('/remove/{id}', [$controller, 'removeFriend'])->name($endPoint. '.remove');
            Route::get('/requests', [$controller, 'getFriendRequests'])->name($endPoint. '.requests');
            Route::post('/accept/{id}', [$controller, 'acceptFriendRequest'])->name($endPoint. '.accept');
            Route::post('/decline/{id}', [$controller, 'declineFriendRequest'])->name($endPoint. '.decline');
        });


        /**
         * User Friends endpoints
         */
        $endPoint = AchievementActionController::getEndpointUrl();
        $controller = AchievementActionController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
            Route::get('/', [$controller, 'getAchievementActions'])->name($endPoint. '.actions');
            Route::post('/ack/{id}', [$controller, 'ackUserAchievement'])->name($endPoint. '.ack');
            Route::post('/reject/{id}', [$controller, 'rejectUserAchievement'])->name($endPoint. '.reject');
        });


        /**
         * Club endpoints
         */
        $endPoint = ClubController::getEndpointUrl();
        $controller = ClubController::class;

        Route::prefix($endPoint)->group(function () use ($endPoint, $controller) {
            Route::get('/nearby', [$controller, 'getNearestClubs'])->name($endPoint. '.nearby');
            Route::get('/', [$controller, 'getAllClubs'])->name($endPoint. '.clubs');
            Route::get('/{id}', [$controller, 'getClub'])->name($endPoint. '.club');


            Route::post('/remove/{id}', [$controller, 'removeMember'])->name($endPoint. '.remove');
            Route::post('/accept/{id}', [$controller, 'acceptMember'])->name($endPoint. '.accept');
            Route::post('/decline/{id}', [$controller, 'declineMember'])->name($endPoint. '.decline');

            Route::post('/invite/{id}', [$controller, 'addMembers'])->name($endPoint. '.invite');
            Route::post('/join/{id}', [$controller, 'joinClub'])->name($endPoint. '.join');
            Route::post('/leave/{id}', [$controller, 'leaveClub'])->name($endPoint. '.leave');

            Route::post('/', [$controller, 'createClub'])->name($endPoint. '.create');
            Route::put('/{id}', [$controller, 'updateClub'])->name($endPoint. '.update');
            Route::delete('/{id}', [$controller, 'deleteClub'])->name($endPoint. '.delete');
        });

    });

});



