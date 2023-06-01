@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('permissions') }}">Permissions</a>
                        </li>
                        <li class="breadcrumb-item active">Create Permission</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-5">
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Enter permission details</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('create_permission') }}" method="POST">
                                        @csrf
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="basic-default-name">Permission
                                                Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="permission_name" class="form-control"
                                                    id="basic-default-name" placeholder="Enter permission Name" />
                                            </div>
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
@endsection
