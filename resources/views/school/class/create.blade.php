@extends('school.layouts.main')
@section('page_title', 'Schools')
@section('content')
<style>
    .custom-section{
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
                            <a href="{{ route('school.class') }}">Class</a>
                        </li>
                        <li class="breadcrumb-item active">Create Class</li>
                    </ol>
                </nav>
                <a href="{{ route('school.class') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form id="myForm" action="{{ route('school.class.store') }}" method="POST">
                                    @csrf
                                    <div id="fieldContainer">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="field1">Name:</label>
                                                    <input type="text" class="form-control" id="name" name="name1[]">
                                                    <div class="nameError text-danger error-message"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">

                                                <div class="form-group">
                                                    <label for="field1">Sections:</label>
                                                    <div class="sectionError text-danger error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                    <select class="select2_custom form-control section_id1" id="section_id1" name="section_id1[]" multiple="multiple" onfocus="getSelectAllOption(event)">
                                                        @if(count($sections) > 0)
                                                        @foreach($sections as $section)
                                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                            @endforeach
                                                        @endif
                                                      </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">

                                                <div class="form-group">
                                                    <label for="field1">Subjects:</label>
                                                    <div class="subjectError text-danger error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                    <select class="select2_custom form-control" name="subject_id1[]" multiple="multiple">
                                                        @if(count($subjects) > 0)
                                                        @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                            @endforeach
                                                        @endif
                                                      </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <button type="button" class="btn btn-primary mt-2 addField" id="addField"><i class='bx bx-plus-medical'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2" id="submitBtn">Submit</button>
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
    {{--  <script>
        var $eventSelect = $(".select2_custom_section");
        $eventSelect.select2();
        $eventSelect.on("select2:close", function (e) {
            getSelectAllOption(e);
         });

        function getSelectAllOption(event)
        {
            var classList = event.currentTarget.classList;
            var className = "";
            classList.forEach(function(classItem) {
                if (classItem.startsWith("section_id")) {
                    className = classItem;
                }
            });

            var counter = className.replace(/^\D+/g, '');
            var class_id = $("." + className).val();
            handleSelectAllOption(className, 'all');
        }
        function handleSelectAllOption(selectClass, allValue) {
            alert(selectClass);
            var className = $("."+ selectClass);
            var classValue = className.val();
            if (classValue != null && classValue.includes(allValue)) {

                className.find('option:not([value="' + allValue + '"])').prop('selected', true);
                className.find('option[value="' + allValue + '"]').prop('selected', false);
            } else {
                className.find('option[value="' + allValue + '"]').prop('selected', false);
            }
        }


    </script>  --}}
    <script>
        var fieldIndex = 2; // Initial field index

    // Add new field
    $('.addField').on('click', function() {
      var newField =
        `<div class="row">
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="field1">Name:</label>
                    <input type="text" class="form-control" id="name" name="name${fieldIndex}[]">
                    <div class="nameError text-danger error-message"></div>
                </div>
            </div>
            <div class="col-md-3 mb-3">

                <div class="form-group">
                    <label for="field1">Sections:</label>
                    <div class="sectionError text-danger error-message"></div>
                </div>
                <div class="form-group">
                    <select class="select2_custom form-control section_id${fieldIndex}" name="section_id${fieldIndex}[]" multiple="multiple">
                        @if(count($sections) > 0)
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        @endif
                      </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">

                <div class="form-group">
                    <label for="field1">Subjects:</label>
                    <div class="subjectError text-danger error-message"></div>
                </div>
                <div class="form-group">
                    <select class="select2_custom form-control" name="subject_id${fieldIndex}[]" multiple="multiple">
                        @if(count($subjects) > 0)
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        @endif
                      </select>
                </div>
            </div>
          <div class="col-md-2 text-end">
            <button type="button" class="btn btn-danger mt-2 removeFieldBtn"><i class="bx bx-trash"></i></button>
          </div>
        </div>`;

      $('#fieldContainer').append(newField);
      // Initialize Select2 only for last and second-to-last fields
        var selectFields = $('#fieldContainer').find('.select2_custom');
        selectFields.eq(selectFields.length - 1).select2();
        if (selectFields.length > 1) {
        selectFields.eq(selectFields.length - 2).select2();
        }
      fieldIndex++; // Increment field index
    });

    // Remove field
    $(document).on('click', '.removeFieldBtn', function() {
      $(this).closest('.row').remove();
    });



    $('#myForm').submit(function(event) {
        event.preventDefault(); // Prevent form submission
        $(this).off('submit').submit();

        // Clear previous error messages
        $('.nameError').empty();
        $('.sectionError').empty();
         $('.subjectError').empty();

        var errorCount = 0;

        $('#fieldContainer .row').each(function() {
            var nameField = $(this).find('input[type="text"]');
      var fieldIndex = nameField.attr('name').match(/\d+/)[0];
      var sectionSelect = $(this).find('select[name="section_id' + fieldIndex + '[]"]');
      var subjectSelect = $(this).find('select[name="subject_id' + fieldIndex + '[]"]');


      if (nameField.val().trim() === '') {
        nameField.siblings('.nameError').text('Name is required.');
        errorCount++;
      }

      if (sectionSelect.val() === null || sectionSelect.val().length === 0) {
        $(this).find('.sectionError').text('Select at least one section.');
        errorCount++;
      }

      if (subjectSelect.val() === null || subjectSelect.val().length === 0) {
        $(this).find('.subjectError').text('Select at least one subject.');
        errorCount++;
      }
        });

        if (errorCount === 0) {
          // No errors, perform form submission
          $(this).off('submit').submit();
        }
    });
    </script>
    @endpush
@endsection

