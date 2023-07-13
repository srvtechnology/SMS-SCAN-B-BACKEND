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

        //Teacher Leave
        Route::post('/teacher/attendance/apply-leave', 'applyLeave');
        Route::get('/teacher/view-leave-applications', 'viewLeaveApplication');

        //HomeWork
        Route::post('/teacher/home-work/create', 'createHomeWork');
        Route::post('/teacher/home-work/view', 'viewHomeWork');
        Route::post('/teacher/home-work/edit', 'editHomeWork');
        Route::post('/teacher/home-work/delete', 'deleteHomeWork');
        Route::post('/teacher/home-work/change-status', 'changeStatusHomeWork');

        //Syllabus
        Route::post('/teacher/syllabus/create', 'createSyllabus');
        Route::post('/teacher/syllabus/view', 'viewSyllabus');
        Route::post('/teacher/syllabus/edit', 'editSyllabus');
        Route::post('/teacher/syllabus/delete', 'deleteSyllabus');

        //Resources
        Route::post('/teacher/resources/view', 'viewResources');
        Route::post('/teacher/resources/detail', 'detailResources');

        //TimeTable
        Route::post('/teacher/time-table/view', 'viewTimeTable');
    });

    Route::controller(AttendanceController::class)->group(function () {
        Route::post('/teacher/attendance/view-all-students', 'viewStudents');
        Route::post('/teacher/attendance/student-list', 'studentList');
        Route::post('/teacher/attendance/add-student-attendance', 'addStudentAttendance');
    });

    Route::controller(UserController::class)->group(function () {
        Route::post('/logout', 'logout');
    });
});
