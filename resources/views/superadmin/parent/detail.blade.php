@extends('layouts.main')
@section('page_title', 'Parents')
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
                            <a href="{{ route('superadmin.parents') }}">Parents</a>
                        </li>
                        <li class="breadcrumb-item active">View Parent</li>
                    </ol>
                </nav>
                <a href="{{ route('superadmin.parents') }}" class="btn rounded-pill btn-primary text-white">Back</a>
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
                                        <label>Name</label>
                                        <h5>{{ $parent->name }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Email</label>
                                        <h5>{{ $parent->email }}</h5>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Username</label>
                                        <h5>{{ $parent->username }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Phone</label>
                                        <h5>{{ $parent->phone }}</h5>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Emergency Phone</label>
                                        <h5>{{ $parent->emergency_phone }}</h5>
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
