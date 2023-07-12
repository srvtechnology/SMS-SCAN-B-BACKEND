<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\UserController;
use App\Http\Controllers\API\StudyMaterialController;
use App\Http\Controllers\API\Teacher\TeacherController;
use App\Http\Controllers\API\Teacher\AttendanceController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(UserController::class)->group(function () {
    Route::post('/check-school', 'checkSchool');
    Route::post('/login', 'login');
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
});

Route::middleware('auth:api')->as('api.school.')->group(function () {
    Route::controller(StudyMaterialController::class)->group(function () {
        Route::get('/study-material/get-classes', 'getClasses');
        Route::post('/study-material/get-subjects-by-class', 'getSubjectsByClass');
        Route::post('/study-material/store', 'store');
        Route::get('/study-material/view-all-content', 'viewAllContent');
    });

    Route::controller(TeacherController::class)->group(function () {
        Route::get('/teacher/detail', 'detail');
    });

    Route::controller(AttendanceController::class)->group(function () {
        Route::post('/teacher/attendance/view-all-students', 'viewStudents');
        Route::post('/teacher/attendance/student-list', 'studentList');
        Route::post('/teacher/attendance/add-student-attendance', 'addStudentAttendance');

        Route::post('/teacher/attendance/apply-leave', 'applyLeave');
    });

    Route::controller(UserController::class)->group(function () {
        Route::post('/logout', 'logout');
    });
});
