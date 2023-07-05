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

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            font-size: 10px; /* Adjust the font size as needed */
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table id="myTable">
        <thead>
            <tr>
                <th colspan="{{ count($dateList)+1 }}" style="text-align:center !important;">
                    <h4>Attendance Sheet/Class-{{ getAttendanceData(request()->class_id, request()->section_id, request()->from_date, request()->to_date) }}</h4>
                </th>
            </tr>
            <tr>
                <th>Student name</th>
                @if(count($dateList))
                    @foreach($dateList as $chunk) <!-- Iterate over each chunk -->
                        @foreach($chunk as $dateData)
                            <th style="text-align:center !important;">
                                {{ $dateData['date'] }} <br>
                                {{ $dateData['day'] }}
                            </th>
                        @endforeach
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @if(count($students) > 0)
                @foreach($students->chunk(5) as $studentChunk) <!-- Split students into chunks of 5 entries per row -->
                    <tr>
                        @foreach($studentChunk as $student)
                            <td>{{ $student->student->first_name }} {{ $student->student->last_name }}</td>
                            @if(count($dateList))
                                @foreach($dateList as $chunk) <!-- Iterate over each chunk -->
                                    @foreach($chunk as $dateData)
                                        <td style="text-align:center !important;">
                                            {{ getStudentAttendance(request()->class_id, request()->section_id, $student->student->id, $dateData['date']) }}
                                        </td>
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>


</body>
</html>
