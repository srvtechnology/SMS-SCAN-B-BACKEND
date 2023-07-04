@extends('school.layouts.main')
@section('page_title', 'Periods')
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
                        <li class="breadcrumb-item active">Periods</li>
                    </ol>
                </nav>
                @if(canHaveRole('Add Time Range Period'))
                <a href="{{ route('school.timetable.periods.create') }}" class="btn rounded-pill btn-primary text-white">Create</a>
                @endif
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Periods List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Class</th>
                                            <th>Weekdays</th>
                                            @if(canHaveRole('Edit Time Range Period') OR canHaveRole('Delete Time Range Period') OR canHaveRole('Detail Time Range Period'))
                                            <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($periods as $period)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $period['class'] }}</td>
                                                <td>{{ $period['days'] }}</td>
                                                @if(canHaveRole('Edit Time Range Period') OR canHaveRole('Delete Time Range Period') OR canHaveRole('Detail Time Range Period'))
                                                <td>
                                                    @if(canHaveRole('Detail Time Range Period'))
                                                    <a href="{{ route("school.timetable.periods.detail",$period['id']) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Edit Time Range Period'))
                                                    <a href="{{ route("school.timetable.periods.edit",$period['id']) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Delete Time Range Period'))
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $period['id'] }} data-url={{ route("school.timetable.periods.delete") }}><i class='bx bxs-trash'></i></a>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($periodsQuery) > 0)
                            <div class="pagination_custom_class">
                            {{ $periodsQuery->links() }}
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
