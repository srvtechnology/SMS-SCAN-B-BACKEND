@extends('school.layouts.main')
@section('page_title', 'Periods')
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
                        <li class="breadcrumb-item active">Periods</li>
                    </ol>
                </nav>
                @if(canHaveRole('Add Push Notification'))
                <a href="{{ route('school.notification-create') }}"
                    class="btn rounded-pill btn-primary text-white">Create</a>
                @endif
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Notification List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            @if(canHaveRole('Edit Push Notification') OR canHaveRole('Delete Push Notification') OR canHaveRole('Send push Notification'))
                                            <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($push_notifications as $key => $push_notification)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ implode(",",json_decode($push_notification->type)) }}</td>
                                                <td>{{ $push_notification->title }}</td>
                                                <td>{{ $push_notification->message }}</td>
                                                @if(canHaveRole('Edit Push Notification') OR canHaveRole('Delete Push Notification') OR canHaveRole('Send push Notification'))
                                                <td>
                                                    {{--  <a href="{{ route('school.notification-view', $push_notification->id) }}"
                                                        class="btn btn-success">View</a>  --}}
                                                        @if(canHaveRole('Edit Push Notification'))
                                                    <a href="{{ route('school.notification-edit', $push_notification->id) }}"
                                                        class="btn btn-primary btn-sm"><i class='bx bxs-edit'></i></a>
                                                        @endif
                                                        @if(canHaveRole('Delete Push Notification'))
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $push_notification->id }} data-url={{ route("school.notification-delete") }}><i class='bx bxs-trash'></i></a>
                                                        @endif
                                                        @if(canHaveRole('Send push Notification'))
                                                    <a href="#"
                                                        class="btn btn-primary btn-sm NotificationSentBtn"><i class='bx bxs-send'></i></a>
                                                        @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--/ Basic Bootstrap Table -->
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
