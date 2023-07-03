<?php

namespace App\Http\Controllers\School;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\TimeTableSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $exams = Exam::where(['school_id' => $school->id, 'is_deleted' => '0'])->paginate(10);

        return view("school.exams.index")->with(compact('exams'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $class_ranges = TimeTableSetting::where('school_id', $school->id)->where('is_deleted','0')
        ->distinct()->get(['from_class','to_class']);
        return view("school.exams.create")->with(compact('class_ranges'));
    }

    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'title' =>'required',
            'class_range' =>'required',
            'date' =>'required',
         ],[
            'title.required' => 'Title is required',
            'class_range.required' => 'Class Range is required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $explode = explode('-',$request->class_range);
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $count = Exam::where([
            'school_id' => $school->id,'title' => $request->title,
            'from_class' => $explode[0], 'to_class' => $explode[1],
            'date'   => $request->date,'is_deleted' => '0'])
        ->count();
        if($count > 0)
        {
            return back()->with('error','Exam Already exists');
        }
        $exam = new Exam;
        $exam ->school_id = $school->id;
        $exam->title = $request->title;
        $exam->from_class = $explode[0];
        $exam->to_class = $explode[1];
        $exam->date = $request->date;
        $exam->created_by = Auth::user()->id;
        $exam->save();

        return to_route("school.exams.create-exam")->with('success','Exam created successfully');
    }

    public function edit($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $class_ranges = TimeTableSetting::where('school_id', $school->id)->where('is_deleted','0')
        ->distinct()->get(['from_class','to_class']);
        $exam = Exam::findOrFail($id);
        return view("school.exams.edit")->with(compact('class_ranges','exam'));
    }

    public function update(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'title' =>'required',
            'class_range' =>'required',
            'date' =>'required',
         ],[
            'title.required' => 'Title is required',
            'class_range.required' => 'Class Range is required',
         ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $explode = explode('-',$request->class_range);
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $count = Exam::where([
            'school_id' => $school->id,'title' => $request->title,
            'from_class' => $explode[0], 'to_class' => $explode[1],
            'date'   => $request->date,'is_deleted' => '0'])
        ->where('id','!=',$request->id)
        ->count();
        if($count > 0)
        {
            return back()->with('error','Exam Already exists');
        }
        $exam = Exam::find($request->id);
        $exam ->school_id = $school->id;
        $exam->title = $request->title;
        $exam->from_class = $explode[0];
        $exam->to_class = $explode[1];
        $exam->date = $request->date;
        $exam->created_by = Auth::user()->id;
        $exam->save();

        return to_route("school.exams.create-exam")->with('success','Exam created successfully');
    }

    public function detail($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $class_ranges = TimeTableSetting::where('school_id', $school->id)->where('is_deleted','0')
        ->distinct()->get(['from_class','to_class']);
        $exam = Exam::findOrFail($id);
        return view("school.exams.detail")->with(compact('class_ranges','exam'));
    }

    public function delete(Request $request)
    {
        $exam = Exam::find($request->id);
        $exam->delete();

        return back()->with('success','Exam Deleted Successfully');
    }
}
