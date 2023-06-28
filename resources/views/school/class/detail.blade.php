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
                            <a href="{{ url('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.schools') }}">Schools</a>
                        </li>
                        <li class="breadcrumb-item active">View Class</li>
                    </ol>
                </nav>
                <a href="{{ route('school.class') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="name">Class Name</label>
                                        <h5>{{ $classData->name }}</h5>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="address">Sections</label>
                                        @if(count($classData->assignedSections) > 0)
                                            @foreach($classData->assignedSections as $sectionData)
                                            <h6>{{ $sectionData->section->name }}</h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="address">Subjects</label>
                                        @if(count($classData->assignedSubjects) > 0)
                                            @foreach($classData->assignedSubjects as $subjectData)
                                            <h6>{{ $subjectData->subject->name }}</h6>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

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
