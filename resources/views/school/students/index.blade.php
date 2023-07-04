@extends('school.layouts.main')
@section('page_title', 'Students')
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
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </nav>
                @if(canHaveRole('Add Student'))
                <a href="{{ route('school.students.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Student</a>
                    @endif
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Students List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            @if(canHaveRole('Edit Student') OR canHaveRole('Delete Student') OR canHaveRole('Detail Student'))
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($students) > 0)
                                        @foreach($students as $student)
                                        <tr>
                                            <td>#</td>
                                            <td>
                                                <img src="{{ getStudentImage($student->id) }}" class="img-fluid rounded"
                                                        width="50" height="50" alt="">
                                            </td>
                                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                            @if(canHaveRole('Edit Student') OR canHaveRole('Delete Student') OR canHaveRole('Detail Student'))
                                            <td>
                                                @if(canHaveRole('Detail Student'))
                                                <a href="{{ route("school.students.detail",$student->id) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                @endif
                                                @if(canHaveRole('Edit Student'))
                                                <a href="{{ route("school.students.edit",$student->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                @endif
                                                @if(canHaveRole('Delete Student'))
                                                <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $student->id }} data-url={{ route("school.students.delete") }}><i class='bx bxs-trash'></i></a>
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if(count($students) > 0)
                            <div class="pagination_custom_class">
                            {{ $students->links() }}
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
