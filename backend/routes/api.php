<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->controller(UserController::class)->group(function () {
        Route::get('profile', 'profile');
        Route::put('profile', 'updateProfile');
        Route::get('preferences',  'getPreferences');
        Route::put('preferences',  'updatePreferences');
    });

    Route::controller(ArticleController::class)->group(function () {
        Route::get('articles', 'getArticles');
        // Route::get('generate-article', 'generateArticle');
        Route::get('personalized-feed', 'getPersonalizedFeed')->middleware('auth:sanctum');
    });
    
});

