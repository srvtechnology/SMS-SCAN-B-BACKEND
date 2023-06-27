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
                            <a href="">Periods</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
                <a href="" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <div class="card">
                        <div class="card-body">
                            <form class="form" action="{{ route('school.update-notification') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $push_notification->id }}" name="id">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="type" class=" mt-2">Type</label>
                                            <select id="type" name="nofication_type[]" required class="form-control select2_custom" multiple>
                                                <option value="Teacher" @if(in_array("Teacher",$types)) selected @endif>Teacher</option>
                                                <option value="Student" @if(in_array("Student",$types)) selected @endif>Student</option>
                                                <option value="Parent" @if(in_array("Parent",$types)) selected @endif>Parent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="title" class=" mt-2">Title</label>
                                            <input type="text" id="title" class="form-control" name="title"
                                                value="{{ $push_notification->title }}" placeholder="Enter Title">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="message" class=" mt-2">Message</label>
                                            <textarea type="text" id="message" class="form-control" name="message" placeholder="Enter Message Here"> {{ $push_notification->message }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex mt-3">
                                        <button type="submit" data-bs-dismiss="modal" class="btn btn-primary me-1 mb-1">
                                            Submit
                                        </button>
                                    </div>
                                </div>
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
    @endpush
@endsection
