@extends('school.layouts.main')
@section('page_title', 'Syllabus')
@section('content')
<style>
    .icons{
        font-size: 50px;
    }
</style>
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
                            <a href="{{ route('school.exams.create-syllabus') }}">Syllabus</a>
                        </li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
                <a href="{{ route('school.exams.create-syllabus') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Exams:</label>
                                            <h4>{{ $syllabus->exam->title }}</h4>
                                        </div>
                                        @error('exam_id')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field1">Title:</label>
                                            <h4>{{ $syllabus->title }}</h4>
                                        </div>
                                        @error('title')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Class:</label>
                                            <h4>{{ $syllabus->class->name }}</h4>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Subjects:</label>
                                            <h4>{{ $syllabus->subject->name }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Description:</label>
                                            {!! $syllabus->description !!}
                                        </div>
                                    </div>
                                    @if(!empty($syllabus->file))
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Syllabus:</label><br>
                                            <a href="{{ asset("uploads/schools/syllabus/".$syllabus->file) }}" class="" download><i class='bx bx-file icons'></i></a
                                        </div>
                                    </div>
                                    @endif

                                </div>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 200
                });
              });
            $("#class_id").on("change", function(){
                var class_id = $(this).val();
                $.ajax({
                    url: '{{ url("school/study-material/get-subjects-byclass/") }}'+'/'+class_id,
                    type: 'GET',
                    success: function(response) {
                        $("#subject_id").html('');
                        $("#subject_id").append('<option value="">Select</option>');
                        $(response).each(function(index, element) {
                            $("#subject_id").append('<option value="'+element.id+'">'+element.name+'</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                    console.error('failed');
                    }
                });
            });
            $(".submitBtn").on("click", function(){
                loader();
            });
        </script>
    @endpush
@endsection
