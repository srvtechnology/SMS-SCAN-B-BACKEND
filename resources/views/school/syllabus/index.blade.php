@extends('school.layouts.main')
@section('page_title', 'Syllabus')
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
                        <li class="breadcrumb-item active">Syllabus</li>
                    </ol>
                </nav>
                @if(canHaveRole('Add Syllabus'))
                <a href="{{ route('school.exams.create-syllabus.create') }}" class="btn rounded-pill btn-primary text-white">Create Syllabus</a>
                @endif
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Syllabus List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Exam</th>
                                            <th>Title</th>
                                            @if(canHaveRole('Delete Syllabus') OR canHaveRole('Edit Syllabus') OR canHaveRole('Detail Syllabus'))
                                            <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($syllabus as $content)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $content->exam->title }}</td>
                                                <td>{{ $content->title }}</td>
                                                @if(canHaveRole('Delete Syllabus') OR canHaveRole('Edit Syllabus') OR canHaveRole('Detail Syllabus'))
                                                <td>
                                                    @if(canHaveRole('Detail Syllabus'))
                                                    <a href="{{ route("school.exams.create-syllabus.detail",$content->id) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Edit Syllabus'))
                                                    <a href="{{ route("school.exams.create-syllabus.edit",$content->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Delete Syllabus'))
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $content->id }} data-url={{ route("school.exams.create-syllabus.delete") }}><i class='bx bxs-trash'></i></a>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($syllabus) > 0)
                            <div class="pagination_custom_class">
                            {{ $syllabus->links() }}
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
