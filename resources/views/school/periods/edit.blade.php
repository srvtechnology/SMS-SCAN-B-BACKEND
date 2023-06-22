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
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.periods') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <form id="myForm" action="{{ route('school.timetable.periods.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $curPeriod->time_table_setting_id }}">
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
                                                                @if (count($classes))
                                                                    @foreach ($classes as $class)
                                                                        <option value="{{ $class->id }}" @if($classData->id == $class->id) selected @endif>{{ $class->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        @error('class_id')
                                                            <div class="text-danger">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="">Date Range</label>
                                                            <select class="form-control" name="date_range" id="date_range">
                                                                <option value="">Select</option>
                                                                @if(count($day_ranges) > 0)
                                                                @foreach($day_ranges as $day_range)
                                                                <option value="{{ $day_range['id'] }}" @if($curPeriod->time_table_setting_id == $day_range['id']) selected @endif>{{ $day_range['days'] }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        @error('date_range')
                                                            <div class="text-danger">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="innerForm">
                                            @if(count($periods))
                                            @foreach($periods as $key => $period)
                                            @php
                                                $keyIndex = $key+1;
                                            @endphp
                                            <div class="row"  id="field{{ $keyIndex }}">
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-group">
                                                        <label for="field1">Subjects:</label>
                                                        <select name="subject_id{{ $keyIndex }}" id="subject_id{{ $keyIndex }}"
                                                            class="form-control @error('subject_id{{ $keyIndex }}') is-invalid @enderror subject_id">
                                                            <option value="">Select</option>
                                                            @if(count($subjects))
                                                            @foreach($subjects as $subject)
                                                            <option value="{{ $subject['id'] }}" @if($period->subject_id == $subject['id']) selected @endif>{{ $subject['name'] }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('subject_id')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-group">
                                                        <label for="field{{ $keyIndex }}">Teachers:</label>
                                                        <select name="staff_id{{ $keyIndex }}" id="staff_id{{ $keyIndex }}"
                                                            class="form-control @error('staff_id{{ $keyIndex }}') is-invalid @enderror">
                                                            <option value="">Select</option>
                                                            @if(count($teachers))
                                                            @foreach($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}" @if($period->staff_id == $teacher->id) selected @endif>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('subject_id')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2 mb-2">
                                                    <div class="form-group">
                                                        <label for="field{{ $keyIndex }}">Start Time:</label>
                                                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                                                            name="start_time{{ $keyIndex }}" value="{{ old('start_time$keyIndex',$period->start_time) }}">
                                                    </div>
                                                    @error('start_time')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2 mb-2">
                                                    <div class="form-group">
                                                        <label for="field{{ $keyIndex }}">End Time:</label>
                                                        <input type="time" class="form-control @error('end_time{{ $keyIndex }}') is-invalid @enderror" id="end_time"
                                                            name="end_time{{ $keyIndex }}" value="{{ old('end_time$keyIndex',$period->end_time) }}">
                                                    </div>
                                                    @error('end_time')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    @if($key == 0)
                                                    <button type="button" class="btn btn-primary mt-4 addField" id="addField"><i
                                                        class='bx bx-plus-medical'></i></button>
                                                        @else
                                                        <button type="button" class="btn btn-danger mt-4 removeField" data-index="{{ $key+1 }}"><i class="bx bx-trash"></i></button>
                                                        @endif
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary submitBtn">Submit</button>
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

            var fieldIndex = '{{ count($periods) +1 }}'; // Starting index for dynamic fields
        // Add field when addField button is clicked
        $('#addField').click(function() {
            var class_id = $("#class_id").val();
            getSectionsByClass(class_id,fieldIndex);
            var newField = `
                <div class="row" id="field${fieldIndex}">
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Subjects:</label>
                            <select name="subject_id${fieldIndex}" id="subject_id${fieldIndex}"
                                class="form-control @error('subject_id${fieldIndex}') is-invalid @enderror subject_id">
                                <option value="">Select</option>
                            </select>
                        </div>
                        @error('subject_id${fieldIndex}')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Teachers:</label>
                            <select name="staff_id${fieldIndex}" id="staff_id${fieldIndex}"
                                class="form-control @error('staff_id${fieldIndex}') is-invalid @enderror">
                                <option value="">Select</option>
                                @if(count($teachers))
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @error('subject_id${fieldIndex}')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-2">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Start Time:</label>
                            <input type="time" class="form-control @error('start_time${fieldIndex}') is-invalid @enderror" id="start_time"
                                name="start_time${fieldIndex}" value="{{ old('start_time${fieldIndex}') }}">
                        </div>
                        @error('start_time${fieldIndex}')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-2">
                        <div class="form-group">
                            <label for="field${fieldIndex}">End Time:</label>
                            <input type="time" class="form-control @error('end_time${fieldIndex}') is-invalid @enderror" id="end_time"
                                name="end_time${fieldIndex}" value="{{ old('end_time${fieldIndex}') }}">
                        </div>
                        @error('end_time${fieldIndex}')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="button" class="btn btn-danger mt-4 removeField" data-index="${fieldIndex}"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
            `;

            $('#innerForm').append(newField);

            fieldIndex++;
        });

        // Remove field when removeField button is clicked
        $(document).on('click', '.removeField', function() {
            var index = $(this).data('index');
            $('#field' + index).remove();
        });
        </script>
    @endpush
@endsection
