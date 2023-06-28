@extends('school.layouts.main')
@section('page_title', 'Periods')
@section('content')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }
</style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('school.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">TimeTable</li>
                    </ol>
                </nav>
                <a href="{{ route('school.timetable.assign_periods') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card">
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <th></th>
                                        @if(count($weekdays))
                                        @foreach($weekdays as $weekday)
                                        <th>{{ $weekday }}</th>
                                        @endforeach
                                        @endif
                                    </tr>
                                    @if(count($start_time))
                                    @foreach($start_time as $time)
                                    <tr>
                                        <td>{{ $time }}</td>
                                        @if(count($weekdays))
                                        @foreach($weekdays as $weekday)
                                        <td>
                                            @foreach($periods as $period)
                                            @if($period['start_time'] == $time)
                                            <span class="badge bg-primary">
                                                <p>{{ $period['subject'] }}</p>
                                                <p>{{ $period['teacher'] }}</p>
                                                <p>{{ $period['start_time'] }} - {{ $period['end_time'] }}</p>
                                            </span>
                                            @endif
                                            @endforeach
                                        </td>
                                        @endforeach
                                        @endif
                                    </tr>
                                    @endforeach
                                    @endif
                                </table>
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
