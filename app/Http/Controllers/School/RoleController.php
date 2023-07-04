<?php

namespace App\Http\Controllers\School;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index(){
         $roles = Role::get();
        return view('school.roles.roles',compact('roles'));
    }
    public function show_role(){
        $permissions = Permission::get();
        return view('school.roles.add_role',compact('permissions'));
    }
    public function create_role(Request $req){
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $role = new Role();
        $role->school_id = $school->id;
        $role->name = $req->role_name;
        $role->save();
    if ($req->permissions) {
        foreach ($req->permissions as $permission) {
            $item = new PermissionRole();
            $item->permission_id = $permission;
            $item->role_id = $role->id;
            $item->save();
        }
    }
        return redirect()->route('school.roles');
    }
    public function delete(Request $request){
        $role = Role::find($request->id);
        $role->delete();
        return redirect()->route('school.roles');
    }
    public function editrole($id){
        $role = Role::find($id);
        $permissions = Permission::get();
        $role_permissions = Role::with('permissions')->get();
        return view('school.roles.edit_role',compact('role','permissions','role_permissions'));
    }
    public function updaterole(Request $req){

        $role = Role::find($req->role_id);
        $role_permissions = PermissionRole::where('role_id','=',$role->id)->get();
      foreach ($role_permissions as $key => $value) {
        $value->delete();
      }
      $role->name = $req->role_name;
      $role->save();
      if ($req->permissions) {
      foreach ($req->permissions as $permission) {
          $item = new PermissionRole();
          $item->permission_id = $permission;
          $item->role_id = $role->id;
          $item->save();
      }}
       return redirect()->route('school.roles');
    }
}
