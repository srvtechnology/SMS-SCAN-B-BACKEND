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
                        <li class="breadcrumb-item">
                            <a href="{{ route('school.timetable.setting') }}">TimeTable Setting</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.setting') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <x-alert></x-alert>
                                <form id="myForm" action="{{ route("school.timetable.setting.update") }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $timetable_setting->id }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">From Class:</label>
                                                <select name="from_class" id="from_class" class="form-control @error('from_class') is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    @if(count($classes))
                                                    @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" @if($timetable_setting->from_class == $class->id) selected @endif>{{ $class->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @error('from_class')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">To Class:</label>
                                                <select name="to_class" id="to_class" class="form-control @error('to_class') is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    @if(count($classes))
                                                    @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" @if($timetable_setting->to_class == $class->id) selected @endif>{{ $class->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @error('to_class')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Start Time:</label>
                                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                                                    name="start_time" value="{{ $timetable_setting->start_time }}">
                                            </div>
                                            @error('start_time')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">End Time:</label>
                                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                                                    name="end_time" value="{{ $timetable_setting->end_time }}">
                                            </div>
                                            @error('end_time')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Days:</label>
                                            </div>
                                            <div class="form-group">
                                                <select class="select2_custom form-control" name="weekdays[]" multiple="multiple">
                                                    @if(count($weekdays) > 0)
                                                    @foreach($weekdays as $weekday)
                                                        <option value="{{ $weekday }}" {{ in_array($weekday, json_decode($timetable_setting->weekdays)) ? 'selected' : '' }}>{{ $weekday }}</option>
                                                        @endforeach
                                                    @endif
                                                  </select>
                                            </div>
                                            @error('weekdays')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary submitBtn">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    @push('footer-script')

        <script>
            $(".submitBtn").on("click", function(){
                loader();
            });
        </script>
    @endpush
@endsection
