<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\School\HomeController;
use App\Http\Controllers\School\ClassController;
use App\Http\Controllers\ManagepasswordController;
use App\Http\Controllers\School\SectionController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\TeacherController;
use App\Http\Controllers\School\Auth\AuthController;
use App\Http\Controllers\School\DesignationController;
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

    Route::get('/password/reset', 'reset')->name('school.password-reset');
});
Route::middleware(['school_auth'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('school.dashboard');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('school.logout');
    });

    Route::controller(SectionController::class)->as('school.')->group(function () {
        Route::get('/sections', 'index')->name('sections');
        Route::get('/sections/create', 'create')->name('sections.create');
        Route::post('/sections/store','store')->name('sections.store');
        Route::get('/sections/{id}/edit', 'edit')->name('sections.edit');
        Route::post('/sections/update','update')->name('sections.update');
        Route::post('/sections/block','block')->name('sections.block');
        Route::post('/sections/delete','delete')->name('sections.delete');
    });


    Route::controller(SubjectController::class)->as('school.')->group(function () {
        Route::get('/subjects', 'index')->name('subjects');
        Route::get('/subjects/create', 'create')->name('subjects.create');
        Route::post('/subjects/store','store')->name('subjects.store');
        Route::get('/subjects/{id}/edit', 'edit')->name('subjects.edit');
        Route::post('/subjects/update','update')->name('subjects.update');
        Route::post('/subjects/block','block')->name('subjects.block');
        Route::post('/subjects/delete','delete')->name('subjects.delete');
    });

    Route::controller(ClassController::class)->as('school.')->group(function () {
        Route::get('/class', 'index')->name('class');
        Route::get('/class/create', 'create')->name('class.create');
        Route::post('/class/store','store')->name('class.store');
        Route::get('/class/{id}/edit', 'edit')->name('class.edit');
        Route::get('/class/{id}/detail', 'detail')->name('class.detail');
        Route::post('/class/update','update')->name('class.update');
        Route::post('/class/block','block')->name('class.block');
        Route::post('/class/delete','delete')->name('class.delete');
    });

    Route::controller(DesignationController::class)->as('school.')->group(function () {
        Route::get('/designations', 'index')->name('designations');
        Route::get('/designations/create', 'create')->name('designations.create');
        Route::post('/designations/store','store')->name('designations.store');
        Route::get('/designations/{id}/edit', 'edit')->name('designations.edit');
        Route::post('/designations/update','update')->name('designations.update');
        Route::post('/designations/block','block')->name('designations.block');
        Route::post('/designations/delete','delete')->name('designations.delete');
    });

    Route::controller(TeacherController::class)->as('school.')->group(function () {
        Route::get('/teachers', 'index')->name('teachers');
        Route::get('/teachers/create', 'create')->name('teachers.create');
        Route::post('/teachers/store', 'store')->name('teachers.store');
        Route::get('/teachers/{id}/detail', 'detail')->name('teachers.detail');
        Route::get('/teachers/{id}/edit', 'edit')->name('teachers.edit');
        Route::post('/teachers/update', 'update')->name('teachers.update');
        Route::post('/teachers/delete', 'delete')->name('teachers.delete');
    });
});
