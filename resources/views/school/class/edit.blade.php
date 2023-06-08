@extends('school.layouts.main')
@section('page_title', 'Schools')
@section('content')
    <style>
        .custom-section {
            height: 200px;
            overflow: scroll;
            width: 50%;
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
                        <li class="breadcrumb-item active">Edit Class</li>
                    </ol>
                </nav>
                <a href="{{ route('school.class') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form id="myForm" action="{{ route('school.class.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $classData->id }}">
                                    <div id="fieldContainer">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="field1">Name:</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name"
                                                        value="{{ old('name', $classData->name) }}">
                                                </div>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-12 mb-3 custom-section">

                                                <div class="form-group">
                                                    <label for="field1">Sections:</label>
                                                    @error('section')
                                                        <br>
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    @if (count($sections) > 0)
                                                        @foreach ($sections as $section)
                                                            <div class="form-check">
                                                                <input class="form-check-input" name="section[]"
                                                                    type="checkbox" value="{{ $section->id }}"
                                                                    id="section_{{ $section->id }}"
                                                                    @if (in_array($section->id, $sectionAssignArray)) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="section_{{ $section->id }}">
                                                                    {{ $section->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
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
        <script></script>
    @endpush
@endsection
