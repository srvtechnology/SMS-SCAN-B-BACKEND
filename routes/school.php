<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\School\HomeController;
use App\Http\Controllers\ManagepasswordController;
use App\Http\Controllers\School\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| School Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('school.login');
    Route::post('/login/process', 'loginProcess')->name('school.loginProcess');
});
Route::middleware(['school_auth'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('school.dashboard');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('school.logout');
    });
});
