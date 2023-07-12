@extends('school.layouts.main')
@section('page_title', 'Leave Application')
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
                        <li class="breadcrumb-item active">Leave Application</li>
                    </ol>
                </nav>
                {{--  @if(canHaveRole('Add Designation'))
                <a href="{{ route('school.designations.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Designation</a>
                    @endif  --}}
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Leave Application List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff</th>
                                            <th>Message</th>
                                            <th>File</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leave_applications as $key => $leave_application)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $leave_application->staff->first_name }} {{ $leave_application->staff->last_name }}</td>
                                                <td>{{ !empty($leave_application->message) ? $leave_application->message : "N/A" }}</td>
                                                <td>
                                                    @if(!empty($leave_application->file) AND file_exists(public_path("uploads/schools/leave").'/'.$leave_application->file))
                                                    <a href="{{ asset('uploads/schools/leave/'.$leave_application->file) }}" class="btn btn-sm btn-primary" download="">Download File</a>
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td>{{ date("d/m/Y",strtotime($leave_application->date)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($leave_applications) > 0)
                            <div class="pagination_custom_class">
                            {{ $leave_applications->links() }}
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
