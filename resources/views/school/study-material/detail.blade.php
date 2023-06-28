@extends('school.layouts.main')
@section('page_title', 'Student Material')
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
                            <a href="{{ route('school.studyMaterial.view-content') }}">Student Material</a>
                        </li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
                <a href="{{ route('school.studyMaterial.view-content') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field1">Title:</label>
                                            <h4>{{ $study_material->title }}</h4>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Type:</label>
                                            <h4>{{ $study_material->type }}</h4>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Class:</label>
                                            <h4>{{ $study_material->class->name }}</h4>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Subjects:</label>
                                            <h4>{{ $study_material->subject->name }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Date:</label>
                                            <h4>{{ date("d/m/Y",strtotime($study_material->date)) }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Description:</label>
                                            <h6>{{ $study_material->description }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label for="field1">Media:</label><br>
                                            <a href="{{ asset("uploads/schools/study-material/".$study_material->media) }}" class="" download><i class='bx bx-file icons'></i></a>&nbsp;
                                        </div>
                                    </div>
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

        <script>
            var getClassID = '{{ $study_material->class_id }}';
            $.ajax({
                url: '{{ url("school/study-material/get-subjects-byclass/") }}'+'/'+getClassID,
                type: 'GET',
                success: function(response) {
                    const subject_id = '{{ $study_material->subject_id }}';
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
