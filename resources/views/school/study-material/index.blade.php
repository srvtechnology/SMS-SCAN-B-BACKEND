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
                        <li class="breadcrumb-item active">Student Material</li>
                    </ol>
                </nav>
                <a href="{{ route('school.studyMaterial.create-content') }}" class="btn rounded-pill btn-primary text-white">Upload Content</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Student Material List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($study_materials as $study_material)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $study_material->title }}</td>
                                                <td>{{ $study_material->class->name }}</td>
                                                <td>{{ $study_material->subject->name }}</td>
                                                <td>
                                                    <a href="{{ route("school.studyMaterial.detail-content",$study_material->id) }}" class="btn btn-success btn-sm" title="Detail"><i class='bx bx-detail'></i></a>
                                                    <a href="{{ route("school.studyMaterial.edit-content",$study_material->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $study_material->id }} data-url={{ route("school.studyMaterial.delete-content") }}><i class='bx bxs-trash'></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($study_materials) > 0)
                            <div class="pagination_custom_class">
                            {{ $study_materials->links() }}
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
