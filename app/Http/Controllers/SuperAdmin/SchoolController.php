<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::where('is_deleted','0')->OrderBy('id',"desc")->get();
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
        $data['created_by'] = Auth::user()->id;
        $data['password']   = Hash::make("12345678");
        School::create($data);
        return to_route('superadmin.schools')->with('success','School Added Successfully');
    }

    public function edit($id)
    {
        $school = School::findOrFail($id);
        return view('superadmin.school.edit')->with(compact('school'));
    }

    public function update(Request $request)
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
        return to_route('superadmin.schools')->with('success','School Added Successfully');
    }
}
