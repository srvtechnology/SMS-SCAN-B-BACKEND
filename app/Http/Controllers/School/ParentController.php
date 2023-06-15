<?php

namespace App\Http\Controllers\School;

use App\Models\Parents;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function index()
    {
        $school = getSchoolInfoByUsername(Auth::user()->username);
        $parents = Student::with('parent')->where('school_id', $school->id)->paginate(10);
        return view("school.parent.index")->with(compact('parents'));
    }

    public function detail($id)
    {
        $parent = Parents::find($id);
        return view("school.parent.detail")->with(compact('parent'));
    }
}
