<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('v1')->group(function () {
//    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//        return $request->user();
//    });

    /* Public APIs*/
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::post('auth', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        /* Private API*/
        Route::delete('auth', [AuthController::class, 'logout'])->name('auth.logout');
        Route::put('auth', [AuthController::class, 'verify'])->name('auth.verify');

        Route::apiResource('tasks', TaskController::class);
    });

});
