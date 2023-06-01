<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ManagepasswordController;
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
Route::get('/',function(){
    return redirect('/login');
});
Route::get('/login', function () {
    return view('auth/login');
});

Auth::routes();
// main routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('profile/{id}',[ProfileController::class,'ShowProfile'])->name('profile');
Route::post('add_profile/{id}',[ProfileController::class,'addprofiledetail'])->name('add_profile');
Route::post('delete_user/{id}',[ProfileController::class,'deleteprofile'])->name('delete_user');


// roles route

Route::middleware(['auth', 'can:Manage Roles'])->group(function () {
Route::get('roles',[RoleController::class,'index'])->name('roles');
Route::get('add_role',[RoleController::class,'show_role'])->name('add_role');
Route::post('create_role',[RoleController::class,'create_role'])->name('create_role');
Route::get('delete_role/{id}',[RoleController::class,'delete'])->name('delete_role');
Route::get('edit_role/{id}',[RoleController::class,'editrole'])->name('edit_role');
Route::post('updaterole',[RoleController::class,'updaterole'])->name('updaterole');
});

// users route

Route::middleware(['auth', 'can:Manage Users'])->group(function () {
Route::get('users',[UserController::class,'index'])->name('users');
Route::get('add_user',[UserController::class,'add_user'])->name('add_user');
Route::post('create_user',[UserController::class,'create_user'])->name('create_user');
Route::get('edit_user/{id}',[UserController::class,'edituser'])->name('edit_user');
Route::get('delete_completeuser/{id}',[UserController::class,'delete_completeuser'])->name('delete_completeuser');
Route::post('update',[UserController::class,'updateuser'])->name('updateuser');
});
// manage password
Route::get('manage_password/{id}',[ManagepasswordController::class,'index'])->name('manage_password');
Route::post('change_password',[ManagepasswordController::class,'changepassword'])->name('changepassword');


// permissions route
Route::middleware(['auth', 'can:Manage Permissions'])->group(function () {
Route::get('permissions',[PermissionsController::class,'index'])->name('permissions');
Route::get('add_permission',[PermissionsController::class,'add_permission'])->name('add_permission');
Route::post('create_permission',[PermissionsController::class,'create_permission'])->name('create_permission');
Route::get('delete/{id}',[PermissionsController::class,'delete'])->name('delete_permission');
Route::get('edit_permission/{id}',[PermissionsController::class,'editpermission'])->name('edit_permission');
Route::post('update_permission',[PermissionsController::class,'update_permission'])->name('update_permission');
});
