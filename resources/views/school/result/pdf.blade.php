<!DOCTYPE html>
<html>

<head>
    <title>Exam Sheet</title>
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
                <th colspan="{{ count($subjects) }}" style="text-align:center !important;">
                    <h4>Exam Result/Class-{{ getResultData(request()->exam_id,request()->class_id,request()->section_id) }}</h4>
                </th>
            </tr>
        </thead>
    </table>
    @if (count($subjects))
        @foreach ($subjects as $chuck_index => $chunk)
            <table id="myTable" @if($chuck_index+1 != count($subjects)) style="page-break-after: always;" @endif>
                <thead>
                    <tr>
                        <th>Student name</th>
                        <!-- Iterate over each chunk -->
                        @foreach ($chunk as $subjectData)
                        <th style="text-align:center !important;">
                            {{ $subjectData['name'] }} <br>
                            Total Marks - {{ getSubjectTotalMarks(request()->exam_id,request()->class_id,request()->section_id,$subjectData['id']) }}
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
                                            {{ getSubjectObtainedMarks(request()->exam_id,request()->class_id,request()->section_id,$subjectData['id'],$student->student->id) }}
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
