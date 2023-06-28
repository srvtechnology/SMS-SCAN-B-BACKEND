@extends('school.layouts.main')
@section('page_title', 'Periods')
@section('content')
<style>
    #navWrap {
        width: 70%;
        position: absolute;
        height: 80%;
        margin: 0 auto;
        right: 0;
        left: 0;
    }
</style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <div class="card-body">
                                <div id="schedule2" class="jqs-demo mb-3"></div>
                                {{--  <div id="navWrap"></div>  --}}
                            </div>
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
    <script src="{{ asset('assets/pretty-weekly/pretty-calendar.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/weekly-calender/dist/jquery.schedule.js') }}"></script>

    <script>
        $('#schedule2').jqs({
            mode: 'read',
            data: <?php echo $response; ?>,
        });

        </script>
    @endpush
@endsection
