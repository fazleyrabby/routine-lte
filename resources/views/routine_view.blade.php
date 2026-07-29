<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Routine View</title>
    <link href="{{ asset('backend/tabler/css/tabler.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/tabler/css/tabler-themes.css') }}" rel="stylesheet" />
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
</head>
<body>
    <script src="{{ asset('backend/tabler/js/tabler-theme.min.js') }}"></script>
    <div class="page">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <h4 class="text-center mt-4">Class schedule for <strong>{{ $batch->department_name."-".$batch->batch_no."-".$batch->slug }}{{ $batch->section_name != '' ? " - ".$batch->section_name : '' }} ({{ $batch->session_name."-".$batch->year }})</strong></h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <a class="btn btn-danger float-end" href="{{ route('routine') }}">Go Back</a>
                                <form action="{{ route('routine_print') }}" method="post" class="float-end me-2">
                                    @csrf
                                    <input type="hidden" name="batch_id" value="{{ $batch->batch_id.",".$batch->section_id }}">
                                    <input type="hidden" name="y_session_id" value="{{ $y_session_id }}">
                                    <button type="submit" class="btn btn-primary">Download as PDF</button>
                                </form>
                            </div>

                            <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tbody>
                                @foreach($slots as $slot)
                                    @php $count = 0; @endphp
                                    @if($slot->slug == 'SAT' || $slot->slug == 'FRI')
                                        <tr>
                                            <th class="p-0" style="overflow: hidden">
                                                <span class="px-3 py-2 d-block border-bottom">Day/Time</span>
                                            </th>
                                            @php $count = 0; @endphp
                                            @foreach($day_wise_slots as $key => $timeslot)
                                                @php
                                                    $diff = intval((strtotime($timeslot->time_slot->to) - strtotime($timeslot->time_slot->from))/3600);
                                                    $flag = 0; $colspan = '';
                                                    if ($slot->id == $timeslot->day_id) { $flag = 1; $count++; } else { $flag = 0; }
                                                    if($diff > 2 && $count < 4) { $colspan = 2; }
                                                @endphp
                                                @if($flag == 1)
                                                    <th colspan="{{ $colspan }}" class="p-0 text-center" style="overflow: hidden">
                                                        <span class="px-3 py-2 d-block">{{ date('g:i a', strtotime($timeslot->time_slot->from)).'-'.date('g:i a', strtotime($timeslot->time_slot->to)) }}</span>
                                                    </th>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>{{ $slot->day_title }}</td>
                                        @foreach($day_wise_slots as $timeslot)
                                            @php
                                                $flag = ($slot->id == $timeslot->day_id) ? 1 : 0;
                                            @endphp
                                            @if($flag == 1)
                                                <td colspan="{{ $colspan }}" class="text-center font-weight-bold">
                                                    @foreach($slot->routine as $routine)
                                                        @if($timeslot->day->id == $routine->day_id && $timeslot->time_slot->id == $routine->time_slot_id && $routine->yearly_session_id == $y_session_id)
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/tabler/js/tabler.min.js') }}" defer></script>
</body>
</html>
