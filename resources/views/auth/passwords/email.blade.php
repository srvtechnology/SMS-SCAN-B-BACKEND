<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMS SCAN | Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="app-brand justify-content-center">
                            <a href="#" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bolder">SMS SCAN</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Forgot Password? 🔒</h4>
                        <p class="mb-4">Enter your email and we will send you instructions to reset your password</p>
                        <form id="formAuthentication" class="mb-3" method="POST"
                            action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    placeholder="Enter your email" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-primary d-grid w-100">Send Reset Link</button>
                        </form>
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
</body>

</html>
