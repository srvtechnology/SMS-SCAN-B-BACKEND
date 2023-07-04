@extends('school.layouts.main')
@section('page_title', 'Exam Result/Class-'.getResultData(request()->exam_id,request()->class_id,request()->section_id))
@section('content')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('school.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Result</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card">
                            <div class="card-body">
                                <form id="myForm" action="" method="GET">
                                    <div class="row">
                                        <h4>Result</h4>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Class:</label>
                                                    <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror class_id">
                                                        <option value="">Select</option>
                                                        @if(count($classes))
                                                        @foreach($classes as $class)
                                                        <option value="{{ $class->id }}" @if(request()->class_id == $class->id) selected @endif>{{ $class->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="invalid-feedback">ClassField is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Section:</label>
                                                    <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror section_id">
                                                        <option value="">Select</option>

                                                    </select>
                                                    <span class="invalid-feedback">Section is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Exam:</label>
                                                    <select name="exam_id" id="exam_id" class="form-control @error('exam_id') is-invalid @enderror exam_id">
                                                        <option value="">Select</option>
                                                        @if(count($exams))
                                                        @foreach($exams as $exam)
                                                        <option value="{{ $exam->id }}" @if($exam->id==request()->exam_id) selected @endif>{{ $exam->title }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="invalid-feedback">Exam is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <button class="btn btn-primary mt-4 submitBtn">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($subjects))
            @if(canHaveRole('Filter Result'))
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card">
                            <div class="card-body">
                                <form id="myForm2" action="" method="GET">
                                    <input type="hidden" name="class_id" value="{{ request()->input('class_id') }}">
                                    <input type="hidden" name="section_id" value="{{ request()->input('section_id') }}">
                                    <input type="hidden" name="exam_id" value="{{ request()->input('exam_id') }}">
                                    <div class="row">
                                        <h4>Filter</h4>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Students:</label>
                                                    <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror student_id">
                                                        <option value="">All Students</option>
                                                        @if(count($students))
                                                        @foreach($students as $student)
                                                        <option value="{{ $student->student->id }}" @if(request()->student_id == $student->student->id) selected @endif>{{ $student->student->first_name }} {{ $student->student->last_name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="invalid-feedback">ClassField is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Subjects:</label>
                                                    <select name="subject_id" id="subject_id" class="form-control @error('subject_id') is-invalid @enderror subject_id">
                                                        <option value="">All Subjects</option>

                                                    </select>
                                                    <span class="invalid-feedback">ClassField is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary mt-4 submitBtn" onclick="studentFilter()">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card">
                            <div class="card-body">
                                <table id="myTable">
                                    <thead>
                                        <tr>
                                            <td colspan="20" style="text-align:center !important;"><h4>Exam Result/Class-{{ getResultData(request()->exam_id,request()->class_id,request()->section_id) }}</h4></td>
                                        </tr>
                                        <tr>
                                            <th>Student name</th>
                                            @if(count($subjects))
                                                @foreach($subjects as $subject)
                                                    <th style="text-align:center !important;">
                                                        {{ $subject['name'] }} <br>
                                                        Total Marks - {{ getSubjectTotalMarks(request()->exam_id,request()->class_id,request()->section_id,$subject['id']) }}
                                                    </th>
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($students) > 0)
                                            @foreach($students as $student)
                                                <tr>
                                                    <td>{{ $student->student->first_name }} {{ $student->student->last_name }}</td>
                                                    @if(count($subjects))
                                                        @foreach($subjects as $subject)
                                                            <td style="text-align:center !important;">
                                                                {{ getSubjectObtainedMarks(request()->exam_id,request()->class_id,request()->section_id,$subject['id'],$student->student->id) }}
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    @push('footer-script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                paging: false,
                searching: false,
                ordering: false,
                dom: 'Bfrtip',
                buttons: [
                    'pdfHtml5'
                ]
            });
        });
    </script>

    <script>
        var class_id = $(".class_id").val();
        var curSection = '{{ request()->section_id }}';
        var curSubject = '{{ request()->subject_id }}';
        $.ajax({
            url: '{{ url('school/time-table/assign-periods/get-all-data-by-class') }}' + '/' + class_id,
            type: 'GET',
            success: function(response) {
                $("#section_id").html('');
                $("#subject_id").html('');
                $(response.sections).each(function(index, element) {
                    if(curSection == element.id)
                    {
                        var selected = "selected";
                    }
                    $("#section_id").append('<option value="' + element.id + '" '+selected+'>' + element
                        .name + '</option>');
                });
                $("#subject_id").append('<option value="">All Subjects</option>');
                $(response.subjects).each(function(index, element) {
                    if(curSubject == element.id)
                    {
                        var selected = "selected";
                    }
                    $("#subject_id").append('<option value="' + element.id + '" '+selected+'>' + element
                        .name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('failed');
            }
        });

        $(".class_id").on("change", function(){
            var class_id = $(this).val();
            getDataByClass(class_id);
        });

        function getDataByClass(class_id){
            $.ajax({
                url: '{{ url('school/time-table/assign-periods/get-all-data-by-class') }}' + '/' + class_id,
                type: 'GET',
                success: function(response) {
                    $("#section_id").html('');
                    $(response.sections).each(function(index, element) {
                        $("#section_id").append('<option value="' + element.id + '">' + element
                            .name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('failed');
                }
            });
        }

        function validateField(field) {
            var fieldValue = field.val();

            if (fieldValue === '') {
              field.addClass('is-invalid');
              return false;
            } else {
              field.removeClass('is-invalid');
              return true;
            }
        }

        function validateForm() {
            var isValid = true;

            $('[id^=class_id], [id^=section_id], [id^=exam_id]').each(function() {
              var field = $(this);
              isValid = validateField(field) && isValid;
            });

            return isValid;
        }
        $("#myForm").on("submit", function(event){
            event.preventDefault();
            if (validateForm()) {
                $(this).unbind('submit').submit();
            }
        });
        function studentFilter(){
            $.ajax({
                url: '{{ url('school/attendances/view-attendance') }}',
                type: 'GET',
                success: function(response) {
                    $("#myForm2").unbind('submit').submit();
                },
                error: function(xhr, status, error) {
                    console.error('failed');
                }
            });
        }
    </script>
    @endpush
@endsection
