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
                        <li class="breadcrumb-item active">Teachers</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3 justify-content-center">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <div class="card-body">
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-6 mx-auto d-block">
                                            <div class="form-group">
                                                <label for="">Select School</label>
                                                <select name="school_id" id="" class="form-control">
                                                    <option value="">Choose</option>
                                                    @if(count($schools) > 0)
                                                    @foreach($schools as $school)
                                                    <option value="{{ $school->id }}" @if(request()->input('school_id') == $school->id) selected @endif>{{ $school->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button class="btn btn-primary mt-4">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--/ Basic Bootstrap Table -->
                    </div>
                </div>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Teacher Details</h5>
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
                                                <a href="{{ route("superadmin.teachers.detail",$staff->id) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if(count($staffs) > 0)
                            <div class="pagination_custom_class">
                            {{ $staffs->links() }}
                            </div>
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
