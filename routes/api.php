<?php

use App\Http\Controllers\ScreensController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/login', [UserController::class, 'loginUser']);

Route::middleware('jwt.verify')->group(function() {
    // User
    Route::prefix('user')->group(function () {
        Route::post('/logout', [UserController::class, 'logoutUser']);
    });

    // Content
    Route::prefix('user/content')->group(function () {
        // Screens
        Route::get('/screens/list', [ScreensController::class, 'list']);
        Route::post('/screens/create', [ScreensController::class, 'insertOrUpdate']);
        Route::delete('/screens/delete', [ScreensController::class, 'delete']);
        // Categories
    });
});
