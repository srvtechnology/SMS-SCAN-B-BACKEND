@extends('school.layouts.main')

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
                            <a href="{{ route('school.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </nav>
                {{--  <a href="{{ route('school.add_permission') }}" class="btn rounded-pill btn-primary text-white">Create Permissions</a>  --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-5">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Permissions Detail</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            {{--  <th>Actions</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $key => $permission)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $permission->name }}</td>
                                                {{--  <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('school.edit_permission', $permission->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $permission->id }} data-url={{ route("school.delete_permission") }}><i class='bx bxs-trash'></i></a>
                                                    </div>
                                                </td>  --}}
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
