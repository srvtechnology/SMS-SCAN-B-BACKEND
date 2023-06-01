<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
class UserController extends Controller
{
    //
    public function index(){
        $users = User::get();
        return view('users',compact('users'));
    }
    public function add_user(){
         $roles = Role::get();
        return view('add_users',compact('roles'));
    }
    public function create_user(Request $req){

        $user = new User();
        $user->password = Hash::make($req->password);
        $user->name = $req->Name;
        $user->email = $req->email;
        $user->first_name = $req->firstName;
        $user->last_name = $req->lastName;
        $user->orgnization = $req->organization;
        $user->phone_number = $req->phoneNumber;
        $user->address = $req->address;
        $user->role_id = $req->role_id;
        if ($req->hasFile('user_image')) {
            $image = $req->file('user_image');
            $fileName = date('dmY').time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path("/uploads"),$fileName);
            $user->image = $fileName;
        }
        $user->save();
        return redirect()->route('users');
    }
    public function edituser($id){
         $user = User::find($id);

         $roles = Role::get();
        return view('edit_user',compact('user','roles'));
    }
    public function delete_completeuser($id){
         $user = User::find($id);
        $user->delete();
        return redirect()->route('users');
    }
    public function updateuser(Request $req){

        $user =  User::find($req->user_id);
        $user->name = $req->Name;
        $user->email = $req->email;
        $user->first_name = $req->firstName;
        $user->last_name = $req->lastName;
        $user->orgnization = $req->organization;
        $user->phone_number = $req->phoneNumber;
        $user->address = $req->address;
        $user->role_id = $req->role_id;
        if ($req->hasFile('user_image')) {
            $image = $req->file('user_image');
            $fileName = date('dmY').time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path("/uploads"),$fileName);
            $user->image = $fileName;
        }
        $user->save();
        return redirect()->route('users');
    }
}

