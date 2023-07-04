<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Controllers\Controller;
class PermissionsController extends Controller
{
    //
    public function index(){
        $permissions = Permission::get();
        return view('school.roles.permissions',compact('permissions'));
    }
    public function add_permission(){
        return view('school.roles.add_permission');
    }
    public function create_permission(Request $req){

        $permission = new Permission();
        $permission->name = $req->permission_name;
        $permission->save();
        return redirect()->route('school.permissions');
    }
    public function delete(Request $request){
         $permission = Permission::find($request->id);
        $permission->delete();
        return redirect()->route('school.permissions');
    }
    public function editpermission($id){
        $permission = Permission::find($id);
        return view('school.roles.edit_permission',compact('permission'));
    }
    public function update_permission(Request $req){

        $permission = Permission::find($req->permission_id);
        $permission->name = $req->permission_name;
        $permission->save();
        return redirect()->route('school.permissions');
    }
}
