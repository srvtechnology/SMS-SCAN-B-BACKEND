<!DOCTYPE html>
<html>

<head>
    <title>Attendance Sheet</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            font-size: 10px;
            /* Adjust the font size as needed */
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
        }

        .page_break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th colspan="{{ count($dateList) }}" style="text-align:center !important;">
                    <h4>Attendance
                        Sheet/Class-{{ getAttendanceData(request()->class_id, request()->section_id, request()->from_date, request()->to_date) }}
                    </h4>
                </th>
            </tr>
        </thead>
    </table>
    @if (count($dateList))
        @foreach ($dateList as $chunk)
            <table id="myTable" style="page-break-after: always;">
                <thead>
                    <tr>
                        <th>Student name</th>
                        <!-- Iterate over each chunk -->
                        @foreach ($chunk as $dateData)
                            <th style="text-align:center !important;">
                                {{ $dateData['date'] }} <br>
                                {{ $dateData['day'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if (count($students) > 0)
                        @foreach ($students->chunk(5) as $studentChunk)
                            @foreach ($studentChunk as $student)
                                <tr>
                                    <td>{{ $student->student->first_name }} {{ $student->student->last_name }}</td>
                                    @foreach ($chunk as $dateData)
                                        <td style="text-align:center !important;">
                                            {{ getStudentAttendance(request()->class_id, request()->section_id, $student->student->id, $dateData['date']) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endforeach
    @endif



</body>

</html>
