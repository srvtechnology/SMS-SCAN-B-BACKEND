<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profile;
class ProfileController extends Controller
{
    public function ShowProfile($id){
        $user = Auth::user();
        return view('profile_edit',compact('user'));
    }
    public function addprofiledetail(Request $req,$id){
        return $req;
        $user_id = $id;
        $profile = User::find($user_id);
        $profile->first_name = $req->firstName;
        $profile->last_name = $req->lastName;
        $profile->orgnization = $req->organization;
        $profile->phone_number = $req->phoneNumber;
        $profile->address = $req->address;
        if ($req->hasFile('profile_image')) {
            $image = $req->file('profile_image');
            $fileName = date('dmY').time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path("/uploads"),$fileName);
            $profile->image = $fileName;
        }

        $profile->save();
        return redirect()->route('home');
    }
    public function deleteprofile(Request $req, $id){

        $profile = User::find($id);
        $profile->delete();
        Auth::logout();
        return view('/');
    }
}
