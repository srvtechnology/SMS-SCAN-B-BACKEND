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
                            <a href="{{ route('roles') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </nav>
                <a href="{{ url('add_role') }}" class="btn rounded-pill btn-primary text-white">Create Roles</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-5">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Roles Detail</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a class=" cus_margin1" href="{{ url('edit_role', $role->id) }}"><i
                                                                class="bx bx-edit-alt me-1"></i>
                                                        </a>
                                                        <a class=" cus_margin1"
                                                            href="{{ route('delete_role', $role->id) }}"><i
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

    @push('footer-script')
    @endpush
@endsection
