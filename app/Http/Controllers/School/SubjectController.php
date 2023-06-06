<?php

namespace App\Http\Controllers\School;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $subjects = Subject::where(['school_id' => $school->id,'is_deleted'=>'0'])->OrderBy("name","asc")->paginate(10);
        return view('school.subjects.index')->with(compact('subjects'));
    }

    public function create()
    {
        return view('school.subjects.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $subjects = $request->subject;

        foreach ($subjects as $subject) {
            $count = Subject::where(['school_id' => $school->id,'is_deleted'=>'0','name'=> $subject])->count();
            if($count <= 0)
            {
                Subject::create([
                    'school_id'    => $school->id,
                    'name' => $subject,
                    'created_by' => Auth::user()->id
                ]);
            }
        }
        return to_route('school.subjects')->with('success', "Subject created successfully");
    }

    public function edit($id)
    {
        $subject = Subject::find($id);
        return view('school.subjects.edit')->with(compact('subject'));
    }

    public function update(Request $request)
    {
        $subject = Subject::find($request->id);
        $validator = Validator::make($request->all(), [
           'name' =>'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $count = Subject::where('id','!=',$subject->id)->where('school_id',$subject->school_id)
        ->where('is_deleted','0')
        ->where('name',$request->name)->count();

        if($count > 0)
        {
            return back()->with('error',"Subject name already exists");
        }

        $subject->name = $request->name;
        $subject->save();
        return to_route('school.subjects')->with('success', "Subject updated successfully");
    }

    public function block(Request $request)
    {
        $subject = Subject::find($request->id);
        $subject->status = $subject->status == "active" ? "inactive" : "active";
        $subject->save();
        return back()->with('success','Subject Status Changed Successfully');
    }

    public function delete(Request $request)
    {
        $subject = Subject::find($request->id);
        $subject->is_deleted = "1";
        $subject->save();
        return back()->with('success','Subject Deleted Successfully');
    }
}
