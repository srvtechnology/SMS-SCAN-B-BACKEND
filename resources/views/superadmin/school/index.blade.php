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
                        <li class="breadcrumb-item active">Schools</li>
                    </ol>
                </nav>
                <a href="{{ route('superadmin.schools.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    School</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">School Details</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Logo</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schools as $key => $school)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img src="{{ getSchoolLogo($school->id) }}" class="img-fluid rounded"
                                                        width="50" height="50" alt="">
                                                </td>
                                                <td>{{ $school->name }}</td>
                                                <td>{{ $school->username }}</td>
                                                <td>{{ $school->email }}</td>
                                                @if(getSchoolStatus($school->id) == "active")
                                                <td><span class="badge bg-success">{{ ucwords(getSchoolStatus($school->id)) }}</span></td>
                                                @elseif(getSchoolStatus($school->id) == "pending")
                                                <td><span class="badge bg-warning">{{ ucwords(getSchoolStatus($school->id)) }}</span></td>
                                                @elseif(getSchoolStatus($school->id) == "blocked")
                                                <td><span class="badge bg-danger">{{ ucwords(getSchoolStatus($school->id)) }}</span></td>
                                                @endif
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route("superadmin.schools.edit",$school->id) }}">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route("superadmin.schools.detail",$school->id) }}">View Detail</a>
                                                        </li>
                                                        @if(getSchoolStatus($school->id) == "blocked")
                                                        <li>
                                                            <a class="dropdown-item blockSchoolBtn" data-id={{ $school->id }} data-url={{ route("superadmin.schools.block") }} data-status = {{ getSchoolStatus($school->id) }}>Activate School</a>
                                                        </li>
                                                        @else
                                                        <li>
                                                            <a class="dropdown-item blockSchoolBtn" data-id={{ $school->id }} data-url={{ route("superadmin.schools.block") }} data-status = {{ getSchoolStatus($school->id) }}>Block School</a>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item deleteBtn" data-id={{ $school->id }} data-url={{ route("superadmin.schools.delete") }}>Delete</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($schools) > 0)
                            {{ $schools->links() }}
                            @endif
                        </div>
                        <!--/ Basic Bootstrap Table -->
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
