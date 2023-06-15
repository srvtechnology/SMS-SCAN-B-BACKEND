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
                                                    <a href="{{ route("superadmin.schools.detail",$school->id) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                    <a href="{{ route("superadmin.schools.edit",$school->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    @if(getSchoolStatus($school->id) == "blocked")
                                                    <a class="btn btn-success btn-sm text-white blockSchoolBtn" title="Activate" data-id={{ $school->id }} data-url={{ route("superadmin.schools.block") }} data-status = {{ getSchoolStatus($school->id) }}><i class='bx bx-check-shield'></i></a>
                                                    @else
                                                    <a class="btn btn-danger btn-sm text-white blockSchoolBtn" title="Block" data-id={{ $school->id }} data-url={{ route("superadmin.schools.block") }} data-status = {{ getSchoolStatus($school->id) }}><i class='bx bx-block'></i></a>
                                                    @endif
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $school->id }} data-url={{ route("superadmin.schools.delete") }}><i class='bx bxs-trash'></i></a>
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
