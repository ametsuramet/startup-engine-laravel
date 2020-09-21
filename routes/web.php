<?php

use Ametsuramet\StartupEngine\CoreAuth;
use Illuminate\Support\Facades\Route;
use Ametsuramet\StartupEngine\CoreModule;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('pages.auth.login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.post');
Route::group(['prefix' => 'admin', 'middleware' => AdminMiddleware::class], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});
// Route::get('/test', function () {
//     $core = new CoreAuth("32395c3a-c78f-432e-b553-0e0489699dbb");
//     try {
//         $data = $core->login("support@codelite.id", "balakutakb", "web", "1234");
//         print_r($data);

//     } catch (\Exception $th) {
//         dd($th);
//     }

//     // echo "test";
// });
