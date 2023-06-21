@extends('school.layouts.main')
@section('page_title', 'TimeTable Setting')
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
                        <li class="breadcrumb-item active">TimeTable Setting</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.setting.create') }}" class="btn rounded-pill btn-primary text-white">Create</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">TimeTable Setting List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Class</th>
                                            <th>Time</th>
                                            <th>Days</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($timetable_settings as $timetable_setting)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $timetable_setting->from_class }} to {{ $timetable_setting->to_class }}</td>
                                                <td>{{ date('h:i A', strtotime($timetable_setting->start_time)) }} to {{ date('h:i A', strtotime($timetable_setting->end_time)) }}</td>
                                                <td>
                                                    {{ implode(', ', json_decode($timetable_setting->weekdays)) }}
                                                </td>
                                                <td>
                                                    <a href="{{ route("school.timetable.setting.edit",$timetable_setting->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $timetable_setting->id }} data-url={{ route("school.timetable.setting.delete") }}><i class='bx bxs-trash'></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($timetable_settings) > 0)
                            <div class="pagination_custom_class">
                            {{ $timetable_settings->links() }}
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
