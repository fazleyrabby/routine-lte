

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Robots" content="index,follow"/>
    {{--    <link href="{{asset ('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" type="text/css" href="{{asset ('assets/css/report.css') }}" media="all" />

    <style>
        @page {
            margin-left: 25px;
            margin-right: 25px;
        }
    </style>
</head>
<body>
<div id="wrapper">

    <div id="">

        <div class="issue_info">

            <center style="font-size: 18px;">
                Class schedule for <strong>{{ ucfirst($teacher_detail->user->firstname)." ".ucfirst($teacher_detail->user->lastname) }} ( {{ $yearly_session->session->session_name."-".$yearly_session->year }} )</strong>
            </center>

            <hr>

            <table class="table table-striped table-bordered dt-responsive nowrap"
                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <tbody>
                @foreach($slots as $slot)

                        @php $count = 0; @endphp
                        @if($slot->slug == 'SAT' || $slot->slug == 'FRI')
                            <tr class="bg-light">
                            <th>Day / Time</th>
                            @foreach($day_wise_slots as $key => $timeslot)

                                @php $flag = 0; $colspan = ''; @endphp
                                @php
                                    $diff = intval((strtotime($timeslot->time_slot->to) - strtotime($timeslot->time_slot->from))/3600);
                                @endphp

                                @if($diff > 2 && $count < 4)
                                    @php $colspan = 2;@endphp
                                @endif


                                @if ($slot->id == $timeslot->day_id && $timeslot->time_slot_id == $timeslot->time_slot->id)
                                    @php $flag = 1; $count++; @endphp
                                @else @php $flag = 0; @endphp
                                @endif

                                @if($flag == 1)
                                    @php
                                        $time_slot_id = $timeslot->time_slot_id;
                                        $day_id = $timeslot->day_id;
                                        $data = date('g:i a', strtotime($timeslot->time_slot->from)).'-'.date('g:i a', strtotime($timeslot->time_slot->to));
                                    @endphp

                                    <th width="15%" colspan="{{ $colspan }}" class="p-0 text-center" style="overflow: hidden">
                                                    <span class="px-3 py-2 d-block">
                                                        {{ $data }}
                                                    </span>
                                    </th>
                                @endif
                            @endforeach
                            </tr>
                        @endif


                    <tr>
                        <td>
                            {{ $slot->day_title }}
                        </td>
                        @foreach($day_wise_slots as $timeslot)

                            @php $flag = 0 @endphp

                            @if ($slot->id == $timeslot->day_id)
                                @php $flag = 1 @endphp

                            @else @php $flag = 0 @endphp
                            @endif

                            @if($flag == 1)
                                <td colspan="{{ $colspan }}" style="font-weight: bold; text-align: center">
                                    @foreach($slot->routine as $key => $routine)

                                        @php($section_name = "")
                                        @if($routine->section_id)
                                            @foreach($routine->batch->student->section_student as $section_student)
                                                @if($section_student->section->id == $routine->section_id)
                                                    @php($section_name = "-".$section_student->section->section_name)
                                                @endif
                                            @endforeach
                                        @endif

                                        @if($timeslot->day->id == $routine->day_id && $timeslot->time_slot->id == $routine->time_slot_id &&  $routine->yearly_session_id == $y_session_id)
                                            {{ $routine->course->course_code }}-{{ $routine->course->course_type == '0' ? '(T)': '(L)' }} <br>
{{--                                            {{ $routine->course->course_name }} <br>--}}

                                            {{ $routine->room->building.'-'.$routine->room->room_no }} <br>
                                            {{ $routine->batch->department->department_name."-".$routine->batch->batch_no."-".$routine->batch->shift->slug.$section_name}}
                                        @endif


                                    @endforeach
                                </td>
                            @endif

                        @endforeach
                    </tr>
                @endforeach
                </tbody>

            </table>
            <br/><br/>

        </div>

    </div>


</div>
</body>
</html>
