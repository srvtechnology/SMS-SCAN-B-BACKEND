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
                        <li class="breadcrumb-item active">Exam TimeSheet</li>
                    </ol>
                </nav>
                @if(canHaveRole('Add Exam Time Sheet'))
                <a href="{{ route('school.exam-timetable.create') }}" class="btn rounded-pill btn-primary text-white">Create Exam TimeSheet</a>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card">
                            <div class="card-body">
                                <form id="myForm" action="{{ route('school.exam-timetable.viewTimesheet') }}" method="GET">
                                    <div class="row">
                                        <h4>Time Table Sheet</h4>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Exam:</label>
                                                    <select name="exam_id" id="exam_id" class="form-control @error('exam_id') is-invalid @enderror exam_id">
                                                        <option value="">Select</option>
                                                        @if(count($exams))
                                                        @foreach($exams as $exam)
                                                        <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="invalid-feedback">Exam is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Class:</label>
                                                    <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror class_id">
                                                        <option value="">Select</option>
                                                    </select>
                                                    <span class="invalid-feedback">Class is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <button class="btn btn-primary mt-4 submitBtn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Exams TimeSheet</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Exam</th>
                                            @if(canHaveRole('Delete Exam Time Sheet') OR canHaveRole('Edit Exam Time Sheet') OR canHaveRole('Detail Exam Time Sheet'))
                                            <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($timeSheetList as $timeSheetList)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $timeSheetList['name'] }}</td>
                                                @if(canHaveRole('Delete Exam Time Sheet') OR canHaveRole('Edit Exam Time Sheet') OR canHaveRole('Detail Exam Time Sheet'))
                                                <td>
                                                    @if(canHaveRole('Detail Exam Time Sheet'))
                                                    <a href="{{ route("school.exam-timetable.detail",$timeSheetList['exam_id']) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Edit Exam Time Sheet'))
                                                    <a href="{{ route("school.exam-timetable.edit",$timeSheetList['exam_id']) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Delete Exam Time Sheet'))
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $timeSheetList['exam_id'] }} data-url={{ route("school.exam-timetable.delete") }}><i class='bx bxs-trash'></i></a>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($examsTimeSheet) > 0)
                            <div class="pagination_custom_class">
                            {{ $examsTimeSheet->links() }}
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
    <script>
        $(".exam_id").on("change", function(){
            var exam_id = $(this).val();
            if(exam_id == '')
            {
                $("#class_id").html('');
            }
            $.ajax({
                url: '{{ url('school/exams/exam-timetable/get-class-by-exam/') }}' + '/' + exam_id,
                type: 'GET',
                success: function(response) {
                    $("#class_id").html('');
                    $(response).each(function(index, element) {
                        $("#class_id").append('<option value="' + element.id + '">' + element
                            .name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('failed');
                }
            });
        });
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

            $('[id^=class_id], [id^=exam_id]').each(function() {
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
    </script>
    @endpush
@endsection
