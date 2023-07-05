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
                            <a href="{{ route('school.users') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-5">
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Update user details</h5>
                                </div>
                                <div class=" mb-4">
                                    <form id="formAccountSettings" action="{{ route('school.updateuser') }}"
                                            enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Name</label>
                                                <input class="form-control @error('Name') is-invalid @enderror" type="text" id="firstName" name="Name"
                                                    value="{{ $user->name }}"  autofocus />
                                                    @error('Name')
                                                     <div class="text-danger">
                                                         {{ $message }}
                                                     </div>
                                                 @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="email" class="form-label">E-mail</label>
                                                <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" name="email"
                                                    value="{{ $user->email }}"  />
                                                    @error('email')
                                                     <div class="text-danger">
                                                         {{ $message }}
                                                     </div>
                                                 @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="phoneNumber" name="phoneNumber"
                                                        value="{{ $user->phone_number }}" class="form-control @error('phoneNumber') is-invalid @enderror"
                                                        placeholder="202 555 0111" />

                                                        @error('phoneNumber')
                                                     <div class="text-danger">
                                                         {{ $message }}
                                                     </div>
                                                 @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="defaultSelect" class="form-label">Select Role</label>
                                                <select id="defaultSelect" class="form-select @error('role_id') is-invalid @enderror" name="role_id">
                                                    <option>Default select</option>
                                                    @foreach ($roles as $role)
                                                        <option @if ($role->id == $user->role_id) selected @endif
                                                            value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                     <div class="text-danger">
                                                         {{ $message }}
                                                     </div>
                                                 @enderror
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- /Account -->
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
