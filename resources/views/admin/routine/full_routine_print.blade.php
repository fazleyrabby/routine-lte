<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Full Routine</title>
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
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        .day-header {
            font-size: 14px;
            font-weight: bold;
            text-align: left;
            margin-top: 15px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .bg-warning {
            background-color: #fff3cd !important;
            color: #856404;
        }
        .bg-danger {
            background-color: #f8d7da !important;
            color: #721c24;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <center style="font-size: 18px; margin-bottom: 10px">
        Full Class Schedule for <strong>{{ $yearly_session->session->session_name."-".$yearly_session->year }}</strong>
    </center>
    <hr>

    @foreach($slots as $slot)
        <div class="day-header">{{ $slot->day_title }}</div>
        <table>
            <thead>
            <tr>
                <th style="width: 12%;">Batch</th>
                @foreach($day_wise_slots as $timeslot)
                    @if ($slot->id == $timeslot->day_id)
                        <th>{{ date('g:i a', strtotime($timeslot->time_slot->from)).'-'.date('g:i a', strtotime($timeslot->time_slot->to)) }}</th>
                    @endif
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($sections as $section)
                <tr>
                    <td style="font-weight: bold; text-align: left;">
                        {{ $section->department_name.'-'.$section->batch_no.'-'.$section->slug }}
                        {{ $section->section_name ? '- '.$section->section_name : '' }}
                    </td>
                    @php
                        $skipped_slots = [];
                    @endphp
                    @foreach($day_wise_slots as $index => $timeslot)
                        @if ($slot->id == $timeslot->day_id)
                            @php $flag = 1 @endphp
                        @else 
                            @php $flag = 0 @endphp
                        @endif

                        @if($flag == 1)
                            @if(in_array($timeslot->id, $skipped_slots))
                                @continue
                            @endif

                            @php
                                $current_routine = null;
                                foreach($slot->routine as $r) {
                                    if($timeslot->day_id == $r->day_id && $timeslot->time_slot_id == $r->time_slot_id && $r->batch_id == $section->batch_id && $section->section_id == $r->section_id && $r->yearly_session_id == $y_session_id) {
                                        $current_routine = $r;
                                        break;
                                    }
                                }

                                $colspan = 1;
                                if ($current_routine) {
                                    $next_index = $index + 1;
                                    while(isset($day_wise_slots[$next_index])) {
                                        $next_timeslot = $day_wise_slots[$next_index];
                                        if ($next_timeslot->day_id != $slot->id) {
                                            break;
                                        }
                                        $next_routine = null;
                                        foreach($slot->routine as $r) {
                                            if($next_timeslot->day_id == $r->day_id && $next_timeslot->time_slot_id == $r->time_slot_id && $r->batch_id == $section->batch_id && $section->section_id == $r->section_id && $r->yearly_session_id == $y_session_id) {
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
                                            $skipped_slots[] = $next_timeslot->id;
                                            $next_index++;
                                        } else {
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            <td colspan="{{ $colspan }}" class="{{ $current_routine ? ($current_routine->course->course_type == '0' ? 'bg-warning' : 'bg-danger') : '' }}">
                                @if($current_routine)
                                    {{ $current_routine->course->course_code }} {{ $current_routine->course->course_type == '0' ? '(T)': '(L)' }} <br>
                                    {{ $current_routine->room->building.'-'.$current_routine->room->room_no }} <br>
                                    {{ $current_routine->teacher->user->firstname." ".$current_routine->teacher->user->lastname }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
</div>
</body>
</html>
