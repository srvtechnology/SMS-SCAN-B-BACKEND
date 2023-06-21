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
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <x-alert></x-alert>
                                <form id="myForm" action="{{ route("school.timetable.periods.update") }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $period->id }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Class:</label>
                                                <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    @if(count($classes))
                                                    @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" @if($period->class_id == $class->id) selected @endif>{{ $class->name }}</option>
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
                                                <label for="field1">No of Periods:</label>
                                                <input type="number" min="1" class="form-control @error('no_of_periods') is-invalid @enderror" id="no_of_periods"
                                                    name="no_of_periods" value="{{ old('no_of_periods',$period->no_of_periods) }}">
                                            </div>
                                            @error('no_of_periods')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="field1">Duration:</label>
                                                <input type="number" min="0" class="form-control @error('duration') is-invalid @enderror" id="duration"
                                                    name="duration" value="{{ old('duration',$period->duration) }}">
                                            </div>
                                            @error('duration')
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
            var getClassID = '{{ $period->class_id }}';
            $.ajax({
                url: '{{ url("school/study-material/get-subjects-byclass/") }}'+'/'+getClassID,
                type: 'GET',
                success: function(response) {
                    const subject_id = '{{ $period->subject_id }}';
                    $("#subject_id").html('');
                    $("#subject_id").append('<option value="">Select</option>');
                    $(response).each(function(index, element) {
                        if(element.id == subject_id)
                        {
                            var selected = "selected";
                        }
                        $("#subject_id").append('<option value="'+element.id+'" '+selected+'>'+element.name+'</option>');
                    });
                },
                error: function(xhr, status, error) {
                console.error('failed');
                }
            });

            $("#class_id").on("change", function(){
                var class_id = $(this).val();
                getSectionsByClass(class_id);
            });

            $(".submitBtn").on("click", function(){
                loader();
            });

            function getSectionsByClass(class_id){
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
            }
        </script>
    @endpush
@endsection
