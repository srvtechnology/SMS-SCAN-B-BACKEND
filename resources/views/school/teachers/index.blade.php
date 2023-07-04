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
                @if(canHaveRole('Add Staff'))
                <a href="{{ route('school.teachers.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Teacher</a>
                    @endif
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
                                            @if(canHaveRole('Edit Staff') OR canHaveRole('Delete Staff') OR canHaveRole('Detail Staff'))
                                            <th>Action</th>
                                            @endif
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
                                            @if(canHaveRole('Edit Staff') OR canHaveRole('Delete Staff') OR canHaveRole('Detail Staff'))
                                            <td>
                                                @if(canHaveRole('Detail Staff'))
                                                <a href="{{ route("school.teachers.detail",$staff->id) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                @endif
                                                @if(canHaveRole('Edit Staff'))
                                                <a href="{{ route("school.teachers.edit",$staff->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                @endif
                                                @if(canHaveRole('Delete Staff'))
                                                <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $staff->id }} data-url={{ route("school.teachers.delete") }}><i class='bx bxs-trash'></i></a>
                                                @endif
                                            </td>
                                            @endif
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
