@extends('school.layouts.main')
@section('page_title', 'Section')
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
                            <a href="{{ route('school.sections') }}">Sections</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Section</li>
                    </ol>
                </nav>
                <a href="{{ route('school.sections') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <x-alert></x-alert>
                                <form id="myForm" action="{{ route('school.sections.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $section->id }}">
                                    <div class="col-md-6">
                                        <div class="form-group" id="fieldContainer">
                                            <label for="field1">Section Name:</label>
                                            <input type="text" class="form-control" id="section" name="name" value="{{ old('name',$section->name) }}">
                                            @error('name')
                                              <div class="alert alert-danger mt-2">
                                                  {{ $message }}
                                              </div>
                                          @enderror
                                          </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
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
        //apply validation
        $('#section').on('keypress', function(event) {
            var inputValue = $(this).val();
            var enteredChar = event.key;
            if (inputValue.length >= 1 && event.keyCode !== 8 || !isNaN(enteredChar)) {

                event.preventDefault();
            }
        });
    </script>
    @endpush
@endsection
