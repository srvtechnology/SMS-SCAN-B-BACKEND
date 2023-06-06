<?php

namespace App\Http\Controllers\School;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $sections = Section::where(['school_id' => $school->id,'is_deleted'=>'0'])->OrderBy("id","desc")->paginate(10);
        return view('school.sections.index')->with(compact('sections'));
    }

    public function create()
    {
        return view('school.sections.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $school = getSchoolInfoByUsername(Auth::user()->username);

        $sections = $request->section;

        foreach ($sections as $section) {
            $count = Section::where(['school_id' => $school->id,'is_deleted'=>'0','name'=> $section])->count();
            if($count <= 0)
            {
                Section::create([
                    'school_id'    => $school->id,
                    'name' => $section,
                    'created_by' => Auth::user()->id
                ]);
            }
        }
        return to_route('school.sections')->with('success', "Section created successfully");
    }

    public function edit($id)
    {
        $section = Section::find($id);
        return view('school.sections.edit')->with(compact('section'));
    }

    public function update(Request $request)
    {
        $section = Section::find($request->id);
        $validator = Validator::make($request->all(), [
           'name' =>'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $count = Section::where('id','!=',$section->id)->where('school_id',$section->school_id)
        ->where('is_deleted','0')
        ->where('name',$request->name)->count();
        if($count > 0)
        {
            return back()->with('error',"Section name already exists");
        }

        $section->name = $request->name;
        $section->save();
        return to_route('school.sections')->with('success', "Section updated successfully");
    }

    public function block(Request $request)
    {
        $section = Section::find($request->id);
        $section->status = $section->status == "active" ? "inactive" : "active";
        $section->save();
        return back()->with('success','Section Status Changed Successfully');
    }

    public function delete(Request $request)
    {
        $section = Section::find($request->id);
        $section->is_deleted = "1";
        $section->save();
        return back()->with('success','Section Deleted Successfully');
    }
}
