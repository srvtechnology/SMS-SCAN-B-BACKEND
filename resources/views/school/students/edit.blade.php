@extends('school.layouts.main')
@section('page_title', 'Students')
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

        .custom_lable {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
        }

        .custom_radio_input {
            border-radius: 50% !important;
            width: 25px !important;
            height: 30px !important;
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
                            <a href="{{ route('school.students') }}">Students</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Student</li>
                    </ol>
                </nav>
                <a href="{{ route('school.teachers') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-11 col-sm-10 col-md-12 col-lg-12 col-xl-12 text-center mt-3 mb-2">
                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3 p-5">
                            <h2 id="heading">Edit Student</h2>
                            <p>Fill all form field to go to next step</p>
                            <form id="msform" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $studentData->id }}">
                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="active" id="personal"><strong>Personal</strong></li>
                                    <li id="class_assign"><strong>Class Assign</strong></li>
                                    <li id="background"><strong>Background</strong></li>
                                    <li id="fee_structure"><strong>Fee Structure</strong></li>
                                    <li id="parents"><strong>Parents</strong></li>
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
                                                    <img src="{{ getStudentImage($studentData->id) }}" alt="user-avatar"
                                                        class="d-block rounded" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                    <div class="button-wrapper">
                                                        <label for="image" class="btn btn-primary me-2 mb-4"
                                                            tabindex="0">
                                                            <span class="d-none d-sm-block">Upload your photo</span>
                                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                                            <input type="file" name="image" id="image"
                                                                class="account-file-input" hidden
                                                                accept="image/png, image/jpeg" />
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
                                                        class="form-control" placeholder="First Name"
                                                        value="{{ $studentData->first_name }}">
                                                    <span class="text-danger d-none" id="first_name_error">First Name is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Last Name *</label>
                                                    <input type="text" name="last_name" id="last_name"
                                                        class="form-control" placeholder="Last Name"
                                                        value="{{ $studentData->last_name }}">
                                                    <span class="text-danger d-none" id="last_name_error">Last Name is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Email*</label>
                                                    <input type="email" name="email" id="email" class="form-control"
                                                        placeholder="Email" value="{{ $studentData->email }}">
                                                    <span class="text-danger d-none" id="email_error">Email is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Phone*</label>
                                                    <input type="phone" name="phone" id="phone"
                                                        class="form-control" placeholder="Phone"
                                                        value="{{ $studentData->phone }}">
                                                    <span class="text-danger d-none" id="phone_error">Phone is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Gender*</label>
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="male"
                                                            @if ($studentData->gender == 'male') selected @endif>Male</option>
                                                        <option value="female"
                                                            @if ($studentData->gender == 'female') selected @endif>Female
                                                        </option>
                                                    </select>
                                                    <span class="text-danger d-none" id="gender_error">Gender is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">DOB*</label>
                                                    <input type="date" name="dob" id="dob"
                                                        class="form-control" value="{{ $studentData->dob }}">
                                                    <span class="text-danger d-none" id="dob_error">DOB is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Admission Date *</label>
                                                    <input type="date" name="admission_date" id="admission_date"
                                                        class="form-control" value="{{ $studentData->admission_date }}">
                                                    <span class="text-danger d-none" id="admission_date_error">Admission
                                                        Date is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12  mb-3">
                                                <div class="form-group">
                                                    <label for="">Temporary Address*</label>
                                                    <input type="text" name="address" id="address"
                                                        class="form-control" placeholder="Temporary Address"
                                                        value="{{ $studentData->address }}">
                                                    <span class="text-danger d-none" id="address_error">Temporary Address
                                                        is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12  mb-3">
                                                <div class="form-group">
                                                    <label for="">Permanent Address*</label>
                                                    <input type="text" name="permanent_address" id="permanent_address"
                                                        class="form-control" placeholder="Permanent Address"
                                                        value="{{ $studentData->permanent_address }}">
                                                    <span class="text-danger d-none"
                                                        id="permanent_address_error">Permanent Address is
                                                        required</span>
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
                                                <h2 class="fs-title">Class Assign:</h2>
                                            </div>
                                        </div>
                                        <div id="   ">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Class *</label>
                                                        <select name="class_id" id="class_id" class="form-control">
                                                            <option value="">Select</option>
                                                            @if (count($classes) > 0)
                                                                @foreach ($classes as $class)
                                                                    <option value="{{ $class->id }}"
                                                                        @if ($class->id == $studentData->assignClasses[0]->class->id) selected @endif>
                                                                        {{ $class->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <span class="text-danger d-none" id="class_id_error">Class is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Section *</label>
                                                        <select name="section_id" id="section_id" class="form-control">
                                                            <option value="">Select</option>
                                                            @if (count($sections) > 0)
                                                                @foreach ($sections as $section)
                                                                    <option value="{{ $section->id }}"
                                                                        @if ($section->id == $studentData->assignClasses[0]->section->id) selected @endif>
                                                                        {{ $section->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <span class="text-danger d-none" id="section_id_error">Section is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Subjects</label>
                                                        <ul id="subjectShowSection">
                                                            @if (count($studentData->assignClasses[0]->class->assignedSubjects) > 0)
                                                                @foreach ($studentData->assignClasses[0]->class->assignedSubjects as $assignSubject)
                                                                    <li>{{ $assignSubject->subject->name }}</li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button step2Btn"
                                        value="Next" />
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Background Information:</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-3">
                                                    <label for="">School Name</label>
                                                    <input type="text" name="bg_school_name" id="bg_school_name"
                                                        class="form-control" placeholder="School Name"
                                                        value="{{ $studentData->bg_school_name }}">
                                                    <span class="text-danger d-none" id="bg_school_name_error">School Name
                                                        is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Class Name *</label>
                                                    <input type="text" name="bg_class_name" id="bg_class_name"
                                                        class="form-control" placeholder="Last Name"
                                                        value="{{ $studentData->bg_class_name }}">
                                                    <span class="text-danger d-none" id="bg_class_name_error">Class Name
                                                        is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">School Leave Certificate</label>
                                                    <input type="file" name="school_leave_certificate"
                                                        id="school_leave_certificate" class="form-control">
                                                    <span class="text-danger d-none"
                                                        id="school_leave_certificate_error">School Leave Certificate is
                                                        required</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Mark Sheet</label>
                                                    <input type="file" name="mark_sheet" id="mark_sheet"
                                                        class="form-control">
                                                    <span class="text-danger d-none" id="mark_sheet_error">Mark Sheet is
                                                        required</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button step3Btn"
                                        value="Next" />
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Fee Structure:</h2>
                                            </div>
                                        </div>
                                        <div id="   ">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Fee *</label>
                                                        <select name="fee" id="fee" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="monthly"
                                                                @if ($studentData->fees->fee == 'monthly') selected @endif>Monthly
                                                            </option>
                                                            <option value="quarterly"
                                                                @if ($studentData->fees->fee == 'quarterly') selected @endif>Quarterly
                                                            </option>
                                                            <option value="yearly"
                                                                @if ($studentData->fees->fee == 'yearly') selected @endif>Yearly
                                                            </option>
                                                        </select>
                                                        <span class="text-danger d-none" id="fee_error">Fee is
                                                            required</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="">Fee Amount*</label>
                                                        <input type="number" id="fee_amount" class="form-control"
                                                            name="fee_amount" value="{{ $studentData->fees->amount }}">
                                                        <span class="text-danger d-none" id="fee_amount_error">Fee Amount
                                                            is
                                                            required</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button step4Btn"
                                        value="Next" />
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Parents Structure:</h2>
                                            </div>
                                        </div>
                                        <div id="   ">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-3">
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label custom_lable">
                                                                <input type="radio"
                                                                    class="form-check-input custom_radio_input"
                                                                    name="parent_type" value="new_parent"
                                                                    @if ($studentData->parent_type == 'new_parent') checked @endif><span>New
                                                                    Parent</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label custom_lable">
                                                                <input type="radio"
                                                                    class="form-check-input custom_radio_input"
                                                                    name="parent_type" value="sibling"
                                                                    @if ($studentData->parent_type == 'sibling') checked @endif><span>Sibling</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label custom_lable">
                                                                <input type="radio"
                                                                    class="form-check-input custom_radio_input"
                                                                    name="parent_type" value="staff"
                                                                    @if ($studentData->parent_type == 'staff') checked @endif><span>Staff</span>
                                                            </label>
                                                        </div>
                                                        <span class="text-danger d-none" id="parent_type_error">Parent
                                                            Type is
                                                            required</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="SiblingParentRadioSection" class="d-none">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group mb-3">
                                                            <label for="">Select Student *</label>
                                                            <select name="parent_student_id" id="parent_student_id"
                                                                class="form-control">
                                                                <option value="">Select</option>
                                                                @if (count($students) > 0)
                                                                    @foreach ($students as $student)
                                                                        <option value="{{ $student->id }}"
                                                                            @if ($studentData->sibling_id == $student->id) selected @endif>
                                                                            {{ $student->first_name }}
                                                                            {{ $student->last_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger d-none"
                                                                id="parent_student_id_error">Student is
                                                                required</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="StaffParentRadioSection" class="d-none">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group mb-3">
                                                            <label for="">Select Staff *</label>
                                                            <select name="parent_staff_id" id="parent_staff_id"
                                                                class="form-control">
                                                                <option value="">Select</option>
                                                                @if (count($staffs) > 0)
                                                                    @foreach ($staffs as $staff)
                                                                        <option value="{{ $staff->id }}"
                                                                            @if ($studentData->sibling_id == $staff->id) selected @endif>
                                                                            {{ $staff->first_name }}
                                                                            {{ $staff->last_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger d-none"
                                                                id="parent_staff_id_error">Staff is
                                                                required</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="NewParentRadioSection">
                                                <div class="row">
                                                    <div class="col-md-6 col-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="">Name *</label>
                                                            <input type="text" name="parent_name" id="parent_name"
                                                                class="form-control" placeholder="Name"
                                                                value="{{ $studentData->parent->name }}">
                                                            <span class="text-danger d-none" id="parent_name_error">Name
                                                                is
                                                                required</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="">Email *</label>
                                                            <input type="email" name="parent_email" id="parent_email"
                                                                class="form-control" placeholder="Email"
                                                                value="{{ $studentData->parent->email }}">
                                                            <span class="text-danger d-none" id="parent_email_error">Email
                                                                is
                                                                required</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="">Phone *</label>
                                                            <input type="phone" name="parent_phone" id="parent_phone"
                                                                class="form-control" placeholder="Phone"
                                                                value="{{ $studentData->parent->phone }}">
                                                            <span class="text-danger d-none" id="parent_phone_error">Phone
                                                                is
                                                                required</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="">Emergency Phone *</label>
                                                            <input type="phone" name="emergency_phone"
                                                                id="emergency_phone" class="form-control"
                                                                placeholder="Emergency Phone"
                                                                value="{{ $studentData->parent->emergency_phone }}">
                                                            <span class="text-danger d-none"
                                                                id="emergency_phone_error">Phone is
                                                                required</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <button type="submit" name="next"
                                        class="next action-button finalStep">Submit</button>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
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
                    const dob = $("#dob").val();
                    const address = $("#address").val();
                    const image = $("#image").val();
                    const permanent_address = $("#permanent_address").val();
                    const admission_date = $("#admission_date").val();

                    const fields = [
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'gender',
                        'dob',
                        'address',
                        'permanent_address',
                        'admission_date'
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

                $('#class_id').on('change', function() {
                    var selectedValue = $(this).val();
                    var class_url = "{{ route('school.students.getSectionByClass', ['id' => ':param']) }}";
                    class_url = class_url.replace(':param', selectedValue);
                    $.ajax({
                        url: class_url,
                        method: 'GET',
                        success: function(response) {
                            $('#section_id').html('');
                            $('#section_id').append(
                                '<option value="" selected disable>Select</option>');
                            $('#subjectShowSection').html('');
                            $.each(response.sections, function(index, data) {
                                $('#section_id').append('<option value="' + data.id + '">' +
                                    data.name + '</option>');
                            });
                            $.each(response.subjects, function(index, subject) {
                                $('#subjectShowSection').append('<li>' + subject.name +
                                    '</li>');
                            });
                        },
                        error: function(xhr, status, error) {
                            $('#section_id').html('');
                            $('#section_id').append('<option selected disable>Select</option>');
                            $('#subjectShowSection').html('');
                            console.log(error);
                        }
                    });
                });

                function emptyParentFields() {
                    $("#parent_name").val('');
                    $("#parent_email").val('');
                    $("#parent_phone").val('');
                    $("#emergency_phone").val('');
                }

                @if ($studentData->parent_type == 'sibling')
                    var parent_student_id = '{{ $studentData->sibling_id }}';
                    parentStudentID(parent_student_id);
                @endif
                $('#parent_student_id').on('change', function() {
                    var selectedValue = $(this).val();
                    parentStudentID(selectedValue);
                });

                function parentStudentID(selectedValue) {
                    var class_url = "{{ route('school.students.getParentByStudent', ['id' => ':param']) }}";
                    class_url = class_url.replace(':param', selectedValue);
                    $.ajax({
                        url: class_url,
                        method: 'GET',
                        success: function(response) {
                            $("#parent_name").val(response.name);
                            $("#parent_email").val(response.email);
                            $("#parent_phone").val(response.phone);
                            $("#emergency_phone").val(response.emergency_phone);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }

                @if ($studentData->parent_type == 'staff')
                    var parent_staff_id = '{{ $studentData->sibling_id }}';
                    parentStaffID(parent_staff_id);
                @endif
                $('#parent_staff_id').on('change', function() {
                    var selectedValue = $(this).val();
                    parentStaffID(selectedValue);
                });

                function parentStaffID(selectedValue) {
                    var class_url = "{{ route('school.students.getStaffInfo', ['id' => ':param']) }}";
                    class_url = class_url.replace(':param', selectedValue);
                    $.ajax({
                        url: class_url,
                        method: 'GET',
                        success: function(response) {
                            $("#parent_name").val(response.name);
                            $("#parent_email").val(response.email);
                            $("#parent_phone").val(response.phone);
                            $("#emergency_phone").val(response.emergency_phone);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
                var parent_type = '{{ $studentData->parent_type }}';
                checkParentType(parent_type);

                $('input[name="parent_type"]').on("change", function() {
                    var selectedValue = $(this).val();
                    checkParentType(selectedValue);
                });



                $('.step2Btn').click(function(e) {
                    var class_id = $("#class_id").val();
                    var section_id = $("#section_id").val();

                    if (class_id === "") {
                        $("#class_id_error").removeClass("d-none");
                    } else {
                        $("#class_id_error").addClass("d-none");
                    }

                    if (section_id === "") {
                        $("#section_id_error").removeClass("d-none");
                    } else {
                        $("#section_id_error").addClass("d-none");
                    }
                    if (class_id != "" && section_id != "") {

                        const current_fs = $(this).parent();
                        const next_fs = $(this).parent().next();
                        nextSection(current_fs, next_fs);
                    } else {
                        e.preventDefault();
                    }
                });


                $(".step3Btn").click(function() {
                    const current_fs = $(this).parent();
                    const next_fs = $(this).parent().next();
                    nextSection(current_fs, next_fs);
                });

                $(".step4Btn").click(function() {
                    var fee = $("#fee").val();
                    var fee_amount = $("#fee_amount").val();

                    if (fee === "") {
                        $("#fee_error").removeClass("d-none");
                    } else {
                        $("#fee_error").addClass("d-none");
                    }

                    if (fee_amount === "") {
                        $("#fee_amount_error").removeClass("d-none");
                    } else {
                        $("#fee_amount_error").addClass("d-none");
                    }
                    if (fee != "" && fee_amount != "") {

                        const current_fs = $(this).parent();
                        const next_fs = $(this).parent().next();
                        nextSection(current_fs, next_fs);
                    } else {
                        e.preventDefault();
                    }

                });

                $(".finalStep").click(function(e) {
                    var parent_type = $("input[name='parent_type']:checked").val();

                    var parent_name = $("#parent_name").val();
                    var parent_email = $("#parent_email").val();
                    var parent_phone = $("#parent_phone").val();
                    var emergency_phone = $("#emergency_phone").val();

                    var fields = ["parent_name", "parent_email", "parent_phone", "emergency_phone"];
                    fields.forEach(function(field) {
                        if ($("#" + field).val() == "") {
                            $("#" + field + "_error").removeClass("d-none");
                        } else {
                            $("#" + field + "_error").addClass("d-none");
                        }
                    });

                    var isEmpty = Boolean(parent_name != "" && parent_email != "" && parent_phone != "" &&
                        emergency_phone != "")
                    if (parent_type == "sibling") {
                        var finalStep = $("#parent_student_id").val();
                        if (finalStep == "") {
                            $("#parent_student_id_error").removeClass("d-none");
                        } else {
                            $("#parent_student_id_error").addClass("d-none");
                        }
                    }
                    if (parent_type == "staff") {
                        var finalStep = $("#parent_staff_id").val();
                        if (finalStep == "") {
                            $("#parent_staff_id_error").removeClass("d-none");
                        } else {
                            $("#parent_staff_id_error").addClass("d-none");
                        }
                    } else {
                        var finalStep = '0';
                    }
                    if (isEmpty == true && finalStep != "") {
                        loader();
                        var form = document.getElementById('msform');
                        var formData = new FormData(form);
                        $.ajax({
                            url: '{{ route('school.students.update') }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                window.location.href = '{{ route('school.students') }}';
                            },
                            error: function(xhr, status, error) {
                                console.error('Form submission failed');
                            }
                        });
                    } else {
                        e.preventDefault();
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

                function checkParentType(selectedValue) {
                    emptyParentFields();
                    $("#StaffParentRadioSection").addClass('d-none');
                    $("#SiblingParentRadioSection").addClass('d-none');
                    if (selectedValue == 'staff') {
                        $('#StaffParentRadioSection').removeClass('d-none');
                        @if ($studentData->parent_type == 'staff')
                            var parent_staff_id = '{{ $studentData->sibling_id }}';
                            parentStaffID(parent_staff_id);
                        @endif
                    } else if (selectedValue == "sibling") {
                        $('#SiblingParentRadioSection').removeClass('d-none');
                        @if ($studentData->parent_type == 'sibling')
                            var parent_student_id = '{{ $studentData->sibling_id }}';
                            parentStudentID(parent_student_id);
                        @endif
                    } else {
                        if (selectedValue == 'new_parent') {
                            $("#parent_name").val('{{ $studentData->parent->name }}');
                            $("#parent_email").val('{{ $studentData->parent->email }}');
                            $("#parent_phone").val('{{ $studentData->parent->phone }}');
                            $("#emergency_phone").val('{{ $studentData->parent->emergency_phone }}');
                        }
                    }
                }

                function setProgressBar(curStep) {
                    var percent = parseFloat(100 / steps) * curStep;
                    percent = percent.toFixed();
                    $(".progress-bar")
                        .css("width", percent + "%")
                }

                $(".submit").click(function() {
                    return false;
                });

                function nextSection(current_fs, next_fs) {
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
