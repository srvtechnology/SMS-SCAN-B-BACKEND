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
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.periods') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <form id="myForm" action="{{ route('school.timetable.periods.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="mainSection">
                            <div class="my-3">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="field1">Class:</label>
                                                            <select name="class_id" id="class_id"
                                                                class="form-control @error('class_id') is-invalid @enderror class_id">
                                                                <option value="">Select</option>
                                                                @if (count($classes))
                                                                    @foreach ($classes as $class)
                                                                        <option value="{{ $class->id }}">{{ $class->name }}
                                                                        </option>
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
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-primary mt-4" id="addMainSection"><i
                                                            class='bx bx-plus-medical'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="innerForm">
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-group">
                                                        <label for="field1">Subjects:</label>
                                                        <select name="subject_id" id="subject_id"
                                                            class="form-control @error('subject_id') is-invalid @enderror subject_id">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>
                                                    @error('subject_id')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-group">
                                                        <label for="field1">Teachers:</label>
                                                        <select name="subject_id" id="subject_id"
                                                            class="form-control @error('subject_id') is-invalid @enderror">
                                                            <option value="">Select</option>
                                                            @if(count($teachers))
                                                            @foreach($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
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

                                                <div class="col-md-2 mb-2">
                                                    <div class="form-group">
                                                        <label for="field1">Start Time:</label>
                                                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                                                            name="start_time" value="{{ old('start_time') }}">
                                                    </div>
                                                    @error('start_time')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2 mb-2">
                                                    <div class="form-group">
                                                        <label for="field1">End Time:</label>
                                                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                                                            name="end_time" value="{{ old('end_time') }}">
                                                    </div>
                                                    @error('end_time')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <button type="button" class="btn btn-primary mt-4 addField" id="addField"><i
                                                        class='bx bx-plus-medical'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary submitBtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    @push('footer-script')
        <script>

            $(".class_id").on("change", function(){
                var class_id = $(this).val();
                getSectionsByClass(class_id);
            });

            $(".submitBtn").on("click", function() {
                loader();
            });
            function getSectionsByClass(class_id){
                $.ajax({
                    url: '{{ url('school/study-material/get-subjects-byclass/') }}' + '/' + class_id,
                    type: 'GET',
                    success: function(response) {
                        $(".subject_id").html('');
                        $(".subject_id").append('<option value="">Select</option>');
                        $(response).each(function(index, element) {
                            $(".subject_id").append('<option value="' + element.id + '">' + element
                                .name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('failed');
                    }
                });
            }

            let counter = 1;

            // Event handler for "addMainSection" button
            $('#addMainSection').click(function() {
              // Generate a unique ID for the new section
              const sectionId = `mainSection${counter}`;

              // Create the HTML for the new section
              const newSection = `
                <div id="${sectionId}">
                  <div class="my-3">
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6 mb-3">
                                <div class="form-group">
                                  <label for="field1">Class:</label>
                                  <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror class_id">
                                    <option value="">Select</option>
                                    @if (count($classes))
                                      @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
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
                              <div class="col-md-2">
                                <button type="button" class="btn btn-danger mt-4 deleteMainSection" data-section-id="${sectionId}">
                                  <i class="bx bx-trash"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="innerForm">
                          <div class="row">
                            <div class="col-md-3 mb-2">
                              <div class="form-group">
                                <label for="field1">Subjects:</label>
                                <select name="subject_id" id="subject_id" class="form-control @error('subject_id') is-invalid @enderror subject_id">
                                  <option value="">Select</option>
                                </select>
                              </div>
                              @error('subject_id')
                                <div class="text-danger">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="col-md-3 mb-2">
                              <div class="form-group">
                                <label for="field1">Teachers:</label>
                                <select name="subject_id" id="subject_id" class="form-control @error('subject_id') is-invalid @enderror">
                                  <option value="">Select</option>
                                  @if(count($teachers))
                                    @foreach($teachers as $teacher)
                                      <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
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
                            <div class="col-md-2 mb-2">
                              <div class="form-group">
                                <label for="field1">Start Time:</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}">
                              </div>
                              @error('start_time')
                                <div class="text-danger">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="col-md-2 mb-2">
                              <div class="form-group">
                                <label for="field1">End Time:</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}">
                              </div>
                              @error('end_time')
                                <div class="text-danger">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="col-md-2 mb-2">
                              <button type="button" class="btn btn-primary mt-4 addField"><i class='bx bx-plus-medical'></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `;

              // Append the new section to the container
              $('#mainSection').append(newSection);

              // Increment the counter for the next section
              counter++;
            });

            // Event delegation for "deleteMainSection" button
            $('#mainSection').on('click', '.deleteMainSection', function() {
              const sectionId = $(this).data('section-id');
              $('#' + sectionId).remove();
            });

            $(".addField").click(function() {
                const currentClassID = $(".class_id").val();
                getSectionsByClass(currentClassID);
                var fieldHTML = `
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="field1">Subjects:</label>
                                <select name="subject_id[]" class="form-control @error('subject_id') is-invalid @enderror subject_id">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            @error('subject_id')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="field1">Teachers:</label>
                                <select name="teacher_id[]" class="form-control @error('teacher_id') is-invalid @enderror">
                                    <option value="">Select</option>
                                    @if(count($teachers))
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            @error('teacher_id')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-2">
                            <div class="form-group">
                                <label for="field1">Start Time:</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time[]" value="{{ old('start_time') }}">
                            </div>
                            @error('start_time')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-2">
                            <div class="form-group">
                                <label for="field1">End Time:</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time[]" value="{{ old('end_time') }}">
                            </div>
                            @error('end_time')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="button" class="btn btn-danger mt-4 deleteField" ><i class="bx bx-trash"></i></button>
                        </div>
                    </div>
                `;
                $("#innerForm").append(fieldHTML);
            });

            $(document).on("click", ".deleteField", function() {
                $(this).closest(".row").remove();
            });
        </script>
    @endpush
@endsection
