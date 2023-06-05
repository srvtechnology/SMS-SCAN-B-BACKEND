<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Role;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::where('is_deleted','0')->OrderBy('id',"desc")->paginate(10);
        return view('superadmin.school.index')->with(compact('schools'));
    }

    public function create()
    {
        return view('superadmin.school.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'contact_number'    => 'required',
            'landline_number'    => 'required',
            'affilliation_number'  => 'required',
            'board'  => 'required',
            'type'  => 'required',
            'medium'  => 'required',
            'address'  => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools'), $imageName);
            $data['image'] = $imageName;
        }
        $username = $this->generateUserName();
        $data['created_by'] = Auth::user()->id;
        $random_password = Str::random(8);
        $data['password']   = Hash::make($random_password);
        $data['username'] = $username;
        $result = School::create($data);
        if($result)
        {
            $existUser = User::where('email',$request->email)->first();
            if(!$existUser)
            {
                $role = Role::where('name','SchoolAdmin')->first();
                $user = User::create([
                    'name'  => $request->name,
                    'username' => $username,
                    'email' => $request->email,
                    'password' => $data['password'],
                    'type'  => 'school',
                    'role_id'   =>  $role->id
                ]);
                Mail::send('email.school.register', ['name' => $request->name,'email'=>$request->email,'username'=>$username,'password'=>$random_password], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('School Login Credentials');
                });
            }
        }
        return to_route('superadmin.schools')->with('success','School Added Successfully');
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

    public function edit($id)
    {
        $school = School::findOrFail($id);
        return view('superadmin.school.edit')->with(compact('school'));
    }

    public function update(Request $request)
    {
        $school = School::find($request->id);
        $user = User::where('username',$school->username)->first();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'contact_number'    => 'required',
            'landline_number'    => 'required',
            'affilliation_number'  => 'required',
            'board'  => 'required',
            'type'  => 'required',
            'medium'  => 'required',
            'address'  => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->except('_token');
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools'), $imageName);
            $data['image'] = $imageName;
        }
        School::where('id',$request->id)->update($data);
        User::where('username',$school->username)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return to_route('superadmin.schools')->with('success','School Added Successfully');
    }

    public function detail($id)
    {
        $school = School::findOrFail($id);
        return view('superadmin.school.detail')->with(compact('school'));
    }

    public function block(Request $request)
    {
        $school = School::find($request->id);
        $user = User::where('username',$school->username)->first();
        $user->status = $user->status == "blocked" ? "active" : "blocked";
        $user->save();

        $school->status = $school->status == "blocked" ? "active" : "blocked";
        $school->save();
        return back()->with('success','School Block Successfully');
    }

    public function delete(Request $request)
    {
        $school = School::find($request->id);
        $user = User::where('username',$school->username)->first();
        $user->is_deleted = "1";
        $user->save();

        $school->is_deleted = "1";
        $school->save();
        return back()->with('success','School Deleted Successfully');
    }
}
