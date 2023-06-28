<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class ManagepasswordController extends Controller
{
    //
    public function index($id){
         $pass = User::find($id)->password;

        return view('manage_password');
    }
    public function changepassword(Request $req){
        $user = User::find(Auth::id());
       if (Hash::check($req->password, $user->password)) {
            $user->password=Hash::make($req->new_password);
            $user->save();
            return back()->with('success','password has been updated successfully');

            }else{
                return back()->with('error','Kindly enter correct old password');
            }
    }
}
