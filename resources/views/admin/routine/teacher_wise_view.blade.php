@extends('layouts.app')

@section('title', 'Routine')

@section('stylesheets')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <!-- end row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-0 header-title mb-4">
                                Routine View for
                                <strong>{{ $teacher_detail->user->firstname." ".$teacher_detail->user->lastname }}</strong>
                            </div>

                            <a class="btn btn-danger float-right" href="{{ route('teacher_search') }}">Back</a>

                            <form action="{{ route('teacher_wise_print') }}" method="post">
                                @csrf
                                <input type="hidden" name="teacher_id" value="{{  $teacher_detail->id }}">
                                <input type="hidden" name="y_session_id" value="{{  $y_session_id }}">
                                <button type="submit" class="btn btn-primary">
                                    Download as PDF
                                </button>
                            </form>


                            <br>
                            <br>

                            @if (Session::has('message'))
                                <div class="alert-dismissable alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('message') }}
                                </div>
                            @endif
                            @if (Session::has('delete-message'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('delete-message') }}
                                </div>
                            @endif


                            <table class="table table-bordered dt-responsive nowrap"
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
                                                @php
                                                    $ColumnPrinted = false; $course_code = $course_name = $course_type = $room = $faculty_details = ''; $slot_count = count($slot->routine) @endphp
                                                @foreach($slot->routine as $key => $routine)

                                                    @php($section_name = "")

                                                    @if($routine->section_id && $routine->batch->student)
                                                        @foreach($routine->batch->student->section_student as $section_student)
                                                            @if($section_student->section->id == $routine->section_id)
                                                                @php($section_name = "-".$section_student->section->section_name)
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($timeslot->day->id == $routine->day_id && $timeslot->time_slot->id == $routine->time_slot_id &&  $routine->yearly_session_id == $y_session_id)
                                                        @php($course_code = $routine->course->course_code)
                                                        @php($course_type = $routine->course->course_type == '0' ? ' (T)': ' (L)')
                                                        @php($type = $routine->course->course_type)
                                                        @php($course_name = $routine->course->course_name)
                                                        @php($room = $routine->room->building.'-'.$routine->room->room_no)
                                                        @php($faculty_details = $routine->batch->department->department_name."-".$routine->batch->batch_no."-".$routine->batch->shift->slug.$section_name)

                                                    @endif

{{--                                                    @if($key != $slot_count - 1)--}}
{{--                                                        @if($course_code == $slot->routine[$key+1]->course->course_code && $type == 1)--}}
{{--                                                            @php($ColumnPrinted = true)--}}
{{--                                                            @php($colspan = 2)--}}
{{--                                                        @else--}}
{{--                                                            @php($colspan = 1)--}}
{{--                                                            @php($ColumnPrinted = false)--}}
{{--                                                        @endif--}}
{{--                                                    @endif--}}
                                                @endforeach

{{--                                                    @if($ColumnPrinted == false)--}}
{{--                                                    <td class="text-center font-weight-bold" colspan="{{ $colspan }}">--}}
{{--                                                        {{ $course_code.$course_type }} <br>--}}
{{--                                                        {{ $course_name }} <br>--}}
{{--                                                        {{ $room }} <br>--}}
{{--                                                        {{ $faculty_details }} <br>--}}
{{--                                                    </td>--}}
{{--                                                    @php($colspan = 1)--}}
{{--                                                    @php($ColumnPrinted = true)--}}
{{--                                                    @endif--}}
                                                <td class="text-center font-weight-bold" colspan="{{ $colspan }}">
                                                    {{ $course_code.$course_type }} <br>
                                                    {{ $course_name }} <br>
                                                    {{ $room }} <br>
                                                    {{ $faculty_details }} <br>
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
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end page content-->

    </div>
    <!-- page wrapper end -->
@endsection


@push('script')

    <script>
        let forms = document.querySelectorAll('.form');
        forms.forEach((form) => {
            $(form).on('submit', function (e) {
                e.preventDefault();
                let alertBox = e.target.querySelector('.alert_box');
                let data = $(this).serialize();
                $.ajax({
                    type: "post",
                    url: '{{route("routine_create")}}',
                    data: data,
                    dataType: "json",
                    success: function (data) {
                        if (data.type == 'error') {
                            alertBox.innerHTML = `<div class="alert-dismissable alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button><strong>${data.text}</strong></div>`;
                        } else {
                            alert(data.text);
                            location.reload();
                        }
                    }
                });
            });
        })
    </script>

@endpush

