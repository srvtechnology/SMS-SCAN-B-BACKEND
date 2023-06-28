<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
class PermissionsController extends Controller
{
    //
    public function index(){
        $permissions = Permission::get();
        return view('permissions',compact('permissions'));
    }
    public function add_permission(){
        return view('add_permission');
    }
    public function create_permission(Request $req){

        $permission = new Permission();
        $permission->name = $req->permission_name;
        $permission->save();
        return redirect()->route('permissions');
    }
    public function delete($id){
         $permission = Permission::find($id);
        $permission->delete();
        return redirect('permissions');
    }
    public function editpermission($id){
        $permission = Permission::find($id);
        return view('edit_permission',compact('permission'));
    }
    public function update_permission(Request $req){

        $permission = Permission::find($req->permission_id);
        $permission->name = $req->permission_name;
        $permission->save();
        return redirect()->route('permissions');
    }
}
