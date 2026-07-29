

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Robots" content="index,follow"/>
    {{--    <link href="{{asset ('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" type="text/css" href="{{asset ('backend/dist/css/report.css') }}" media="all" />

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
                        @php
                            $skipped_slots = [];
                        @endphp
                        @foreach($day_wise_slots as $index => $timeslot)

                            @php $flag = 0 @endphp

                            @if ($slot->id == $timeslot->day_id)
                                @php $flag = 1 @endphp

                            @else @php $flag = 0 @endphp
                            @endif

                            @if($flag == 1)
                                @if(in_array($timeslot->id, $skipped_slots))
                                    @continue
                                @endif

                                @php
                                    $current_routine = null;
                                    foreach($slot->routine as $routine) {
                                        if($timeslot->day->id == $routine->day_id && $timeslot->time_slot->id == $routine->time_slot_id &&  $routine->yearly_session_id == $y_session_id) {
                                            $current_routine = $routine;
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
                                                if($next_timeslot->day->id == $r->day_id && $next_timeslot->time_slot->id == $r->time_slot_id &&  $r->yearly_session_id == $y_session_id) {
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

                                        $section_name = "";
                                        if($current_routine->section_id) {
                                            foreach($current_routine->batch->student->section_student as $section_student) {
                                                if($section_student->section->id == $current_routine->section_id) {
                                                    $section_name = "-".$section_student->section->section_name;
                                                }
                                            }
                                        }
                                    }
                                @endphp

                                <td colspan="{{ $colspan }}" style="font-weight: bold; text-align: center">
                                    @if($current_routine)
                                        {{ $current_routine->course->course_code }}-{{ $current_routine->course->course_type == '0' ? '(T)': '(L)' }} <br>
                                        {{ $current_routine->room->building.'-'.$current_routine->room->room_no }} <br>
                                        {{ $current_routine->batch->department->department_name."-".$current_routine->batch->batch_no."-".$current_routine->batch->shift->slug.$section_name }}
                                    @endif
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
