@extends('school.layouts.main')
@section('page_title', 'Designation')
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
                            <a href="{{ route('school.designations') }}">Designations</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Designation</li>
                    </ol>
                </nav>
                <a href="{{ route('school.designations') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <x-alert></x-alert>
                                <form id="myForm" action="{{ route('school.designations.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $designation->id }}">
                                    <div class="col-md-6">
                                        <div class="form-group" id="fieldContainer">
                                            <label for="field1">Designation Name:</label>
                                            <input type="text" class="form-control" id="Designation" name="name" value="{{ old('name',$designation->name) }}">
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
    @endpush
@endsection
