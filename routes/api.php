<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UserController;
use \App\Http\Controllers\Api\SalonController;

/*
|--------------------------------------------------------------------------
| API Routes
|-----------------------------------------------------------------------``---
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('search', [SalonController::class, 'search']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('profile/{id?}', [UserController::class, 'profile']);
    Route::put('profile/edit', [UserController::class, 'edit']);
    Route::post('salons/{id?}', [SalonController::class, 'show']);
    Route::post('salon', [SalonController::class, 'add']);
    Route::put('salon', [SalonController::class, 'edit']);
    Route::post('requests', [SalonController::class, 'requests']);
    Route::post('request', [SalonController::class, 'addRequest']);
    Route::put('request', [SalonController::class, 'editRequest']);

});
