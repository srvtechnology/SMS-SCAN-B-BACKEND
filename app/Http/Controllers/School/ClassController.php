<?php

namespace App\Http\Controllers\School;

use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\ClassAssignSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classes = Classes::where(['school_id' => $school->id,'is_deleted'=> '0'])->paginate(10);
        return view('school.class.index')->with(compact('school', 'classes'));
    }

    public function create()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $sections = Section::where(['school_id' => $school->id,'is_deleted' => '0'])->OrderBy('name','asc')->get();
        return view('school.class.create')->with(compact('school','sections'));
    }

    public function store(Request $request)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $formData = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'name') !== false) {
                $index = str_replace('name', '', $key);
                $formData[$index]['name'] = $value;
            } elseif (strpos($key, 'section') !== false) {
                $index = str_replace('section', '', $key);
                $formData[$index]['sections'] = $value;
            }
        }
        foreach($formData as $data)
        {
            $classData = Classes::where(['school_id' => $school->id,'name'=>$data['name']])->first();
            if(!$classData) {
                $classData = new Classes();
                $classData->name = $data['name'];
                $classData->school_id = $school->id;
                $classData->created_by = Auth::user()->id;
                $classData->save();
            }
            foreach($data['sections'] as $section) {
                $classAssignSectionData = ClassAssignSection::where(['school_id' => $school->id,'section_id' => $section,'class_id'=>$classData->id])->first();
                if(!$classAssignSectionData){
                    $classAssignSectionData = new ClassAssignSection();
                    $classAssignSectionData->school_id = $school->id;
                    $classAssignSectionData->section_id = $section;
                    $classAssignSectionData->class_id = $classData->id;
                    $classAssignSectionData->save();
                }
            }
        }
        return to_route("school.class")->with("success","Section Assign to Class Successfully");
    }

    public function detail($id)
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $classData = Classes::where('id',$id)->first();
        // dd($classData->assignedSections[0]->section->name);
        // return $classData;
        return view('school.class.detail')->with(compact('classData'));
    }
}
