<?php

namespace App\Http\Controllers\School\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $school;
    public function __construct(){
        $this->school = getSchoolInfoByUsername(request()->segment(1));
    }

    public function login()
    {
        $school = $this->school;
        return view("school.auth.login")->with(compact('school'));
    }

    public function loginProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password,'status' => 'active','is_deleted' => '0']) )
        {
            $user = Auth::user();
            Auth::login($user);
            return to_route('school.dashboard');
            // return to_route('school.dashboard',$this->school->username);
        }
        return back()->with('error','Invalid username or password');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('school.login');
        // return to_route('school.login',$this->school->username);
    }

    public function reset()
    {
        return view("school.auth.reset-password");
    }
}
