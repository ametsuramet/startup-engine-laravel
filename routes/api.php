<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Master\LocationController;
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
Route::get('profile', [AuthController::class, 'profile'])->middleware(GetToken::class);
Route::post('profile', [AuthController::class, 'updateProfile'])->middleware(GetToken::class);
Route::post('upload', [AuthController::class, 'upload'])->middleware(GetToken::class);
Route::get('track/taskToday', [TrackController::class, 'taskToday'])->middleware(GetToken::class)->name('track.taskToday');
Route::get('track/checkIn', [TrackController::class, 'checkIn'])->middleware(GetToken::class)->name('track.checkIn');
Route::get('track/checkOut', [TrackController::class, 'checkOut'])->middleware(GetToken::class)->name('track.checkOut');
Route::resource('track', TrackController::class)->middleware(GetToken::class);
Route::get('master/province', [LocationController::class, 'province']);
Route::get('master/regency', [LocationController::class, 'regency']);
Route::get('master/district', [LocationController::class, 'district']);
Route::get('master/village', [LocationController::class, 'village']);