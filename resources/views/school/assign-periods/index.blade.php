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
                        <li class="breadcrumb-item active">Assign Periods</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.assign_periods.create') }}" class="btn rounded-pill btn-primary text-white">Create</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Assign List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Day Range</th>
                                            <th>Period</th>
                                            <th>Class</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assign_periods as $assign_period)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ implode(",",json_decode($assign_period->day_range->weekdays)) }}</td>
                                                <td>{{ $assign_period->period->title }}</td>
                                                <td>{{ $assign_period->class->name }}</td>
                                                <td>
                                                    <a href="{{ route("school.timetable.assign_periods.edit",$assign_period->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $assign_period->id }} data-url={{ route("school.timetable.assign_periods.delete") }}><i class='bx bxs-trash'></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($assign_periods) > 0)
                            <div class="pagination_custom_class">
                            {{ $assign_periods->links() }}
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
