

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
            margin-top: 25px;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
<div id="wrapper">

    <div id="">

        <div class="issue_info">

            <center style="font-size: 18px; margin-bottom: 5px">
                    Class schedule for <strong>{{ $batch->department_name."-".$batch->batch_no."-".$batch->slug }}{{ $batch->section_name != '' ? " - ".$batch->section_name : '' }} ({{ $batch->session_name."-".$batch->year }}) </strong>
            </center>

            <hr>

            <table class="table table-striped table-bordered dt-responsive nowrap"
                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <tbody>
                @foreach($slots as $slot)
                    @if($slot->slug == 'SAT' || $slot->slug == 'FRI')
                    <tr>
                        <th width="10px"  style="overflow: hidden">
                            <span>Day/Time </span>
                        </th>

                        @php $count = 0; @endphp
                        @foreach($day_wise_slots as $key => $timeslot)
                            @php
                                $diff = intval((strtotime($timeslot->time_slot->to) - strtotime($timeslot->time_slot->from))/3600);
                            @endphp

                            @php $flag = 0; $colspan = ''; @endphp
                            @if ($slot->id == $timeslot->day_id)
                                @php $flag = 1; $count++; @endphp
                            @else @php $flag = 0; @endphp
                            @endif

                            @if($diff > 2 && $count < 4)
                                @php $colspan = 2; @endphp
                            @endif

                            @if($flag == 1)
                                <th colspan="{{ $colspan }}" style="overflow: hidden;font-size: 11px;font-weight: 400;">
                                    <span>{{ date('g:i a', strtotime($timeslot->time_slot->from)).'-'.date('g:i a', strtotime($timeslot->time_slot->to)) }}</span>
                                </th>
                            @endif
                        @endforeach

                    </tr>
                    @endif

                    <tr>
                        <td style="text-align: center; border: none">
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
                                    @foreach($slot->routine as $routine)
                                        @if($timeslot->day->id == $routine->day_id && $timeslot->time_slot->id == $routine->time_slot_id &&  $routine->yearly_session_id == $y_session_id)
                                            {{ $routine->course->course_code }}-{{ $routine->course->course_type == '0' ? '(T)': '(L)' }} <br>
                                            {{ $routine->course->course_name }} <br>
                                            {{ $routine->room->building.'-'.$routine->room->room_no }} <br>
                                            {{ $routine->teacher->user->firstname." ".$routine->teacher->user->lastname }}
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
