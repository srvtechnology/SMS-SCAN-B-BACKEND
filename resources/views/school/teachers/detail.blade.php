@extends('school.layouts.main')
@section('page_title', 'Class')
@section('content')

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route("school.dashboard") }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('school.teachers') }}">Teachers</a>
                        </li>
                        <li class="breadcrumb-item active">View Teacher</li>
                    </ol>
                </nav>
                <a href="{{ route('school.teachers') }}" class="btn rounded-pill btn-primary text-white">Back</a>
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
                                        <h5>{{ $staff->first_name }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Last Name</label>
                                        <h5>{{ $staff->last_name }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Email</label>
                                        <h5>{{ $staff->email }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Username</label>
                                        <h5>{{ $staff->username }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Phone</label>
                                        <h5>{{ $staff->phone }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Gender</label>
                                        <h5>{{ ucwords($staff->gender) }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Designation</label>
                                        <h5>{{ $staff->designation->name }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Salary </label>
                                        <h5>{{ $staff->salary }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Joining Date</label>
                                        <h5>{{ date("m/d/Y",strtotime($staff->joining_date)) }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Address</label>
                                        <h5>{{ $staff->address }}</h5>
                                    </div>
                                </div><hr>
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Qualification</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        @if(count($staff->qualifications)>0)
                                        @foreach($staff->qualifications as $qualification)
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label>Year </label>
                                                <h5>{{ $qualification->year }}</h5>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label>Education </label>
                                                <h5>{{ $qualification->education }}</h5>
                                            </div>

                                            <div class="col-md-4 mb-2">
                                                <label>Instituation</label>
                                                <h5>{{ $qualification->instituation }}</h5>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        N/A
                                        @endif
                                    </div>
                                </div><hr>
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Experience</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        @if(count($staff->experiences)>0)
                                        @foreach($staff->experiences as $experience)
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label>From </label>
                                                <h5>{{ date("m/d/Y",strtotime($experience->from_date)) }}</h5>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label>Education </label>
                                                <h5>{{ date("m/d/Y",strtotime($experience->to_date)) }}</h5>
                                            </div>

                                            <div class="col-md-4 mb-2">
                                                <label>Instituation</label>
                                                <h5>{{ $experience->instituation }}</h5>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        N/A
                                        @endif
                                    </div>
                                </div><hr>
                                {{--  <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Classes Assign</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                        @if(count($class_list)>0)
                                        @foreach($class_list as $class)
                                            <div class="col-md-4 mb-2">
                                                <h5>{{ $class }}</h5>
                                            </div>
                                        @endforeach
                                        @else
                                        N/A
                                        @endif
                                        </div>
                                    </div>
                                </div><hr>  --}}
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Subject Assign</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                        @if(count($staff->subjects)>0)
                                        @foreach($staff->subjects as $subject)
                                            <div class="col-md-4 mb-2">
                                                <h5>{{ $subject->subject->name }}</h5>
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
                                        <h4>Additional Documents</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        @if(count($additional_documents) > 0)
                                        @foreach($additional_documents as $key => $document)
                                        <a href="{{ asset("uploads/schools/additional_documents/".$document) }}" class="btn btn-primary" download>Document {{ $key+1 }}</a>&nbsp;
                                        @endforeach
                                        @else
                                        <p>N/A</p>
                                        @endif
                                    </div>
                                </div><hr>
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <h4>Social Profile</h5>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        @if(!empty($staff->fb_profile))
                                        <a href="{{ $staff->fb_profile }}" class="btn btn-primary" target="_blank">Facebook Profile</a>&nbsp;
                                        @endif
                                        @if(!empty($staff->insta_profile))
                                        <a href="{{ $staff->insta_profile }}" class="btn btn-primary" target="_blank">Instagram Profile</a>&nbsp;
                                        @endif
                                        @if(!empty($staff->linkedIn_profile))
                                        <a href="{{ $staff->linkedIn_profile }}" class="btn btn-primary" target="_blank">LinkedIn Profile</a>&nbsp;
                                        @endif
                                        @if(!empty($staff->twitter_profile))
                                        <a href="{{ $staff->twitter_profile }}" class="btn btn-primary" target="_blank">Twitter Profile</a>&nbsp;
                                        @endif
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
