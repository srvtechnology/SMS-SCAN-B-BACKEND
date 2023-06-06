@extends('school.layouts.main')
@section('page_title', 'Class')
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
                        <li class="breadcrumb-item active">Class</li>
                    </ol>
                </nav>
                <a href="{{ route('school.class.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Class</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Class List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classes as $key => $class)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $class->name }}</td>
                                                @if(getClassStatus($class->id) == "active")
                                                <td><span class="badge bg-success">{{ ucwords(getClassStatus($class->id)) }}</span></td>
                                                @elseif(getClassStatus($class->id) == "inactive")
                                                <td><span class="badge bg-danger">{{ ucwords(getClassStatus($class->id)) }}</span></td>
                                                @endif
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route("school.class.detail",$class->id) }}">Detail</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($classes) > 0)
                            {{ $classes->links() }}
                            @endif
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
