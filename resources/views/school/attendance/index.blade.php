@extends('school.layouts.main')
@section('page_title', 'Attendance Sheet/Class-'.getAttendanceData(request()->class_id,request()->section_id,request()->from_date,request()->to_date))
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
                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </nav>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card">
                            <div class="card-body">
                                <form id="myForm" action="" method="GET">
                                    <div class="row">
                                        <h4>Attendance</h4>
                                        <div class="col-md-3 mb-2">
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
                                        <div class="col-md-3 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Section:</label>
                                                    <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror section_id">
                                                        <option value="">Select</option>

                                                    </select>
                                                    <span class="invalid-feedback">Section is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-group">
                                                <label for="field1">From Date:</label>
                                                <input type="date" class="form-control from_date" name="from_date" id="from_date"  @if(!empty(request()->from_date)) value="{{ request()->from_date }}" @endif>
                                                    <span class="invalid-feedback">From Date is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-group">
                                                <label for="field1">To Date:</label>
                                                    <input type="date" class="form-control to_date" name="to_date" id="to_date" @if(!empty(request()->to_date)) value="{{ request()->to_date }}" @endif>
                                                    <span class="invalid-feedback">To Date is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
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
            @if(count($dateList))
            @if(canHaveRole('Filter Attendance'))
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card">
                            <div class="card-body">
                                <form id="myForm2" action="" method="GET">
                                    <input type="hidden" name="class_id" value="{{ request()->input('class_id') }}">
                                    <input type="hidden" name="section_id" value="{{ request()->input('section_id') }}">
                                    <input type="hidden" name="from_date" value="{{ request()->input('from_date') }}">
                                    <input type="hidden" name="to_date" value="{{ request()->input('to_date') }}">
                                    <div class="row">
                                        <h4>Filter</h4>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Students:</label>
                                                    <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror student_id">
                                                        <option value="">All Student</option>
                                                        @if(count($allStudents))
                                                        @foreach($allStudents as $allStudent)
                                                        <option value="{{ $allStudent->student->id }}" @if(request()->student_id == $allStudent->student->id) selected @endif>{{ $allStudent->student->first_name }} {{ $allStudent->student->last_name }}</option>
                                                        @endforeach
                                                        @endif
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
                                <form action="{{ route('school.attendances.downloadPDF') }}" method="get">
                                    <input type="hidden" name="class_id" value="{{ request()->class_id }}">
                                    <input type="hidden" name="section_id" value="{{ request()->section_id }}">
                                    <input type="hidden" name="from_date" value="{{ request()->from_date }}">
                                    <input type="hidden" name="to_date" value="{{ request()->to_date }}">
                                    <input type="hidden" name="student_id" value="{{ request()->student_id }}">
                                    <button class="btn btn btn-secondary">PDF</button>
                                </form>
                                <div class="table-responsive">
                                    <table id="myTable">
                                        <thead>
                                            <tr>
                                                <td colspan="100" style="text-align:center !important;"><h4>Attendance Sheet/Class-{{ getAttendanceData(request()->class_id,request()->section_id,request()->from_date,request()->to_date) }}</h4></td>
                                            </tr>
                                            <tr>
                                                <th>Student name</th>
                                                @if(count($dateList))
                                                    @foreach($dateList as $dateData)
                                                        <th style="text-align:center !important;">
                                                            {{ $dateData['date'] }} <br>
                                                            {{ $dateData['day'] }}
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
                                                        @if(count($dateList))
                                                            @foreach($dateList as $dateData)
                                                                <td style="text-align:center !important;">
                                                                    {{ getStudentAttendance(request()->class_id,request()->section_id,$student->student->id,$dateData['date']) }}
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

            });

        });
    </script>

    <script>
        var class_id = $(".class_id").val();
        var curSection = '{{ request()->section_id }}';
        $.ajax({
            url: '{{ url('school/time-table/assign-periods/get-all-data-by-class') }}' + '/' + class_id,
            type: 'GET',
            success: function(response) {
                $("#section_id").html('');
                $(response.sections).each(function(index, element) {
                    if(curSection == element.id)
                    {
                        var selected = "selected";
                    }
                    $("#section_id").append('<option value="' + element.id + '" '+selected+'>' + element
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

            $('[id^=class_id], [id^=section_id], [id^=from_date], [id^=to_date]').each(function() {
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
