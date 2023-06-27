<?php

namespace App\Http\Controllers\School;

use App\Models\Exam;
use App\Models\Classes;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use App\Models\ClassAssignSubject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SyllabusController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $syllabus = Syllabus::where('school_id',$school->id)->where('is_deleted','0')->OrderBy('id','DESC')->paginate(10);

        return view("school.syllabus.index")->with(compact('syllabus'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->get();

        return view("school.syllabus.create")->with(compact('school', 'classes','exams'));
    }

    public function store(Request $request)
    {
        // return $request;
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'exam_id'  => 'required',
            'title' =>'required',
            'class_id' =>'required',
            'subject_id' =>'required',
         ],[
            'title.required' => 'Title is required',
            'class_id.required' => 'Class is required',
            'subject_id.required' => 'Subject is required',
            'exam_id.required' => 'Exam is required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if(empty($request->description) AND empty($request->media))
        {
            $validator = Validator::make($request->all(), [
                'description'  => 'required',
             ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }

        $syllabus = new Syllabus;
        $syllabus->school_id = $school->id;
        $syllabus->exam_id = $request->exam_id;
        $syllabus->title = $request->title;
        $syllabus->class_id = $request->class_id;
        $syllabus->subject_id = $request->subject_id;
        $syllabus->description = $request->description;
        $syllabus->created_by = Auth::user()->id;
        if($request->hasFile('media'))
        {
            $image = $request->file('media');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/syllabus'), $imageName);
            $syllabus->file = $imageName;
        }
        $syllabus->save();

        return to_route("school.exams.create-syllabus")->with('success','Syllabus uploaded successfully');
    }

    public function edit($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->get();
        $syllabus = Syllabus::findOrFail($id);
        $assignedSubjects = $this->getSectionsByClass($syllabus->class_id);

        return view("school.syllabus.edit")->with(compact('school', 'classes','exams','syllabus','assignedSubjects'));
    }

    public function update(Request $request)
    {
        // return $request;
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $validator = Validator::make($request->all(), [
            'exam_id'  => 'required',
            'title' =>'required',
            'class_id' =>'required',
            'subject_id' =>'required',
         ],[
            'title.required' => 'Title is required',
            'class_id.required' => 'Class is required',
            'subject_id.required' => 'Subject is required',
            'exam_id.required' => 'Exam is required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $syllabus = Syllabus::find($request->id);
        if(empty($syllabus->description) AND empty($syllabus->file))
        {
            $validator = Validator::make($request->all(), [
                'description'  => 'required',
             ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }


        $syllabus->school_id = $school->id;
        $syllabus->exam_id = $request->exam_id;
        $syllabus->title = $request->title;
        $syllabus->class_id = $request->class_id;
        $syllabus->subject_id = $request->subject_id;
        $syllabus->description = $request->description;
        $syllabus->created_by = Auth::user()->id;
        if($request->hasFile('media'))
        {
            $image = $request->file('media');
            $imageName = Auth::user()->id.time() . '.' . $image->extension();
            $image->move(public_path('uploads/schools/syllabus'), $imageName);
            $syllabus->file = $imageName;
        }
        $syllabus->save();

        return to_route("school.exams.create-syllabus")->with('success','Syllabus Updated successfully');
    }

    public function detail($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where('school_id', $school->id)->where('is_deleted','0')->OrderBy("name", 'asc')->get();
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->get();
        $syllabus = Syllabus::findOrFail($id);
        $assignedSubjects = $this->getSectionsByClass($syllabus->class_id);
        // return $assignedSubjects;
        return view("school.syllabus.detail")->with(compact('school', 'classes','exams','syllabus','assignedSubjects'));
    }

    public function delete(Request $request)
    {
        $syllabus = Syllabus::find($request->id);
        $syllabus->is_deleted = '1';
        $syllabus->save();

        return back()->with('success','Syllabus Deleted Successfully');
    }

    public function getSectionsByClass($id)
    {
        $subjects = ClassAssignSubject::with(['subject', 'schoolClass'])
            ->whereHas('schoolClass', function ($query) use($id) {
                $query->where('id', $id);
            })
            ->get();

            $newArr = [];
        foreach ($subjects as $index =>$subject) {
            $newArr[$index]['id'] = $subject->subject_id;
            $newArr[$index]['name'] = $subject->subject->name;
        }
        return $newArr;
    }
}
