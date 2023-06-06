@extends('school.layouts.main')
@section('page_title', 'Sections')
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
                        <li class="breadcrumb-item active">Sections</li>
                    </ol>
                </nav>
                <a href="{{ route('school.sections.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Section</a>
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Section List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sections as $key => $section)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $section->name }}</td>
                                                @if(getSectionStatus($section->id) == "active")
                                                <td><span class="badge bg-success">{{ ucwords(getSectionStatus($section->id)) }}</span></td>
                                                @elseif(getSectionStatus($section->id) == "inactive")
                                                <td><span class="badge bg-danger">{{ ucwords(getSectionStatus($section->id)) }}</span></td>
                                                @endif
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route("school.sections.edit",$section->id) }}">Edit</a>
                                                        </li>
                                                        @if(getSectionStatus($section->id) == "inactive")
                                                        <li>
                                                            <a class="dropdown-item statusBtn" data-id={{ $section->id }} data-url={{ route("school.sections.block") }} data-status = {{ getSectionStatus($section->id) }}>Activate Section</a>
                                                        </li>
                                                        @else
                                                        <li>
                                                            <a class="dropdown-item statusBtn" data-id={{ $section->id }} data-url={{ route("school.sections.block") }} data-status = {{ getSectionStatus($section->id) }}>InActive Section</a>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item deleteBtn" data-id={{ $section->id }} data-url={{ route("school.sections.delete") }}>Delete</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($sections) > 0)
                            {{ $sections->links() }}
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
