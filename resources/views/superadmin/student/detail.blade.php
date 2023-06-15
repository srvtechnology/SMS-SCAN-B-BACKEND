@extends('layouts.main')
@section('page_title', 'Students')
@section('content')
    <style>
        .icons{
            font-size: 50px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url("/home") }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.students') }}">Students</a>
                        </li>
                        <li class="breadcrumb-item active">View Student</li>
                    </ol>
                </nav>
                <a href="{{ route('superadmin.students') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Personal</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>First Name</label>
                                        <h5>{{ $student->first_name }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Last Name</label>
                                        <h5>{{ $student->last_name }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Email</label>
                                        <h5>{{ $student->email }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Username</label>
                                        <h5>{{ $student->username }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Phone</label>
                                        <h5>{{ $student->phone }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Gender</label>
                                        <h5>{{ ucwords($student->gender) }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>DOB </label>
                                        <h5>{{ $student->dob }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Admission Date</label>
                                        <h5>{{ date("m/d/Y",strtotime($student->admission_date)) }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Temporary Address</label>
                                        <h5>{{ $student->address }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Parmanent Address</label>
                                        <h5>{{ $student->address }}</h5>
                                    </div>
                                </div><hr>
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Classes Assign</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                        @if(count($response)>0)
                                        @foreach($response as $class)

                                            <div class="col-md-4 mb-5">
                                                <h5>{{ $class['class_name'] }}</h5>
                                                @if(count($class['sections']) > 0)
                                                @foreach($class['sections'] as $section)
                                                &nbsp;&nbsp;<span>{{ $section['section_name'] }}</span><br>
                                                @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                        @else
                                        N/A
                                        @endif
                                        </div>
                                    </div>
                                </div><hr>
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Background Information</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label>School Name </label>
                                                <h5>{{ $student->bg_school_name ? $student->bg_school_name : "N/A" }}</h5>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label>Class Name </label>
                                                <h5>{{ $student->bg_class_name ? $student->bg_class_name : "N/A" }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label>School Leave Certificate</label><br>
                                                @if(!empty($student->school_leave_certificate))
                                                <a href="{{ asset("uploads/schools/student/".$student->school_leave_certificate) }}" class="" download><i class='bx bx-file icons'></i></a>
                                                @else
                                                N/A
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label>Mark Sheet</label><br>
                                                @if(!empty($student->mark_sheet))
                                                <a href="{{ asset("uploads/schools/student/".$student->mark_sheet) }}" class="" download><i class='bx bx-file icons'></i></a>
                                                @else
                                                N/A
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div><hr>
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Fee Structure</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label>Fee </label>
                                                @if(!empty($student->fees->fee))
                                                <h5>{{ $student->fees->fee }}</h5>
                                                @else
                                                <h5>N/A</h5>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label>Fee Amount </label>
                                                @if(!empty($student->fees->amount))
                                                <h5>{{ $student->fees->amount }}</h5>
                                                @else
                                                <h5>N/A</h5>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div><hr>
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Parent History</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 mb-5">
                                                <label>Name</label>
                                                @if(!empty($student->parent->name))
                                                <h5>{{ $student->parent->name }}</h5>
                                                @else
                                                <br>
                                                N/A
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-5">
                                                <label>Email</label>
                                                @if(!empty($student->parent->email))
                                                <h5>{{ $student->parent->email }}</h5>
                                                @else
                                                <br>
                                                N/A
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-5">
                                                <label>Phone</label>
                                                @if(!empty($student->parent->phone))
                                                <h5>{{ $student->parent->phone }}</h5>
                                                @else
                                                <br>
                                                N/A
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-5">
                                                <label>Emergency Phone</label>
                                                @if(!empty($student->parent->emergency_phone))
                                                <h5>{{ $student->parent->emergency_phone }}</h5>
                                                @else
                                                <br>
                                                N/A
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div><hr>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    @push('footer-script')
    @endpush
@endsection
