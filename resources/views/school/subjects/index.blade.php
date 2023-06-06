@extends('school.layouts.main')
@section('page_title', 'Subjects')
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
                        <li class="breadcrumb-item active">Subjects</li>
                    </ol>
                </nav>
                <a href="{{ route('school.subjects.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Subject</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Subjects List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subjects as $key => $subject)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $subject->name }}</td>
                                                @if(getSubjectStatus($subject->id) == "active")
                                                <td><span class="badge bg-success">{{ ucwords(getSubjectStatus($subject->id)) }}</span></td>
                                                @elseif(getSubjectStatus($subject->id) == "inactive")
                                                <td><span class="badge bg-danger">{{ ucwords(getSubjectStatus($subject->id)) }}</span></td>
                                                @endif
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route("school.subjects.edit",$subject->id) }}">Edit</a>
                                                        </li>
                                                        @if(getSubjectStatus($subject->id) == "inactive")
                                                        <li>
                                                            <a class="dropdown-item statusBtn" data-id={{ $subject->id }} data-url={{ route("school.subjects.block") }} data-status = {{ getSubjectStatus($subject->id) }}>Activate Subject</a>
                                                        </li>
                                                        @else
                                                        <li>
                                                            <a class="dropdown-item statusBtn" data-id={{ $subject->id }} data-url={{ route("school.subjects.block") }} data-status = {{ getSubjectStatus($subject->id) }}>InActive Subject</a>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item deleteBtn" data-id={{ $subject->id }} data-url={{ route("school.subjects.delete") }}>Delete</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($subjects) > 0)
                            {{ $subjects->links() }}
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
