<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public $school;
    public function __construct(){
        $this->school = getSchoolInfoByUsername(request()->segment(1));
    }

    public function dashboard()
    {
        $school = $this->school;
        return view("school.dashboard")->with(compact('school'));
    }
}
