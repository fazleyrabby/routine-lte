<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/dist/css/report.css') }}" media="all" />
    <style>
        @page {
            margin: 15px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .time-header th {
            font-weight: 400;
            font-size: 10px;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <center style="font-size: 18px; margin-bottom: 10px">
        Class schedule for <strong>{{ $batch->department_name."-".$batch->batch_no."-".$batch->slug }}{{ $batch->section_name != '' ? " - ".$batch->section_name : '' }} ({{ $batch->session_name."-".$batch->year }}) </strong>
    </center>
    <hr>

    <table>
        <tbody>
        @foreach($slots as $slot)
            @php $count = 0; @endphp
            @if($slot->slug == 'SAT' || $slot->slug == 'FRI')
                <tr>
                    <th>Day/Time</th>
                    @php $count = 0; @endphp
                    @foreach($day_wise_slots as $key => $timeslot)
                        @php
                            $flag = ($slot->id == $timeslot->day_id) ? 1 : 0;
                            if ($flag) $count++;
                            $diff = intval((strtotime($timeslot->time_slot->to) - strtotime($timeslot->time_slot->from))/3600);
                            $colspan = ($diff > 2 && $count < 4) ? 2 : '';
                        @endphp
                        @if($flag == 1)
                            <th colspan="{{ $colspan ?: '' }}">{{ date('g:i a', strtotime($timeslot->time_slot->from)).'-'.date('g:i a', strtotime($timeslot->time_slot->to)) }}</th>
                        @endif
                    @endforeach
                </tr>
            @endif
            @php
                $cols = $day_wise_slots->where('day_id', $slot->id)->values();
            @endphp
            <tr>
                <td style="font-weight: bold; text-align: center;">
                    {{ $slot->day_title }}
                </td>
                @foreach($cols as $index => $timeslot)
                    @php
                        $current_routine = null;
                        foreach($slot->routine as $routine) {
                            if($timeslot->day->id == $routine->day_id && $timeslot->time_slot->id == $routine->time_slot_id && $routine->yearly_session_id == $y_session_id) {
                                $current_routine = $routine;
                                break;
                            }
                        }

                        $diff = intval((strtotime($timeslot->time_slot->to) - strtotime($timeslot->time_slot->from))/3600);
                        $colspan = ($diff > 2 && $loop->iteration < 4) ? 2 : 1;
                        if ($current_routine) {
                            $ni = $index + 1;
                            while($ni < $cols->count()) {
                                $next_timeslot = $cols[$ni];
                                $next_routine = null;
                                foreach($slot->routine as $r) {
                                    if($next_timeslot->day->id == $r->day_id && $next_timeslot->time_slot->id == $r->time_slot_id && $r->yearly_session_id == $y_session_id) {
                                        $next_routine = $r;
                                        break;
                                    }
                                }
                                if ($next_routine && 
                                    $next_routine->course_id == $current_routine->course_id &&
                                    $next_routine->teacher_id == $current_routine->teacher_id &&
                                    $next_routine->room_id == $current_routine->room_id &&
                                    $next_routine->batch_id == $current_routine->batch_id &&
                                    $next_routine->section_id == $current_routine->section_id &&
                                    $next_routine->yearly_session_id == $current_routine->yearly_session_id) {
                                    $colspan++;
                                    $ni++;
                                } else {
                                    break;
                                }
                            }
                        }
                    @endphp

                    <td colspan="{{ $colspan }}" style="font-weight: bold; text-align: center; font-size: 10px;">
                        @if($current_routine)
                            {{ $current_routine->course->course_code }}-{{ $current_routine->course->course_type == '0' ? 'T' : 'L' }} <br>
                            {{ $current_routine->course->course_name }} <br>
                            {{ $current_routine->room->building.'-'.$current_routine->room->room_no }} <br>
                            {{ $current_routine->teacher->user->firstname." ".$current_routine->teacher->user->lastname }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
</body>
</html>
