@extends('school.layouts.main')
@section('page_title', 'Teachers')
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
                        <li class="breadcrumb-item active">Teachers</li>
                    </ol>
                </nav>
                @if (canHaveRole('Add Staff'))
                    <a href="{{ route('school.teachers.create') }}" class="btn rounded-pill btn-primary text-white">Create
                        Teacher</a>
                @endif
            </div>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Teachers List</h5>
                            <div class="table-responsive text-nowrap">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Class Teacher</th>
                                            @if (canHaveRole('Edit Staff') or canHaveRole('Delete Staff') or canHaveRole('Detail Staff'))
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($staffs) > 0)
                                            @foreach ($staffs as $staff)
                                                <tr>
                                                    <td>#</td>
                                                    <td>
                                                        <img src="{{ getStaffImage($staff->id) }}" class="img-fluid rounded"
                                                            width="50" height="50" alt="">
                                                    </td>
                                                    <td>{{ $staff->first_name }} {{ $staff->last_name }}</td>
                                                    <td>{{ $staff->designation->name }}</td>
                                                    <td>
                                                        @if(empty($staff->assign_class_to_class_teacher) AND empty($staff->assign_section_to_class_teacher))
                                                        <span>N/A</span><br>
                                                        <span style="cursor: pointer;" class="text-primary assignClassTeacherBtn" data-id={{ $staff->id }} data-url={{ route("school.teachers.assign_class_teacher") }}>Assign Class Teacher</span>
                                                        @else
                                                        <span>{{ $staff->assign_class_teacher_class->name }} ({{ $staff->assign_class_teacher_section->name }})</span><br>
                                                        <span style="cursor: pointer;" class="text-primary assignClassTeacherEditBtn" data-id={{ $staff->id }} data-url={{ route("school.teachers.update_assign_class_teacher") }} data-class_id={{ $staff->assign_class_to_class_teacher }} data-section_id={{ $staff->assign_section_to_class_teacher }}>Edit Assign Class Teacher</span>

                                                        @endif
                                                    </td>
                                                    @if (canHaveRole('Edit Staff') or canHaveRole('Delete Staff') or canHaveRole('Detail Staff'))
                                                        <td>
                                                            @if (canHaveRole('Detail Staff'))
                                                                <a href="{{ route('school.teachers.detail', $staff->id) }}"
                                                                    class="btn btn-success btn-sm" title="Detail"><i
                                                                        class='bx bx-detail'></i></a>
                                                            @endif
                                                            @if (canHaveRole('Edit Staff'))
                                                                <a href="{{ route('school.teachers.edit', $staff->id) }}"
                                                                    class="btn btn-primary btn-sm" title="Edit"><i
                                                                        class='bx bxs-edit'></i></a>
                                                            @endif
                                                            @if (canHaveRole('Delete Staff'))
                                                                <a class="btn btn-danger btn-sm text-white deleteBtn"
                                                                    title="Delete" data-id={{ $staff->id }}
                                                                    data-url={{ route('school.teachers.delete') }}><i
                                                                        class='bx bxs-trash'></i></a>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if (count($staffs) > 0)
                                <div class="pagination_custom_class">
                                    {{ $staffs->links() }}
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
    <div class="modal" tabindex="-1" id="assignClassTeacherModal">
        <form id="assignClassTeacherForm" method="POST">
            @csrf
            <input type="hidden" name="staff_id" id="staff_id">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Class Teacher</h5>
                        <button type="button" class="btn-close closeAssignClassTeacherBtn" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Class</label>
                                    <select name="class_id" id="class_id" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select name="section_id" id="section_id" class="form-control">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closeAssignClassTeacherBtn"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal" tabindex="-1" id="assignClassTeacherEditModal">
        <form id="assignClassTeacherEditForm" method="POST">
            @csrf
            <input type="hidden" name="staff_id" id="update_staff_id">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Assign Class Teacher</h5>
                        <button type="button" class="btn-close closeassignClassTeacherEditForm" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Class</label>
                                    <select name="class_id" id="update_class_id" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select name="section_id" id="update_section_id" class="form-control">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closeassignClassTeacherEditForm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('footer-script')
        <script>
            $(".assignClassTeacherBtn").on("click", function() {
                $("#assignClassTeacherModal").show();
                var id = $(this).attr("data-id");
                var url = $(this).attr("data-url");
                $("#staff_id").val(id);
                $("#assignClassTeacherForm").attr("action", url);
                $("#class_id").html('');
                $("#section_id").html('');
                $.ajax({
                    url: '{{ url("/school/teachers/get-class/") }}'+'/'+id,
                    type: 'GET',
                    success: function(response) {
                        $("#class_id").append('<option value="">Select</option>');
                        $(response).each(function(key,element) {
                            $("#class_id").append('<option value="'+element.class_id+'">'+element.class_name+'</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                    console.error('Form submission failed');
                    }
                });
            });

            $(".assignClassTeacherEditBtn").on("click", function() {
                $("#assignClassTeacherEditModal").show();
                var id = $(this).attr("data-id");
                var url = $(this).attr("data-url");
                var class_id = $(this).attr('data-class_id');
                var section_id = $(this).attr('data-section_id');
                $("#update_staff_id").val(id);
                $("#assignClassTeacherEditForm").attr("action", url);
                $("#update_class_id").html('');
                $("#update_section_id").html('');
                $.ajax({
                    url: '{{ url("/school/teachers/get-class/") }}'+'/'+id,
                    type: 'GET',
                    success: function(response) {
                        $("#update_class_id").append('<option value="">Select</option>');
                        $(response).each(function(key,element) {
                            if(class_id == element.class_id) {
                                var selected = "selected";
                            }
                            $("#update_class_id").append('<option value="'+element.class_id+'" '+selected+'>'+element.class_name+'</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                    console.error('Form submission failed');
                    }
                });

                var staff_id = $("#update_staff_id").val();
                $("#update_section_id").html('');
                $.ajax({
                    url: '{{ url("/school/teachers/get-class-section/") }}'+'/'+class_id+'/'+staff_id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $(response).each(function(key,element) {
                            if(section_id == element.section_id) {
                                var selected = "selected";
                            }
                            $("#update_section_id").append('<option value="'+element.section_id+'" '+selected+'>'+element.section_name+'</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                    console.error('Form submission failed');
                    }
                });
            });

            $("#class_id").on("change", function() {
                var class_id = $(this).val();
                var staff_id = $("#staff_id").val();
                $("#section_id").html('');
                $.ajax({
                    url: '{{ url("/school/teachers/get-class-section/") }}'+'/'+class_id+'/'+staff_id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $(response).each(function(key,element) {
                            $("#section_id").append('<option value="'+element.section_id+'">'+element.section_name+'</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                    console.error('Form submission failed');
                    }
                });
            });

            $("#update_class_id").on("change", function() {
                var class_id = $(this).val();
                var staff_id = $("#update_staff_id").val();
                $("#update_section_id").html('');
                $.ajax({
                    url: '{{ url("/school/teachers/get-class-section/") }}'+'/'+class_id+'/'+staff_id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $(response).each(function(key,element) {
                            $("#update_section_id").append('<option value="'+element.section_id+'">'+element.section_name+'</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                    console.error('Form submission failed');
                    }
                });
            });

            $(".closeAssignClassTeacherBtn").on("click", function() {
                $("#assignClassTeacherModal").hide();
            });

            $(".closeassignClassTeacherEditForm").on("click", function() {
                $("#assignClassTeacherEditModal").hide();
            });
        </script>
    @endpush
@endsection
