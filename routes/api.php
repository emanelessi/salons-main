<?php

use Illuminate\Http\Request;
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
Route::post('search',[SalonController::class,'search']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('profile/{id?}', [UserController::class, 'profile']);
    Route::put('profile/edit', [UserController::class, 'edit']);
    Route::post('salon', [SalonController::class, 'show']);
    Route::post('salon/add', [SalonController::class, 'add']);
    Route::put('salon/edit', [SalonController::class, 'edit']);
    Route::post('request', [SalonController::class, 'request']);
    Route::put('request/edit', [SalonController::class, 'editRequest']);
    Route::post('salon/seat', [SalonController::class, 'salonSeat']);



});
