@extends('layouts.main')
@section('page_title', 'Profile')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                        </li>
                    </ul>
                    <div class="card mb-4">
                        <h5 class="card-header">Profile Details</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <form id="formAccountSettings" action="{{ route('add_profile', $user->id) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf

                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="{{ getUserImage() }}" alt="user-avatar" class="d-block rounded" height="100"
                                        width="100" id="uploadedAvatar" />
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" name="profile_image" id="upload"
                                                class="account-file-input" hidden accept="image/png, image/jpeg" />
                                        </label>
                                        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <p class="text-muted mb-0">Allowed JPG or PNG.</p>
                                    </div>
                                </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input class="form-control" type="text" id="firstName" name="firstName" required
                                        value="{{ $user->first_name }}" autofocus />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input class="form-control" type="text" name="lastName" id="lastName" required
                                        value="{{ $user->last_name }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input disabled class="form-control" type="text" id="email" name="email"
                                        required value="{{ $user->email }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="organization" class="form-label">Organization</label>
                                    <input type="text" class="form-control" id="organization" required
                                        name="organization" value="{{ $user->orgnization }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="phoneNumber" name="phoneNumber" required
                                            value="{{ $user->phone_number }}" class="form-control"
                                            placeholder="202 555 0111" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required
                                        value="{{ $user->address }}" placeholder="Address" />
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
                    <div class="card">
                        <h5 class="card-header">Delete Account</h5>
                        <div class="card-body">
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?
                                    </h6>
                                    <p class="mb-0">Once you delete your account, there is no going back. Please be
                                        certain.</p>
                                </div>
                            </div>
                            <form id="formAccountDeactivation" action="{{ route('delete_user', $user->id) }}"
                                method="POST">
                                @csrf

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="accountActivation"
                                        id="checkBox1" checked />
                                    <label class="form-check-label" for="accountActivation">I confirm my account
                                        deactivation</label>
                                </div>
                                <button type="submit" class="btn btn-danger deactivate-account"
                                    id="deactivate_btn">Deactivate
                                    Account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

    </div>
    @push('footer-script')
        <script>
            $(document).ready(function() {
                {
                    $("#checkBox1").click(function() {
                        $("#deactivate_btn").attr("disabled", !this.checked);
                    });
                }
            })
        </script>
    @endpush
@endsection
