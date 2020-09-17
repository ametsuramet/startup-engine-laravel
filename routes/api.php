<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TrackController;
use App\Http\Middleware\GetToken;
use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('registration', [AuthController::class, 'registration']);
Route::post('validation', [AuthController::class, 'validation']);
Route::resource('track', TrackController::class)->middleware(GetToken::class);