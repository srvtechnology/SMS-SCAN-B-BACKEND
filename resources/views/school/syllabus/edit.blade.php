@extends('school.layouts.main')
@section('page_title', 'Syllabus')
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
                            <a href="{{ route('school.exams.create-syllabus') }}">Syllabus</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
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
                                <form id="myForm" action="{{ route("school.exams.create-syllabus.update") }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $syllabus->id }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Exams:</label>
                                                <select name="exam_id" id="exam_id" class="form-control @error('exam_id') is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    @if(count($exams))
                                                    @foreach($exams as $exam)
                                                    <option value="{{ $exam->id }}" @if($syllabus->exam_id == $exam->id) selected @endif>{{ $exam->title }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
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
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                                    name="title" value="{{ old('title',$syllabus->title) }}">
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
                                                <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    @if(count($classes))
                                                    @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" @if($syllabus->class_id == $class->id) selected @endif>{{ $class->name }}</option>
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

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Subjects:</label>
                                                <select name="subject_id" id="subject_id" class="form-control @error('subject_id') is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    @if(count($assignedSubjects) > 0)
                                                    @foreach($assignedSubjects as $assignedSubject)
                                                    <option value="{{ $assignedSubject['id'] }}" @if($syllabus->subject_id == $assignedSubject['id']) selected @endif>{{ $assignedSubject['name'] }}</option>
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
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Upload Syllabus:</label>
                                                <input type="file" class="form-control @error('media') is-invalid @enderror" id="media"
                                                    name="media" value="{{ old('media') }}">
                                            </div>
                                            @error('media')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Description:</label>
                                                <textarea name="description" id="summernote" class="form-control @error('description') is-invalid @enderror" cols="30" rows="6">{{ $syllabus->description }}</textarea>
                                            </div>
                                            @error('description')
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
