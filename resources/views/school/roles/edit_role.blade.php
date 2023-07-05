@extends('school.layouts.main')

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
                        <li class="breadcrumb-item">
                            <a href="{{ route('school.roles') }}">Roles</a>
                        </li>
                        <li class="breadcrumb-item active">Update Role</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-5">
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Update role details</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('school.updaterole') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="basic-default-name">Role
                                                Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="role_name" class="form-control @error('role_name') is-invalid @enderror"
                                                    value="{{ $role->name }}" id="basic-default-name"
                                                    placeholder="Enter role Name" />
                                                    @error('role_name')
                                                     <div class="text-danger">
                                                         {{ $message }}
                                                     </div>
                                                 @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="" class="col-sm-2 col-form-label">
                                                Permissions
                                            </label>
                                            <div class="col-md-10 mb-3">
                                                <div class="d-flex gap-3">
                                                    @php
                                                        $ids = $role->permissions->pluck('id')->toArray();
                                                    @endphp
                                                    <select name="permissions[]" class="form-control select2_custom @error('permissions') is-invalid @enderror" multiple id="">
                                                        @if(count($permissions) > 0)
                                                        @foreach ($permissions as $permission)
                                                        <option value="{{ $permission->id }}" @if (in_array($permission->id, $ids)) selected @endif>{{ $permission->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                @error('permissions')
                                                     <div class="text-danger">
                                                         {{ $message }}
                                                     </div>
                                                 @enderror
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
