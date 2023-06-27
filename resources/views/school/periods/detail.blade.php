@extends('school.layouts.main')
@section('page_title', 'Student Material')
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
                            <a href="{{ route('school.timetable.periods') }}">Periods</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.periods') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <div id="mainSection">
                        <div class="my-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="field1">Class:</label>
                                                        <h4>{{ $timetable_setting->fromClass->name }}-{{ $timetable_setting->toClass->name }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="">Date Range</label>
                                                        <h4 id="date_range"></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="innerForm">
                                        @if(count($periods))
                                        @foreach($periods as $key => $period)
                                        @php
                                            $keyIndex = $key+1;
                                        @endphp
                                        <div class="row"  id="field{{ $keyIndex }}">
                                            <div class="col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="field{{ $keyIndex }}">Title</label>
                                                    <h4>{{ $period->title }}</h4>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="field{{ $keyIndex }}">Start Time:</label>
                                                    <h4>{{ $period->start_time }}</h4>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="field{{ $keyIndex }}">End Time:</label>
                                                    <h4>{{ $period->end_time }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
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
        <script>
            var class_id = '{{ $class_id }}';
            const day_range_id = '{{ $day_range_id }}';
            $.ajax({
                url: '{{ url('school/time-table/periods/get-date-range') }}' + '/' + class_id,
                type: 'GET',
                success: function(response) {
                    $("#date_range").html('');
                    $(response).each(function(index, element) {
                        if(day_range_id == element.id)
                        {
                            var selected = "selected";
                        }
                        $("#date_range").append('<option value="' + element.id + '"  '+selected+'>' + element
                            .days + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('failed');
                }
            });

            $(".class_id").on("change", function(){
                var class_id = $(this).val();
                getSectionsByClass(class_id,1);
            });

            $(".submitBtn").on("click", function() {
                loader();
            });
              function getSectionsByClass(class_id,counter){
                $.ajax({
                    url: '{{ url('school/time-table/periods/get-date-range') }}' + '/' + class_id,
                    type: 'GET',
                    success: function(response) {
                        $("#date_range").html('');
                        $(response).each(function(index, element) {
                            $("#date_range").append('<option value="' + element.id + '">' + element
                                .days + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('failed');
                    }
                });
            }

        </script>
    @endpush
@endsection
