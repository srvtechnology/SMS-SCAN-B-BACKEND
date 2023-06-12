@extends('school.layouts.main')
@section('page_title', 'Teachers')
@section('content')

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('school.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Teachers</li>
                    </ol>
                </nav>
                <a href="{{ route('school.teachers.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Teacher</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Teachers List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($staffs) > 0)
                                        @foreach($staffs as $staff)
                                        <tr>
                                            <td>#</td>
                                            <td>
                                                <img src="{{ getStaffImage($staff->id) }}" class="img-fluid rounded"
                                                        width="50" height="50" alt="">
                                            </td>
                                            <td>{{ $staff->first_name }} {{ $staff->last_name }}</td>
                                            <td>{{ $staff->designation->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route("school.teachers.detail",$staff->id) }}">View Detail</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
