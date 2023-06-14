@extends('school.layouts.main')
@section('page_title', 'Schools')
@section('page_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/step_form.css') }}">
@endsection
@section('content')
    <style>
        .custom-section {
            height: 150px;
            overflow: scroll;
            width: 20%;
            overflow-x: hidden;
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
                            <a href="{{ route('school.teachers') }}">Teachers</a>
                        </li>
                        <li class="breadcrumb-item active">Create Teacher</li>
                    </ol>
                </nav>
                <a href="{{ route('school.teachers') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-11 col-sm-10 col-md-12 col-lg-12 col-xl-12 text-center mt-3 mb-2">
                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3 p-5">
                            <h2 id="heading">Create Teacher</h2>
                            <p>Fill all form field to go to next step</p>
                            <form id="msform" enctype="multipart/form-data">
                                @csrf
                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="active" id="personal"><strong>Personal</strong></li>
                                    <li id="qualification"><strong>Qualification</strong></li>
                                    <li id="experience"><strong>Experience</strong></li>
                                    <li id="class_assign"><strong>Class Assign</strong></li>
                                    <li id="subject_assign"><strong>Subject Assign</strong></li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div> <br> <!-- fieldsets -->
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Personal Information:</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                                    <img src="{{ getUserImage() }}" alt="user-avatar" class="d-block rounded" height="100"
                                                        width="100" id="uploadedAvatar" />
                                                    <div class="button-wrapper">
                                                        <label for="image" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                            <span class="d-none d-sm-block">Upload your photo</span>
                                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                                            <input type="file" name="image" id="image"
                                                                class="account-file-input" hidden accept="image/png, image/jpeg" />
                                                        </label>

                                                        <p class="text-muted mb-0">Allowed JPG or PNG.</p>
                                                    </div>
                                                </div>
                                                <span class="text-danger d-none" id="image_error">Image is
                                                    required</span>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-3">
                                                    <label for="">First Name *</label>
                                                    <input type="text" name="first_name" id="first_name"
                                                        class="form-control" placeholder="First Name">
                                                    <span class="text-danger d-none" id="first_name_error">First Name is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Last Name *</label>
                                                    <input type="text" name="last_name" id="last_name"
                                                        class="form-control" placeholder="Last Name">
                                                    <span class="text-danger d-none" id="last_name_error">Last Name is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Email*</label>
                                                    <input type="email" name="email" id="email" class="form-control"
                                                        placeholder="Email">
                                                    <span class="text-danger d-none" id="email_error">Email is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Phone*</label>
                                                    <input type="phone" name="phone" id="phone" class="form-control"
                                                        placeholder="Phone">
                                                    <span class="text-danger d-none" id="phone_error">Phone is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Gender*</label>
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="male" selected>Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                    <span class="text-danger d-none" id="gender_error">Gender is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Designation*</label>
                                                    <select name="designation_id" id="type" class="form-control">
                                                        @if(count($designations) > 0)
                                                        @foreach($designations as $designation)
                                                        <option value="{{ $designation->id }}" selected>{{ $designation->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger d-none" id="type_error">Type is required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12  mb-3">
                                                <div class="form-group">
                                                    <label for="">Address*</label>
                                                    <input type="address" name="address" id="address"
                                                        class="form-control" placeholder="Address">
                                                    <span class="text-danger d-none" id="address_error">Address is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Salary *</label>
                                                    <input type="text" name="salary" id="salary" class="form-control"
                                                        placeholder="Salary">
                                                    <span class="text-danger d-none" id="salary_error">Expected Salary is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Joining Date *</label>
                                                    <input type="date" name="joining_date" id="joining_date" class="form-control"
                                                        >
                                                    <span class="text-danger d-none" id="joining_date_error">Joining Date is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Additional Documents </label>
                                                    <input type="file" name="documents[]" id="documents" class="form-control"
                                                        multiple>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Facebook Profile</label>
                                                    <input type="text" name="fb_profile" id="fb_profile" class="form-control"
                                                        placeholder="Facebook Profile">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Instagram Profile</label>
                                                    <input type="text" name="insta_profile" id="insta_profile" class="form-control"
                                                        placeholder="Instagram Profile">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">LinkedIn Profile</label>
                                                    <input type="text" name="linkedIn_profile" id="linkedIn_profile" class="form-control"
                                                        placeholder="LinkedIn Profile">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Twitter Profile</label>
                                                    <input type="text" name="twitter_profile" id="twitter_profile" class="form-control"
                                                        placeholder="Twitter Profile">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button step1Btn"
                                        value="Next" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Qualification Information:</h2>
                                            </div>
                                        </div>
                                        <div id="dynamicFieldsContainer">
                                            <div class="row">
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Year *</label>
                                                        <input type="text" name="year[]" id="year"
                                                            class="form-control" placeholder="Year">
                                                        <span class="text-danger d-none" id="year_error">Year is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Education *</label>
                                                        <input type="text" name="education[]" id="education"
                                                            class="form-control" placeholder="Education">
                                                        <span class="text-danger d-none" id="education_error">Education is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Instituation *</label>
                                                        <input type="text" name="instituation[]" id="instituation"
                                                            class="form-control" placeholder="Instituation">
                                                        <span class="text-danger d-none" id="instituation_error">Instituation is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group mb-3">
                                                        <button type="button" class="btn btn-primary mt-4" id="addField"><i class='bx bx-plus-medical'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button step2Btn" value="Next" />
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Experience Information:</h2>
                                            </div>
                                        </div>
                                        <div id="dynamicFieldsContainerExperience">
                                            <div class="row">
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">From *</label>
                                                        <input type="date" name="from_date[]" id="from_date"
                                                            class="form-control" placeholder="Year">
                                                        <span class="text-danger d-none" id="from_date_error">From is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">To *</label>
                                                        <input type="date" name="to_date[]" id="to_date"
                                                            class="form-control" placeholder="Year">
                                                        <span class="text-danger d-none" id="to_date_error">To is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Instituation *</label>
                                                        <input type="text" name="exp_instituation[]" id="exp_instituation"
                                                            class="form-control" placeholder="Instituation">
                                                        <span class="text-danger d-none" id="exp_instituation_error">Instituation is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group mb-3">
                                                        <button type="button" class="btn btn-primary mt-4" id="addExperienceField"><i class='bx bx-plus-medical'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button step3Btn" value="Next" />
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Class Assign Information:</h2>
                                            </div>
                                        </div>
                                        <div id="">
                                            <span class="text-danger d-none" id="section_id_error">Please select at least one checkbox.</span>
                                            <div class="row">
                                                @if(count($classes) > 0)
                                                @foreach($classes as $class)
                                                <div class="col-md-3 col-3 mb-4">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label style="display: flex; align-items: center; justify-content: start; gap: 0.3rem;">
                                                                <input type="checkbox" name="class_id[]" value="{{ $class->id }}" style="width: 20px; height: 20px;" class="main-checkbox"><span>{{ $class->name }}</span>
                                                            </label>
                                                            @if(count($class->assignedSections) > 0)
                                                                <div class="checkbox-list">
                                                                    @foreach($class->assignedSections as $asssignedSection)
                                                                        <label style="display: flex; align-items: center; justify-content: start; gap: 0.3rem;">
                                                                            <input type="checkbox" name="section_id[]" value="{{ $class->id }},{{ $asssignedSection->section->id }}" style="width: 15px; height: 15px;" class="sub-checkbox checkbox{{ $class->id }}"><span>{{ $asssignedSection->section->name }}</span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button step4Btn" value="Next" />
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Subject Assign Information:</h2>
                                            </div>
                                        </div>
                                        <div id="">
                                            <span class="text-danger d-none" id="subject_id_error">Please select at least one checkbox.</span>
                                            <div class="row">
                                                @if(count($subjects) > 0)
                                                @foreach($subjects as $subject)
                                                <div class="col-md-3 col-6 mb-4">
                                                    <div class="row">
                                                        <div class="row">
                                                            <label style="display: flex;align-items: center;justify-content: start;gap: 0.3rem;">
                                                                <input type="checkbox" name="subject_id[]" value="{{ $subject->id }}" style="width: 15px; height: 15px;"> <span>{{ $subject->name }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="next" class="next action-button finalStep">Submit</button>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                </fieldset>
                            </form>
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
            $(document).ready(function() {

                var current_fs, next_fs, previous_fs; //fieldsets
                var opacity;
                var current = 1;
                var steps = $("fieldset").length;
                setProgressBar(current);

                $('.main-checkbox').change(function() {
                    var classId = $(this).val();
                    $('.checkbox' + classId).prop('checked', this.checked);
                });

                $(".step1Btn").click(function() {
                    const first_name = $("#first_name").val();
                    const last_name = $("#last_name").val();
                    const email = $("#email").val();
                    const phone = $("#phone").val();
                    const gender = $("#gender").val();
                    const type = $("#type").val();
                    const address = $("#address").val();
                    const image = $("#image").val();

                    const fields = [
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'gender',
                        'type',
                        'address',
                        'image',
                        'salary',
                        'joining_date'
                    ];

                    let isValid = true;

                    for (const field of fields) {
                        const value = $("#" + field).val();
                        if (value === "") {
                            $("#" + field + "_error").removeClass("d-none");
                            isValid = false;
                        } else {
                            $("#" + field + "_error").addClass("d-none");
                        }
                    }

                    if (isValid) {
                        const current_fs = $(this).parent();
                        const next_fs = $(this).parent().next();
                        nextSection(current_fs, next_fs);
                    }
                });


                $('#addField').click(function() {
                    var newField =
                        `<div class="row">
                            <div class="col-md-2 col-12">
                                <div class="form-group mb-3">
                                    <label for="">Year *</label>
                                    <input type="text" name="year[]" class="form-control" placeholder="Year">
                                    <span class="text-danger d-none year_error">Year is required</span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group mb-3">
                                    <label for="">Education *</label>
                                    <input type="text" name="education[]" class="form-control" placeholder="Education">
                                    <span class="text-danger d-none education_error">Education is required</span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group mb-3">
                                    <label for="">Institution *</label>
                                    <input type="text" name="instituation[]" class="form-control" placeholder="Instituation">
                                    <span class="text-danger d-none instituation_error">instituation is required</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group mb-3">
                                    <button type="button" class="btn btn-danger mt-4 deleteRow">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        </div>`;

                    $('#dynamicFieldsContainer').append(newField);
                });

                $(document).on('click', '.deleteRow', function() {
                    $(this).closest('.row').remove();
                });

                $('.step2Btn').click(function(e) {
                    var emptyFields = false;

                    $('#dynamicFieldsContainer input[type="text"]').each(function() {
                        if ($(this).val() === '') {
                            emptyFields = true;
                            $(this).siblings('.text-danger').removeClass('d-none');
                        } else {
                            $(this).siblings('.text-danger').addClass('d-none');
                        }
                    });

                    if (emptyFields) {
                        e.preventDefault();
                    }
                    else
                    {
                        const current_fs = $(this).parent();
                        const next_fs = $(this).parent().next();
                        nextSection(current_fs, next_fs);
                    }
                });


                $('#addExperienceField').click(function() {
                    var newField =
                        `<div class="row">
                            <div class="col-md-2 col-12">
                                <div class="form-group mb-3">
                                    <label for="">From *</label>
                                    <input type="date" name="from_date[]" id="from_date"
                                        class="form-control" placeholder="Year">
                                    <span class="text-danger d-none" id="from_date_error">From is
                                        required</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group mb-3">
                                    <label for="">To *</label>
                                    <input type="date" name="to_date[]" id="to_date"
                                        class="form-control" placeholder="Year">
                                    <span class="text-danger d-none" id="to_date_error">To is
                                        required</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <label for="">Institution *</label>
                                    <input type="text" name="exp_instituation[]" class="form-control" placeholder="Institution">
                                    <span class="text-danger d-none exp_instituation_error">Institution is required</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group mb-3">
                                    <button type="button" class="btn btn-danger mt-4 deleteExperienceRow">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        </div>`;

                    $('#dynamicFieldsContainerExperience').append(newField);
                });

                $(document).on('click', '.deleteExperienceRow', function() {
                    $(this).closest('.row').remove();
                });

                $(".step3Btn").click(function() {
                    const current_fs = $(this).parent();
                    const next_fs = $(this).parent().next();
                    nextSection(current_fs, next_fs);
                });

                $(".step4Btn").click(function() {
                    var sectionId = $('input[name="section_id[]"]:checked').length;
                    if(sectionId > 0) {
                        $("#section_id_error").addClass('d-none');
                        const current_fs = $(this).parent();
                        const next_fs = $(this).parent().next();
                        nextSection(current_fs, next_fs);
                    }
                    else
                    {
                        $("#section_id_error").removeClass('d-none');
                    }
                });

                $(".finalStep").click(function(e) {
                    var subjectId = $('input[name="subject_id[]"]:checked').length;
                    e.preventDefault();
                    if(subjectId > 0) {
                        $("#subject_id_error").addClass('d-none');
                        var form = document.getElementById('msform');
                        var formData = new FormData(form);
                        //for(let [key, value] of formData){
                            //console.log(key + " : " + value);
                        //}
                        $.ajax({
                            url: '{{ route("school.teachers.store") }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                            window.location.href = '{{ route("school.teachers") }}';
                            },
                            error: function(xhr, status, error) {
                            console.error('Form submission failed');
                            }
                        });
                    }
                    else
                    {
                        $("#subject_id_error").removeClass('d-none');
                    }

                });

                $(".previous").click(function() {

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //Remove class active
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();

                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now) {
                            // for making fielset appear animation
                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            previous_fs.css({
                                'opacity': opacity
                            });
                        },
                        duration: 500
                    });
                    setProgressBar(--current);
                });

                function setProgressBar(curStep) {
                    var percent = parseFloat(100 / steps) * curStep;
                    percent = percent.toFixed();
                    $(".progress-bar")
                        .css("width", percent + "%")
                }

                $(".submit").click(function() {
                    return false;
                });

                function nextSection(current_fs,next_fs)
                {
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                        next_fs.show();
                        current_fs.animate({
                            opacity: 0
                        }, {
                            step: function(now) {
                                opacity = 1 - now;
                                current_fs.css({
                                    display: "none",
                                    position: "relative"
                                });
                                next_fs.css({
                                    opacity: opacity
                                });
                            },
                            duration: 500
                        });

                        setProgressBar(++current);
                }

            });


        </script>
    @endpush
@endsection
