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
                            <a href="{{ route('school.timetable.periods') }}">Periods</a>
                        </li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.periods') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <form id="myForm" action="{{ route('school.timetable.periods.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="mainSection">
                            <div class="my-3">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="field1">Class:</label>
                                                            <select name="class_id" id="class_id"
                                                                class="form-control @error('class_id') is-invalid @enderror class_id">
                                                                <option value="">Select</option>
                                                                @if (count($class_ranges))
                                                                    @foreach ($class_ranges as $class_range)
                                                                        <option value="{{ $class_range->fromClass->id }}-{{ $class_range->toClass->id }}">{{ $class_range->fromClass->name }}-{{ $class_range->toClass->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Class is required
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="">Day Range</label>
                                                            <select class="form-control" name="date_range" id="date_range">
                                                                <option value="">Select</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Day Range is required
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="innerForm">
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-group">
                                                        <label for="field1">Title</label>
                                                        <input type="text" name="title1" class="form-control @error('title1') is-invalid @enderror" id="title1">
                                                        <div class="invalid-feedback">
                                                            Title is required
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    <div class="form-group">
                                                        <label for="field1">Start Time:</label>
                                                        {{--  <input type="time" class="form-control @error('start_time1') is-invalid @enderror" id="start_time1"
                                                            name="start_time1" value="{{ old('start_time1') }}">  --}}

                                                            <input type="text" id="start_time1" class="form-control timepicker @error('start_time1') is-invalid @enderror"  name="start_time1" />
                                                            <div class="invalid-feedback">
                                                                Start Time is required
                                                            </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    <div class="form-group">
                                                        <label for="field1">End Time:</label>
                                                        {{--  <input type="time" class="form-control @error('end_time1') is-invalid @enderror" id="end_time1"
                                                            name="end_time1" value="{{ old('end_time1') }}">  --}}
                                                            <input type="text" id="end_time1" class="form-control timepicker @error('end_time1') is-invalid @enderror" name="end_time1" />


                                                            <div class="invalid-feedback">
                                                                End Time is required
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <button type="button" class="btn btn-primary mt-4 addField" id="addField"><i
                                                        class='bx bx-plus-medical'></i></button>
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

            $(".class_id").on("change", function(){
                var class_id = $(this).val();
                getSectionsByClass(class_id,1);

                $.ajax({
                    url: '{{ url('school/time-table/periods/get-date-range') }}' + '/' + class_id,
                    type: 'GET',
                    success: function(response) {
                        $("#date_range").html('');
                        $("#date_range").append('<option> Select </option>');
                        $(response).each(function(index, element) {
                            $("#date_range").append('<option value="' + element.id + '">' + element
                                .days + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('failed');
                    }
                });
            });
            $("#date_range").on("change", function(){
                var class_id = $("#class_id").val();
                var day_range = $(this).val();
                $.ajax({
                    url: '{{ url('school/time-table/periods/get-time-range') }}' + '/' + class_id + '/' + day_range,
                    type: 'GET',
                    success: function(response) {

                        $('#innerForm').find('.timepicker').each(function() {
                            var timepickerId = $(this).attr('id');
                            $(this).timepicker({
                                minTime: response.start_time,
                                maxTime: response.end_time
                            });
                            $("#"+timepickerId).attr('min',response.start_time);
                            $("#"+timepickerId).attr('max',response.end_time);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('failed');
                    }
                });
            });

            $(".submitBtn").on("click", function() {
                loader();
            });
            function getSectionsByClass(class_id,counter){
                $.ajax({
                    url: '{{ url('school/study-material/get-subjects-byclass/') }}' + '/' + class_id,
                    type: 'GET',
                    success: function(response) {
                        $("#subject_id"+counter).html('');
                        $("#subject_id"+counter).append('<option value="">Select</option>');
                        $(response).each(function(index, element) {
                            $("#subject_id"+counter).append('<option value="' + element.id + '">' + element
                                .name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('failed');
                    }
                });
            }

            var fieldIndex = 2; // Starting index for dynamic fields

        // Add field when addField button is clicked
        $('#addField').click(function() {
            var class_id = $("#class_id").val();
            getSectionsByClass(class_id,fieldIndex);
            var newField = `
                <div class="row" id="field${fieldIndex}">
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Title:</label>
                            <input type="text" name="title${fieldIndex}" class="form-control @error('title${fieldIndex}') is-invalid @enderror" id="title${fieldIndex}">

                            <div class="invalid-feedback">
                                Class is required
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Start Time:</label>
                            <input type="text" class="form-control timepicker @error('start_time${fieldIndex}') is-invalid @enderror" id="start_time${fieldIndex}"
                                name="start_time${fieldIndex}" value="{{ old('start_time${fieldIndex}') }}">
                                <div class="invalid-feedback">
                                    Start Time is required
                                </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="field${fieldIndex}">End Time:</label>
                            <input type="text" class="form-control timepicker @error('end_time${fieldIndex}') is-invalid @enderror" id="end_time${fieldIndex}"
                                name="end_time${fieldIndex}" value="{{ old('end_time${fieldIndex}') }}">
                                <div class="invalid-feedback">
                                    End Time is required
                                </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" class="btn btn-danger mt-4 removeField" data-index="${fieldIndex}"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
            `;

            $('#innerForm').append(newField);
            $('#innerForm').find('.timepicker').each(function() {
                $(this).timepicker();
            });

            fieldIndex++;
        });

        // Remove field when removeField button is clicked
        $(document).on('click', '.removeField', function() {
            var index = $(this).data('index');
            $('#field' + index).remove();
        });

        function validateField(field) {
            var fieldValue = field.val();
            var errorContainer = field.closest('.form-group').find('.invalid-feedback');


            if (fieldValue === '') {
              field.addClass('is-invalid');
              errorContainer.show();
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
                loader();
                $(this).unbind('submit').submit();
            }
          });
        </script>
    @endpush
@endsection
