<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\School\ExamController;
use App\Http\Controllers\School\HomeController;
use App\Http\Controllers\School\ClassController;
use App\Http\Controllers\School\ParentController;
use App\Http\Controllers\School\ResultController;
use App\Http\Controllers\ManagepasswordController;
use App\Http\Controllers\School\SectionController;
use App\Http\Controllers\School\StudentController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\TeacherController;
use App\Http\Controllers\School\SyllabusController;
use App\Http\Controllers\School\Auth\AuthController;
use App\Http\Controllers\School\TimetableController;
use App\Http\Controllers\School\AttendanceController;
use App\Http\Controllers\School\DesignationController;
use App\Http\Controllers\School\AssignPeriodController;
use App\Http\Controllers\School\ExamTimeSheetController;
use App\Http\Controllers\School\ExamTimeTableController;
use App\Http\Controllers\School\StudyMaterialController;
use App\Http\Controllers\School\PushNotificationController;
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

    Route::controller(TimetableController::class)->as('school.')->group(function () {
        Route::get('/time-table/setting', 'index')->name('timetable.setting');
        Route::get('/time-table/setting/create', 'create')->name('timetable.setting.create');
        Route::post('/time-table/setting/store', 'store')->name('timetable.setting.store');
        Route::get('/time-table/setting/{id}/edit', 'edit')->name('timetable.setting.edit');
        Route::post('/time-table/setting/update', 'update')->name('timetable.setting.update');
        Route::post('/time-table/setting/delete', 'delete')->name('timetable.setting.delete');

        Route::get('/time-table/periods', 'periods')->name('timetable.periods');
        Route::get('/time-table/periods/create', 'createPeriods')->name('timetable.periods.create');
        Route::post('/time-table/periods/store', 'storePeriods')->name('timetable.periods.store');
        Route::get('/time-table/periods/{id}/detail', 'detailPeriods')->name('timetable.periods.detail');
        Route::get('/time-table/periods/{id}/edit', 'editPeriods')->name('timetable.periods.edit');
        Route::post('/time-table/periods/update', 'updatePeriods')->name('timetable.periods.update');
        Route::post('/time-table/periods/delete', 'deletePeriods')->name('timetable.periods.delete');
        Route::get('/time-table/periods/get-date-range/{id}', 'getDateRange')->name('timetable.periods.get-date-range');
        Route::get('/time-table/periods/get-time-range/{class_id}/{day_range}', 'getTimeRange')->name('timetable.periods.get-time-range');
    });

    Route::controller(AssignPeriodController::class)->as('school.')->group(function () {
        Route::get('/time-table/assign-periods', 'index')->name('timetable.assign_periods');
        Route::get('/time-table/assign-periods/create', 'create')->name('timetable.assign_periods.create');
        Route::get('/time-table/assign-periods/get-all-data-by-class/{id}', 'getAllDataByClass')->name('timetable.assign_periods.get-all-data-by-class');
        Route::get('/time-table/assign-periods/get-periods-by-class-range/{id}', 'getPeriodsByClass');
        Route::post('/time-table/assign-periods/store', 'store')->name('timetable.assign_periods.store');
        Route::get('/time-table/assign-periods/{id}/edit', 'edit')->name('timetable.assign_periods.edit');
        Route::post('/time-table/assign-periods/update', 'update')->name('timetable.assign_periods.update');
        Route::post('/time-table/assign-periods/delete', 'delete')->name('timetable.assign_periods.delete');

        Route::get('/time-table/assign-periods/view-timetable', 'viewTimeTable')->name('timetable.assign_periods.view-timetable');
    });

    Route::controller(StudyMaterialController::class)->as('school.')->group(function () {
        Route::get('/study-material/view-content', 'index')->name('studyMaterial.view-content');
        Route::get('/study-material/view-content/create', 'create')->name('studyMaterial.create-content');
        Route::get('/study-material/get-subjects-byclass/{id}', 'getSectionsByClass')->name('studyMaterial.getSubjectsByClass');
        Route::post('/study-material/view-content/store', 'store')->name('studyMaterial.store-content');
        Route::get('/study-material/view-content/{id}/detail', 'detail')->name('studyMaterial.detail-content');
        Route::get('/study-material/view-content/{id}/edit', 'edit')->name('studyMaterial.edit-content');
        Route::post('/study-material/view-content/update', 'update')->name('studyMaterial.update-content');
        Route::post('/study-material/view-content/delete', 'delete')->name('studyMaterial.delete-content');
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

    Route::controller(StudentController::class)->as('school.')->group(function () {
        Route::get('/students', 'index')->name('students');
        Route::get('/students/create', 'create')->name('students.create');
        Route::get('/students/create/get-sections-by-class/{id}', 'getSectionByClass')->name('students.getSectionByClass');
        Route::get('/students/create/get-parent-by-student/{id}', 'getParentByStudent')->name('students.getParentByStudent');
        Route::get('/students/create/get-staff-info/{id}', 'getStaffInfo')->name('students.getStaffInfo');
        Route::post('/students/store', 'store')->name('students.store');
        Route::get('/students/{id}/detail', 'detail')->name('students.detail');
        Route::get('/students/{id}/edit', 'edit')->name('students.edit');
        Route::post('/students/update', 'update')->name('students.update');
        Route::post('/students/delete', 'delete')->name('students.delete');
    });
    Route::controller(ParentController::class)->as('school.')->group(function () {
        Route::get('/parents', 'index')->name('parents');
        Route::get('/parents/{id}/detail', 'detail')->name('parents.detail');
    });

    Route::controller(PushNotificationController::class)->as('school.')->group(function () {
        Route::get('/notifications','index')->name('notification-index');
        Route::get('notification_info/{id}', 'view')->name('notification-view');
        Route::get('notifications/{id}/edit', 'edit')->name('notification-edit');
        Route::get('notifications/create', 'create')->name('notification-create');
        Route::post('notifications/save', 'save')->name('save-notification');
        Route::post('notification_delete', 'destroy')->name('notification-delete');
        Route::post('notifications/update', 'update')->name('update-notification');
    });

    Route::controller(ExamController::class)->as('school.')->group(function () {
        Route::get('/exams/create-exam','index')->name('exams.create-exam');
        Route::get('/exams/create-exam/create','create')->name('exams.create-exam.create');
        Route::post('/exams/create-exam/store','store')->name('exams.create-exam.store');
        Route::get('/exams/create-exam/{id}/edit','edit')->name('exams.create-exam.edit');
        Route::post('/exams/create-exam/update','update')->name('exams.create-exam.update');
        Route::get('/exams/create-exam/{id}/detail','detail')->name('exams.create-exam.detail');
        Route::post('/exams/create-exam/delete','delete')->name('exams.create-exam.delete');
    });

    Route::controller(SyllabusController::class)->as('school.')->group(function () {
        Route::get('/exams/create-syllabus','index')->name('exams.create-syllabus');
        Route::get('/exams/create-syllabus/create','create')->name('exams.create-syllabus.create');
        Route::post('/exams/create-syllabus/store','store')->name('exams.create-syllabus.store');
        Route::get('/exams/create-syllabus/{id}/edit','edit')->name('exams.create-syllabus.edit');
        Route::post('/exams/create-syllabus/update','update')->name('exams.create-syllabus.update');
        Route::get('/exams/create-syllabus/{id}/detail','detail')->name('exams.create-syllabus.detail');
        Route::post('/exams/create-syllabus/delete','delete')->name('exams.create-syllabus.delete');
    });


    Route::controller(ExamTimeSheetController::class)->as('school.')->group(function () {
        Route::get('/exams/exam-timetable','index')->name('exam-timetable');
        Route::get('/exams/exam-timetable/create','create')->name('exam-timetable.create');
        Route::post('/exams/exam-timetable/store','store')->name('exam-timetable.store');
        Route::get('/exams/exam-timetable/{id}/edit','edit')->name('exam-timetable.edit');
        Route::post('/exams/exam-timetable/update','update')->name('exam-timetable.update');
        Route::get('/exams/exam-timetable/{id}/detail','detail')->name('exam-timetable.detail');
        Route::post('/exams/exam-timetable/delete','delete')->name('exam-timetable.delete');

        Route::get('/exams/exam-timetable/get-class-by-exam/{id}','getClassByExam');
        Route::get('/exams/exam-timetable/view-timesheet','viewTimesheet')->name('exam-timetable.viewTimesheet');
    });

    Route::controller(ResultController::class)->as('school.')->group(function () {
        Route::get('/results/view','index')->name('results.index');
    });

    Route::controller(AttendanceController::class)->as('school.')->group(function () {
        Route::get('/attendances/view-attendance','index')->name('attendances.view-attendance');
    });
});
