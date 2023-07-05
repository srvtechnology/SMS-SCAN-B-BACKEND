<?php

namespace App\Http\Controllers\School;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index(){
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $users = User::where('school_id',$school->id)->where('type','school')->where('is_deleted','0')->get();
        return view('school.admin_users.users',compact('users'));
    }
    public function add_user(){
         $roles = Role::get();
        return view('school.admin_users.add_users',compact('roles'));
    }
    public function create_user(Request $req){
        $validator = Validator::make($req->all(), [
            'Name' =>'required',
            'email' =>'required',
            'phoneNumber'   =>'required',
            'role_id' =>'required'
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $user = new User();
        $username = $this->generateUserName();
        $user->username = $username;
        $random_password = Str::random(8);

        $user->type = 'school';
        $user->password = Hash::make($random_password);
        $user->school_id = $school->id;
        $user->name = $req->Name;
        $user->email = $req->email;
        $user->phone_number = $req->phoneNumber;
        $user->role_id = $req->role_id;
        $user->save();

        Mail::send('email.school.register', ['name' => $req->name,'email'=>$req->email,'username'=>$username,'password'=>$random_password], function($message) use($req){
            $message->to($req->email);
            $message->subject('School Login Credentials');
        });
        return redirect()->route('school.users');
    }

    private function generateUserName()
    {
        $str = Str::random(8);
        $count = User::where('username',$str)->count();
        if($count > 0)
        {
            $str = $str . $count;
        }
        return $str;
    }

    public function edituser($id){
         $user = User::find($id);

         $roles = Role::get();
        return view('school.admin_users.edit_user',compact('user','roles'));
    }
    public function delete_completeuser(Request $request){
         $user = User::find($request->id);
        $user->delete();
        return redirect()->route('school.users');
    }
    public function updateuser(Request $req){
        $validator = Validator::make($req->all(), [
            'Name' => 'required',
            'email' => 'required|unique:users,email,' . $req->user_id,
            'phoneNumber' => 'required',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user =  User::find($req->user_id);
        $user->name = $req->Name;
        $user->email = $req->email;
        $user->phone_number = $req->phoneNumber;
        $user->role_id = $req->role_id;
        $user->save();
        return redirect()->route('school.users');
    }
}

