@extends('school.layouts.main')
@section('page_title', 'Exam TimeSheet')
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
                            <a href="{{ route('school.exam-timetable') }}">Exam TimeSheet</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
                <a href="{{ route('school.exam-timetable') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form id="myForm" action="{{ route('school.exam-timetable.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Exam:</label>
                                                <select name="exam_id" id="exam_id"
                                                    class="form-control">
                                                    <option value="">Select</option>
                                                    @if (count($exams))
                                                        @foreach ($exams as $exam)
                                                            <option value="{{ $exam->id }}" @if($exam_time_sheet->exam_id == $exam->id) selected @endif>{{ $exam->title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="invalid-feedback">
                                                    Exam is required
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="innerForm">
                                        @if(count($exam_time_sheets))
                                            @foreach($exam_time_sheets as $key => $timeSheetData)
                                            @php
                                                $keyIndex = $key+1;
                                                $subjects = getSubjectsByClass($timeSheetData->class_id);
                                            @endphp
                                        <div class="row"  id="field{{ $keyIndex }}">
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="field{{ $keyIndex }}">Class:</label>
                                                    <select name="class_id{{ $keyIndex }}" id="class_id{{ $keyIndex }}"
                                                        class="form-control @error('class_id{{ $keyIndex }}') is-invalid @enderror class_id{{ $keyIndex }}" onchange="getSubjectsByClass(event)">
                                                        <option value="">Select</option>
                                                        @if (count($classes))
                                                            @foreach ($classes as $class)
                                                                <option value="{{ $class->id }}" @if($timeSheetData->class_id == $class->id) selected @endif>{{ $class->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Class is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="field{{ $keyIndex }}">Subjects:</label>
                                                    <select name="subject_id{{ $keyIndex }}" id="subject_id{{ $keyIndex }}"
                                                        class="form-control @error('subject_id{{ $keyIndex }}') is-invalid @enderror subject_id{{ $keyIndex }}">
                                                        <option value="">Select</option>
                                                        @if (count($subjects))
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{ $subject['id'] }}" @if($timeSheetData->subject_id == $subject['id']) selected @endif>{{ $subject['name'] }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Subject is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="field{{ $keyIndex }}">Date:</label>
                                                    <input type="date" name="date{{ $keyIndex }}" id="date{{ $keyIndex }}"
                                                        class="form-control date{{ $keyIndex }}" value="{{ $timeSheetData->date }}">
                                                    <div class="invalid-feedback">
                                                        Date is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="field{{ $keyIndex }}">Start Time:</label>

                                                    <input type="text" id="start_time{{ $keyIndex }}"
                                                        class="form-control timepicker @error('start_time{{ $keyIndex }}') is-invalid @enderror"
                                                        name="start_time{{ $keyIndex }}" value="{{ $timeSheetData->start_time }}"/>
                                                    <div class="invalid-feedback">
                                                        Start Time is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="field{{ $keyIndex }}">End Time:</label>
                                                    <input type="text" id="end_time{{ $keyIndex }}"
                                                        class="form-control timepicker @error('end_time{{ $keyIndex }}') is-invalid @enderror"
                                                        name="end_time{{ $keyIndex }}" value="{{ $timeSheetData->end_time }}" />


                                                    <div class="invalid-feedback">
                                                        End Time is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
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
            $(".class_id1").on("change", function() {
                var class_id = $(this).val();
                getDataByClass(class_id, 1);
            });

            var fieldIndex = '{{ $keyIndex }}';
            var fieldIndex = parseInt(fieldIndex) + 1;
            $('#addField').click(function() {

                var newField = `
                <div class="row"  id="field${fieldIndex}">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Class:</label>
                            <select name="class_id${fieldIndex}" id="class_id${fieldIndex}"
                                class="form-control @error('class_id${fieldIndex}') is-invalid @enderror class_id${fieldIndex}" onchange="getSubjectsByClass(event)">
                                <option value="">Select</option>
                                @if (count($classes))
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                Class is required
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Subjects:</label>
                            <select name="subject_id${fieldIndex}" id="subject_id${fieldIndex}"
                                class="form-control @error('subject_id${fieldIndex}') is-invalid @enderror subject_id${fieldIndex}">
                                <option value="">Select</option>

                            </select>
                            <div class="invalid-feedback">
                                Subject is required
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Date:</label>
                            <input type="date" name="date${fieldIndex}" id="date${fieldIndex}" class="form-control date${fieldIndex}">
                            <div class="invalid-feedback">
                                Date is required
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="field${fieldIndex}">Start Time:</label>

                                <input type="text" id="start_time${fieldIndex}" class="form-control timepicker @error('start_time${fieldIndex}') is-invalid @enderror"  name="start_time${fieldIndex}" />
                                <div class="invalid-feedback">
                                    Start Time is required
                                </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="field${fieldIndex}">End Time:</label>
                                <input type="text" id="end_time${fieldIndex}" class="form-control timepicker @error('end_time${fieldIndex}') is-invalid @enderror" name="end_time${fieldIndex}" />


                                <div class="invalid-feedback">
                                    End Time is required
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
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

                $('[id^=exam_id], [id^=class_id], [id^=subject_id], [id^=date], [id^=start_time], [id^=end_time]')
                    .each(function() {
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

            function getDataByClass(class_id, counter) {
                $.ajax({
                    url: '{{ url('school/time-table/assign-periods/get-all-data-by-class') }}' + '/' + class_id,
                    type: 'GET',
                    success: function(response) {
                        $("#subject_id" + counter).html('');
                        $(response.subjects).each(function(index, element) {
                            $("#subject_id" + counter).append('<option value="' + element.id + '">' +
                                element
                                .name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('failed');
                    }
                });
            }

            function getSubjectsByClass(event) {
                var classList = event.target.classList;
                var className = "";

                for (var i = 0; i < classList.length; i++) {
                    if (classList[i].startsWith("class")) {
                        className = classList[i];
                        break;
                    }
                }
                var counter = className.replace(/^\D+/g, '');
                var class_id = $("." + className).val();
                getDataByClass(class_id, counter);
            }
        </script>
    @endpush
@endsection
