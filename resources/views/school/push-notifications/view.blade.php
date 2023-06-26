@extends('layouts.app')
@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">View Notification</h5>
                <div>
                    <a href="{{ route('notification-index') }}" class="btn btn-warning">Go Back</a>
                </div>
            </div>

            <div class="card-body">

                <input type="hidden" value="{{ $push_notification->id }}" name="id">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="type" class=" mt-2">Type</label>

                            <select id="type" disabled name="nofication_type" required class="form-select">
                                <option>Selecte Type</option>
                                <option value="Teacher" @if ($push_notification->type == 'Teacher') selected @endif>Teacher
                                </option>
                                <option value="Student" @if ($push_notification->type == 'Student') selected @endif>Student
                                </option>
                                <option value="Parent" @if ($push_notification->type == 'Parent') selected @endif>Parent</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="title" class=" mt-2">Title</label>
                            <input type="text" disabled id="title" class="form-control" name="title"
                                value="{{ $push_notification->title }}" placeholder="Enter Title">
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="message" class=" mt-2">Message</label>
                            <textarea type="text" disabled id="message" class="form-control" name="message" placeholder="Enter Message Here"> {{ $push_notification->message }}</textarea>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
@endsection
