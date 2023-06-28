@extends('layouts.main')
@section('page_title', 'Schools')
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
                        <li class="breadcrumb-item active">View School</li>
                    </ol>
                </nav>
                <a href="{{ route('superadmin.schools') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <img src="{{ getSchoolLogo($school->id) }}" alt="user-avatar"
                                                class="d-block img-fluid rounded" height="100" width="100"
                                                id="uploadedAvatar" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="name">School Name</label>
                                        <h5>{{ $school->name }}</h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <h5>{{ $school->email }}</h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="contact_number">Contact Number</label>
                                        <h5>{{ $school->contact_number }}</h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="landline_number">Landland Number</label>
                                        <h5>{{ $school->landline_number }}</h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="affilliation_number">Affilliation Number</label>
                                        <h5>{{ $school->affilliation_number }}</h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="board">Board</label>
                                        <h5>{{ $school->board }}</h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="school_type">School Type</label>
                                        @if ($school->type == 'secondary')
                                            <h5>{{ strtoupper($school->type) }}</h5>
                                        @elseif ($school->type == 'higher_secondary')
                                            <h5>Higher Secondary</h5>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="medium">Education Medium</label>
                                        <h5>{{ strtoupper($school->medium) }}</h5>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="address">Address</label>
                                        <h5>{{ $school->address }}</h5>
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
