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
                            <a href="{{ route('school.timetable.assign_periods') }}">Assign Periods</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.assign_periods') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <form id="myForm" action="{{ route('school.timetable.assign_periods.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $assignPeriod->id }}">
                        <div id="mainSection">
                            <div class="my-3">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">

                                                </div>
                                            </div>
                                        </div>
                                        <div id="innerForm">
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="field1">Class:</label>
                                                        <select name="class_id1" id="class_id1"
                                                            class="form-control @error('class_id1') is-invalid @enderror class_id1">
                                                            <option value="">Select</option>
                                                            @if (count($classes))
                                                                @foreach ($classes as $class)
                                                                    <option value="{{ $class->id }}" @if($assignPeriod->class_id == $class->id) selected @endif>{{ $class->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('class_id1')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="field1">Day Range:</label>
                                                        <select name="day_range1" id="day_range1"
                                                            class="form-control @error('day_range1') is-invalid @enderror day_range1">
                                                            <option value="">Select</option>
                                                            @if (count($day_ranges))
                                                                @foreach ($day_ranges as $day_range)
                                                                    <option value="{{ $day_range['id'] }}" @if($assignPeriod->time_table_setting_id == $day_range['id']) selected @endif>{{ $day_range['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('day_range1')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="field1">Period:</label>
                                                        <select name="period_id1" id="period_id1"
                                                            class="form-control @error('period_id1') is-invalid @enderror period_id1">
                                                            <option value="">Select</option>
                                                            @if (count($periods))
                                                            @foreach ($periods as $period)
                                                                <option value="{{ $period->id }}" @if($assignPeriod->time_table_period_id  == $period->id) selected @endif>{{ $period->title }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                        </select>
                                                    </div>
                                                    @error('period_id1')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="field1">Teachers:</label>
                                                        <select name="teacher_id1" id="teacher_id1"
                                                            class="form-control @error('teacher_id1') is-invalid @enderror teacher_id1">
                                                            <option value="">Select</option>
                                                            @if (count($staffs))
                                                                @foreach ($staffs as $staff)
                                                                    <option value="{{ $staff->id }}" @if($assignPeriod->staff_id  == $staff->id) selected @endif>{{ $staff->first_name }} {{ $staff->last_name }}</option>
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('teacher_id1')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="field1">Section:</label>
                                                        <select name="section_id1" id="section_id1"
                                                            class="form-control @error('section_id1') is-invalid @enderror section_id1">
                                                            <option value="">Select</option>
                                                            @if (count($sections))
                                                                @foreach ($sections as $section)
                                                                    <option value="{{ $section['id'] }}" @if($assignPeriod->section_id == $section['id']) selected @endif>{{ $section['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            @endif

                                                        </select>
                                                    </div>
                                                    @error('section_id1')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="field1">Subjects:</label>
                                                        <select name="subject_id1" id="subject_id1"
                                                            class="form-control @error('subject_id1') is-invalid @enderror subject_id1">
                                                            <option value="">Select</option>
                                                            @if (count($subjects))
                                                                @foreach ($subjects as $subject)
                                                                    <option value="{{ $subject['id'] }}" @if($assignPeriod->subject_id == $subject['id']) selected @endif>{{ $subject['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            @endif

                                                        </select>
                                                    </div>
                                                    @error('subject_id1')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    @push('footer-script')
        <script>
            $(".class_id1").on("change", function(){
                var class_id = $(this).val();
                getDataByClass(class_id, 1);
            });

            $(".day_range1").on("change", function(){
                var day_range = $(this).val();
                counter = 1;
                getPeriodsByClass(day_range, counter);
            });


            $(".submitBtn").on("click", function() {
                loader();
            });
            function getPeriodsByClass(day_range,counter)
            {
                $.ajax({
                    url: '{{ url('school/time-table/assign-periods/get-periods-by-class-range') }}' + '/' + day_range,
                    type: 'GET',
                    success: function(response) {
                        $("#period_id"+counter).html('');
                        $(response).each(function(index, element) {
                            $("#period_id"+counter).append('<option value="' + element.id + '">' + element
                                .title + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('failed');
                    }
                });
            }

            function getSpecificPeriod(event)
            {
                var classList = event.target.classList;
                var className = "";

                for (var i = 0; i < classList.length; i++) {
                  if (classList[i].startsWith("day_range")) {
                    className = classList[i];
                    break;
                  }
                }
                var counter = className.replace(/^\D+/g, '');
                var day_range = $("."+className).val();
                getPeriodsByClass(day_range, counter);
            }
            function getDataByClass(class_id,counter){
                $.ajax({
                    url: '{{ url('school/time-table/assign-periods/get-all-data-by-class') }}' + '/' + class_id,
                    type: 'GET',
                    success: function(response) {
                        $("#subject_id"+counter).html('');
                        $("#section_id"+counter).html('');
                        $("#day_range"+counter).html('');
                        $("#day_range"+counter).append('<option value="">Select</option>');
                        $(response.sections).each(function(index, element) {
                            $("#section_id"+counter).append('<option value="' + element.id + '">' + element
                                .name + '</option>');
                        });
                        $(response.subjects).each(function(index, element) {
                            $("#subject_id"+counter).append('<option value="' + element.id + '">' + element
                                .name + '</option>');
                        });
                        $(response.day_range).each(function(index, element) {
                            $("#day_range"+counter).append('<option value="' + element.id + '">' + element
                                .name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('failed');
                    }
                });
            }

            function getSectionByClass(event) {
                var classList = event.target.classList;
                var className = "";

                for (var i = 0; i < classList.length; i++) {
                  if (classList[i].startsWith("class")) {
                    className = classList[i];
                    break;
                  }
                }
                var counter = className.replace(/^\D+/g, '');
                var class_id = $("."+className).val();
                getDataByClass(class_id, counter);
              }


        function validateField(field) {
            var fieldValue = field.val();
            var errorContainer = field.closest('.form-group').find('.text-danger');


            if (fieldValue === '') {
              field.addClass('is-invalid');
              errorContainer.text('This field is required.').show();
              return false;
            } else {
              field.removeClass('is-invalid');
              return true;
            }
          }

          function validateForm() {
            var isValid = true;

            var classIdField = $('#class_id');
            isValid = validateField(classIdField) && isValid;
            var dateRangeField = $('#date_range');
            isValid = validateField(dateRangeField) && isValid;

            $('[id^=title], [id^=staff_id], [id^=start_time], [id^=end_time]').each(function() {
              var field = $(this);
              isValid = validateField(field) && isValid;
            });

            return isValid;
          }

          $('#myForm').submit(function(event) {
            event.preventDefault();

            if (validateForm()) {
                $(this).unbind('submit').submit();
            }
          });
        </script>
    @endpush
@endsection
