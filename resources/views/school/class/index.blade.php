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
                @if(canHaveRole('Add Class'))
                <a href="{{ route('school.class.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Class</a>
                @endif

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
                                            @if(canHaveRole('Edit Class') OR canHaveRole('Delete Class') OR canHaveRole('Detail Class'))
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classes as $key => $class)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $class->name }}</td>
                                                @if(canHaveRole('Edit Class') OR canHaveRole('Delete Class') OR canHaveRole('Detail Class'))
                                                <td>
                                                    @if(canHaveRole('Detail Class'))
                                                    <a href="{{ route("school.class.detail",$class->id) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Edit Class'))
                                                    <a href="{{ route("school.class.edit",$class->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Edit Class'))
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $class->id }} data-url={{ route("school.class.delete") }}><i class='bx bxs-trash'></i></a>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($classes) > 0)
                            <div class="pagination_custom_class">
                            {{ $classes->links() }}
                            </div>
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
