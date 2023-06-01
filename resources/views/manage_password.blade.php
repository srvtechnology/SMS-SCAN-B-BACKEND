@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="my-5">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <h5 class="card-header">Manage Password</h5>
                            <form id="validationform" action="{{ route('changepassword') }}" method="POST">
                                @csrf
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <p class="m-0">{{ session('error') }}</p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <p class="m-0">{{ session('success') }}</p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="row p-3">
                                    <div class="mb-3 col-md-12">
                                        <label for="email" class="form-label">Old Password</label>
                                        <input class="form-control" type="password" id="email" name="password"
                                            required />
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="email" class="form-label">New Password</label>
                                        <input class="form-control" type="password" id="password" name="new_password"
                                            required />
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="email" class="form-label">Confirm Password</label>
                                        <input class="form-control" type="password" id="confirm_password" required />
                                        <span id="confirm_password_msg"></span>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" disabled id="sign_in_btn" class="btn btn-primary me-2">Change
                                            Password</button>

                                    </div>
                                </div>
                            </form>
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
        <script>
            $(document).ready(function() {

                $("#confirm_password").bind('keyup change', function() {

                    check_Password($("#password").val(), $("#confirm_password").val())


                })

                $("#sign_in_btn").click(function() {

                    check_Password($("#password").val(), $("#confirm_password").val())

                })
            })

            function check_Password(Pass, Con_Pass) {

                if (Pass === "") {



                } else if (Pass === Con_Pass) {
                    $("#sign_in_btn").removeAttr("disabled");
                    $("#sign_in_btn").removeAttr("onclick")
                    $('#confirm_password_msg').show()
                    $("#confirm_password_msg").html('<div class="alert alert-success">Password matched</div>')

                    setTimeout(function() {
                        $('#confirm_password_msg').fadeOut('slow');
                    }, 3000);

                } else {
                    var $element = $('#sign_in_btn');
                    $("#confirm_password").focus()
                    $('#confirm_password_msg').show()

                    $("#confirm_password_msg").html('<div class="alert alert-danger">Password did not matched</div>')
                    $element.attr('disabled', true);

                    setTimeout(function() {
                        $('#confirm_password_msg').fadeOut('slow');
                    }, 3000);

                }

            }
        </script>
    @endpush
@endsection
