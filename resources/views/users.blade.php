@extends('layouts.main')

@section('content')
    <style>
        #example_wrapper {
            padding: 10px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </nav>
                <a href="{{ route('add_user') }}" class="btn rounded-pill btn-primary text-white">Create User</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-5">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Users Detail</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Cell no</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img src="{{ asset('uploads/' . $user->image) }}" alt=""
                                                        style="height:auto; width:50px;">
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone_number }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a class=" cus_margin1"
                                                            href="{{ route('edit_user', $user->id) }}"><i
                                                                class="bx bx-edit-alt me-1"></i>
                                                        </a>
                                                        <a class=" cus_margin1"
                                                            href="{{ route('delete_completeuser', $user->id) }}"><i
                                                                class="bx bx-trash me-1 danger_clr"></i>
                                                        </a>
                                                    </div>
                                                </td>
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
@endsection
