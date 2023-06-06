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
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="field1">Name:</label>
                                                    <input type="text" class="form-control" id="name" name="name1">
                                                    <div class="nameError text-danger error-message"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 custom-section">

                                                <div class="form-group">
                                                    <label for="field1">Sections:</label>
                                                    <div class="sectionError text-danger error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                    @if(count($sections) > 0)
                                                    @foreach($sections as $section)
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="section1[]" type="checkbox" value="{{ $section->id }}" id="section_{{ $section->id }}">
                                                        <label class="form-check-label" for="section_{{ $section->id }}">
                                                          {{ $section->name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                    @endif
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
    <script>
        var fieldIndex = 2; // Initial field index

    // Add new field
    $('.addField').on('click', function() {
      var newField =
        `<div class="row">
          <div class="col-md-6 mb-3">
            <div class="form-group">
              <label for="field${fieldIndex}">Name:</label>
              <input type="text" class="form-control" id="name${fieldIndex}" name="name${fieldIndex}">
              <div class="nameError text-danger error-message"></div>
            </div>
          </div>
          <div class="col-md-4 mb-3 custom-section">
            <div class="form-group">
              <label for="field${fieldIndex}">Sections:</label>
              <div class="sectionError text-danger error-message"></div>
            </div>
            <div class="form-group">
              @if(count($sections) > 0)
              @foreach($sections as $section)
              <div class="form-check">
                <input class="form-check-input" name="section${fieldIndex}[]" type="checkbox" value="{{ $section->id }}" id="section${fieldIndex}_${{ $section->id }}">
                <label class="form-check-label" for="section${fieldIndex}_${{ $section->id }}">
                  {{ $section->name }}
                </label>
              </div>
              @endforeach
              @endif
            </div>
          </div>
          <div class="col-md-2 text-end">
            <button type="button" class="btn btn-danger mt-2 removeFieldBtn"><i class="bx bx-trash"></i></button>
          </div>
        </div>`;

      $('#fieldContainer').append(newField);
      fieldIndex++; // Increment field index
    });

    // Remove field
    $(document).on('click', '.removeFieldBtn', function() {
      $(this).closest('.row').remove();
    });

    $('#myForm').submit(function(event) {
        event.preventDefault(); // Prevent form submission

        // Clear previous error messages
        $('.nameError').empty();
        $('.sectionError').empty();

        var errorCount = 0;

        $('#fieldContainer .row').each(function() {
          var nameField = $(this).find('input[type="text"]');
          var checkboxes = $(this).find('input[type="checkbox"]:checked');

          if (nameField.val().trim() === '') {
            nameField.siblings('.nameError').text('Name is required.');
            errorCount++;
          }

          if (checkboxes.length === 0) {
            $(this).find('.sectionError').text('Select at least one section.');
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

