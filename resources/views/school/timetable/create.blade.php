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
                        <li class="breadcrumb-item active">Create</li>
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
                                <form id="myForm" action="{{ route("school.timetable.setting.store") }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">From Class:</label>
                                                <select name="from_class" id="from_class" class="form-control @error('from_class') is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    @if(count($classes))
                                                    @foreach($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
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
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
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
                                                    name="start_time" value="{{ old('start_time') }}">

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
                                                    name="end_time" value="{{ old('end_time') }}">
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
                                                <select class="select2_custom form-control weekdays" name="weekdays[]" multiple="multiple">
                                                    @if(count($weekdays) > 0)
                                                    <option value="all">Select All</option>
                                                    @foreach($weekdays as $weekday)
                                                        <option value="{{ $weekday }}">{{ $weekday }}</option>
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

            function handleSelectAllOption(selectClass, allValue) {
                $(selectClass).change(function() {
                    if ($(this).val() != null && $(this).val().includes(allValue)) {
                        $(this).find('option:not([value="' + allValue + '"])').prop('selected', true);
                        $(this).find('option[value="' + allValue + '"]').prop('selected', false);
                    } else {
                        $(this).find('option[value="' + allValue + '"]').prop('selected', false);
                    }
                });
            }

            handleSelectAllOption('.weekdays', 'all');
        </script>
    @endpush
@endsection
