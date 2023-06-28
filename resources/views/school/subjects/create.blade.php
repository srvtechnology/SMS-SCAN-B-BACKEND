@extends('school.layouts.main')
@section('page_title', 'Subjects')
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
                            <a href="{{ route('school.subjects') }}">Subjects</a>
                        </li>
                        <li class="breadcrumb-item active">Create Subject</li>
                    </ol>
                </nav>
                <a href="{{ route('school.subjects') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form id="myForm" action="{{ route('school.subjects.store') }}" method="POST">
                                    @csrf
                                    @error('section.*')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="error-message text-danger"></div>
                                    <div id="fieldContainer">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field1">Subject Name 1:</label>
                                                    <input type="text" class="form-control" id="section1" name="subject[]">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <button type="button" class="btn btn-primary mt-2" id="addField"><i class='bx bx-plus-medical'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2" id="submitBtn">Submit</button>
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

    <script>
        var fieldCount = 2;

        function createField() {
          var container = $('#fieldContainer');

          var row = $('<div>', { class: 'row mt-3' });

          var col1 = $('<div>', { class: 'col-md-6' });

          var formGroup = $('<div>', { class: 'form-group' });

          var label = $('<label>', { for: 'section' + fieldCount, text: 'Subject Name ' + fieldCount + ':' });

          var inputGroup = $('<div>', { class: 'input-group' });

          var input = $('<input>', { type: 'text', class: 'form-control section', id: 'section' + fieldCount, name: 'subject[]'});

          var removeButton = $('<button>', { type: 'button', class: 'btn btn-danger removeField' });
          removeButton.html('<i class="bx bx-trash"></i>');

          inputGroup.append(input);
          inputGroup.append(removeButton);
          formGroup.append(label);
          formGroup.append(inputGroup);
          //formGroup.append('<div class="error-message"></div>');
          col1.append(formGroup);

          var col2 = $('<div>', { class: 'col-md-6 mt-3' });


          row.append(col1);
          row.append(col2);
          container.append(row);

          fieldCount++;


          // Remove the field when the remove button is clicked
          removeButton.on('click', function() {
            row.remove();
          });
        }

        $('#addField').on('click', createField);

        $('#myForm').submit(function(event) {
            event.preventDefault(); // Prevent form submission

            var errorMessages = [];

            $('#fieldContainer input').each(function(index) {
                var fieldName = $(this).attr('name');
                var fieldValue = $(this).val();
                var fieldIndex = index + 1;

                if (fieldValue === '') {
                    errorMessages.push('Section Name ' + fieldIndex + ' is required.');
                }
            });
            if (errorMessages.length > 0) {
                var errorMessage = errorMessages.join('<br>');
                $('.error-message').html(errorMessage).show();
            } else {
                $('.error-message').hide();
                $(this).off('submit').submit();
            }
        });
      </script>
    @endpush
@endsection
