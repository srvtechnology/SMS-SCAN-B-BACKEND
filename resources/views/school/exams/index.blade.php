@extends('school.layouts.main')
@section('page_title', 'Student Material')
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
                        <li class="breadcrumb-item active">Exams</li>
                    </ol>
                </nav>
                @if(canHaveRole('Add Exam'))
                <a href="{{ route('school.exams.create-exam.create') }}" class="btn rounded-pill btn-primary text-white">Create Exam</a>
                @endif
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Exams List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Class Range</th>
                                            <th>Date</th>
                                            @if(canHaveRole('Delete Exam') OR canHaveRole('Edit Exam') OR canHaveRole('Detail Exam'))
                                            <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($exams as $exam)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $exam->title }}</td>
                                                <td>{{ $exam->fromClass->name }}- {{ $exam->toClass->name }}</td>
                                                <td>{{ date("d/m/Y",strtotime($exam->date)) }}</td>
                                                @if(canHaveRole('Delete Exam') OR canHaveRole('Edit Exam') OR canHaveRole('Detail Exam'))
                                                <td>
                                                    @if(canHaveRole('Detail Exam'))
                                                    <a href="{{ route("school.exams.create-exam.detail",$exam->id) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Edit Exam'))
                                                    <a href="{{ route("school.exams.create-exam.edit",$exam->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Delete Exam'))
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $exam->id }} data-url={{ route("school.exams.create-exam.delete") }}><i class='bx bxs-trash'></i></a>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($exams) > 0)
                            <div class="pagination_custom_class">
                            {{ $exams->links() }}
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
