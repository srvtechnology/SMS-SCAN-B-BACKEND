<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;
class RoleController extends Controller
{
    public function index(){
         $roles = Role::get();
        return view('roles',compact('roles'));
    }
    public function show_role(){
        $permissions = Permission::get();
        return view('add_role',compact('permissions'));
    }
    public function create_role(Request $req){

        $role = new Role();
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
        return redirect()->route('roles');
    }
    public function delete($id){
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles');
    }
    public function editrole($id){
        $role = Role::find($id);
        $permissions = Permission::get();
        $role_permissions = Role::with('permissions')->get();
        return view('edit_role',compact('role','permissions','role_permissions'));
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
       return redirect()->route('roles');
    }
}
