<?php

namespace App\Http\Controllers\School;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\ClassAssignSection;
use App\Models\ClassAssignSubject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where(['school_id' => $school->id,'is_deleted'=> '0'])->OrderBy('id','desc')->paginate(10);
        return view('school.class.index')->with(compact('school', 'classes'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $sections = Section::where(['school_id' => $school->id,'is_deleted' => '0'])->OrderBy('name','asc')->get();
        $subjects = Subject::where(['school_id' => $school->id,'is_deleted' => '0'])->OrderBy('name','asc')->get();
        return view('school.class.create')->with(compact('school','sections','subjects'));
    }

    public function store(Request $request)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $data = $request->all();
        foreach ($data as $key => $values) {
            if (strpos($key, 'name') === 0) {
                $fieldIndex = str_replace('name', '', $key);
                $classData = Classes::where(['school_id' => $school->id,'name'=>$values])->first();
                if(!$classData) {
                    $classData = new Classes();
                    $classData->name = $values[0];
                    $classData->school_id = $school->id;
                    $classData->created_by = Auth::user()->id;
                    $classData->save();
                }


                $sectionIds = $data['section_id' . $fieldIndex];
                $subjectIds = $data['subject_id' . $fieldIndex];
                foreach($sectionIds as $section) {
                    $classAssignSectionData = ClassAssignSection::where(['school_id' => $school->id,'section_id' => $section,'class_id'=>$classData->id])->first();
                    if(!$classAssignSectionData){
                        $classAssignSectionData = new ClassAssignSection();
                        $classAssignSectionData->school_id = $school->id;
                        $classAssignSectionData->section_id = $section;
                        $classAssignSectionData->class_id = $classData->id;
                        $classAssignSectionData->save();
                    }
                }
                foreach($subjectIds as $subject) {
                    $classAssignSubjectData = ClassAssignSubject::where(['school_id' => $school->id,'subject_id' => $subject,'class_id'=>$classData->id])->first();
                    if(!$classAssignSubjectData){
                        $classAssignSubjectData = new ClassAssignSubject();
                        $classAssignSubjectData->school_id = $school->id;
                        $classAssignSubjectData->subject_id = $subject;
                        $classAssignSubjectData->class_id = $classData->id;
                        $classAssignSubjectData->save();
                    }
                }

            }
        }
        return to_route("school.class")->with("success","Section Assign to Class Successfully");
    }

    public function edit($id)
    {
        $subjectAssignArray = [];
        $sectionAssignArray = [];
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classData = Classes::where('id',$id)->first();
        $sections = Section::where(['school_id' => $school->id,'is_deleted' => '0'])->OrderBy('name','asc')->get();
        $sectionAssignData = $classData->assignedSections;
        foreach ($sectionAssignData as $index => $section) {
            $sectionAssignArray[] = $section->section_id;
        }
        $subjectAssignData = $classData->assignedSubjects;
        foreach ($subjectAssignData as $subject) {
            $subjectAssignArray[] = $subject->subject_id;
        }

        $subjects = Subject::where(['school_id' => $school->id,'is_deleted' => '0'])->OrderBy('name','asc')->get();
        return view('school.class.edit')->with(compact('classData','sections','sectionAssignArray','subjects','subjectAssignArray'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(),[
            'name' =>'required',
            'section_id' =>'required',
            'subject_id' =>'required',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $count = Classes::where('school_id',$school->id)->where('id','!=',$request->id)->where('name',$request->name)->count();
        if($count > 0)
        {
            return back()->with('error','Class already exists');
        }
        ClassAssignSection::where('school_id',$school->id)->where('class_id',$request->id)->delete();

        if(count($request->section_id) > 0)
        {
            foreach($request->section_id as $section)
            {
                $classAssignSection = new ClassAssignSection;
                $classAssignSection->school_id = $school->id;
                $classAssignSection->class_id = $request->id;
                $classAssignSection->section_id = $section;
                $classAssignSection->save();
            }
        }

        ClassAssignSubject::where('school_id',$school->id)->where('class_id',$request->id)->delete();

        if(count($request->subject_id) > 0)
        {
            foreach($request->subject_id as $subject)
            {
                $classAssignSubject = new ClassAssignSubject;
                $classAssignSubject->school_id = $school->id;
                $classAssignSubject->class_id = $request->id;
                $classAssignSubject->subject_id = $subject;
                $classAssignSubject->save();
            }
        }

        return to_route("school.class")->with('success','Class Updated Successfully');
    }

    public function block(Request $request)
    {
        $class = Classes::find($request->id);
        $class->status = $class->status == "active" ? "inactive" : "active";
        $class->save();
        return back()->with('success','Class Status Changed Successfully');
    }

    public function detail($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classData = Classes::where('id',$id)->first();
        return view('school.class.detail')->with(compact('classData'));
    }

    public function delete(Request $request)
    {
        $class = Classes::find($request->id);
        $class->is_deleted = "1";
        $class->save();
        return back()->with('success','Class Deleted Successfully');
    }
}
