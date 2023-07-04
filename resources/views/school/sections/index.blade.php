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
                @if(canHaveRole('Add Section'))
                <a href="{{ route('school.sections.create') }}" class="btn rounded-pill btn-primary text-white">Create
                    Section</a>
                @endif
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
                                            @if(canHaveRole('Edit Section') OR canHaveRole('Delete Section'))
                                            <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sections as $key => $section)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $section->name }}</td>
                                                @if(canHaveRole('Edit Section') OR canHaveRole('Delete Section'))
                                                <td>
                                                    @if(canHaveRole('Edit Section'))
                                                    <a href="{{ route("school.sections.edit",$section->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class='bx bxs-edit'></i></a>
                                                    @endif
                                                    @if(canHaveRole('Delete Section'))
                                                    <a class="btn btn-danger btn-sm text-white deleteBtn" title="Delete" data-id={{ $section->id }} data-url={{ route("school.sections.delete") }}><i class='bx bxs-trash'></i></a>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($sections) > 0)
                            <div class="pagination_custom_class">
                            {{ $sections->links() }}
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
