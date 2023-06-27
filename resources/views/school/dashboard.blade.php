@extends('school.layouts.main')
@section('page_title','Dashboard')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">

                <div class="col-lg-12 col-md-4 order-1">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                                alt="chart success" class="rounded" />
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">No of Students</span>
                                    <h3 class="card-title mb-2">{{ $students }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                                alt="Credit Card" class="rounded" />
                                        </div>

                                    </div>
                                    <span>No of Staffs</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $staffs }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                                alt="Credit Card" class="rounded" />
                                        </div>

                                    </div>
                                    <span>No of Parents</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $parents }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                                alt="Credit Card" class="rounded" />
                                        </div>

                                    </div>
                                    <span>No of Classes</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $classes }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                                alt="Credit Card" class="rounded" />
                                        </div>

                                    </div>
                                    <span>No of Sections</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $sections }}</h3>
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
    @push('footer-script')

    @endpush
@endsection
