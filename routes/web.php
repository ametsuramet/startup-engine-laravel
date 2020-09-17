<?php

use Ametsuramet\StartupEngine\CoreAuth;
use Illuminate\Support\Facades\Route;
use Ametsuramet\StartupEngine\CoreModule;
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
