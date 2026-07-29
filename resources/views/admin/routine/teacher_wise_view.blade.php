@extends('layouts.app')

@section('title', 'Routine')

@section('stylesheets')
    <!-- DataTables -->
    <link href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
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

                            <a class="btn btn-danger float-end" href="{{ route('teacher_search') }}">Back</a>

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
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('message') }}
                                </div>
                            @endif
                            @if (Session::has('delete-message'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">x
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
                                                    $course_code = $course_name = $course_type = $room = $faculty_details = '';
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
                                                        if($current_routine->section_id && $current_routine->batch->student) {
                                                            foreach($current_routine->batch->student->section_student as $section_student) {
                                                                if($section_student->section->id == $current_routine->section_id) {
                                                                    $section_name = "-".$section_student->section->section_name;
                                                                }
                                                            }
                                                        }

                                                        $course_code = $current_routine->course->course_code;
                                                        $course_type = $current_routine->course->course_type == '0' ? ' (T)' : ' (L)';
                                                        $course_name = $current_routine->course->course_name;
                                                        $room = $current_routine->room->building.'-'.$current_routine->room->room_no;
                                                        $faculty_details = $current_routine->batch->department->department_name."-".$current_routine->batch->batch_no."-".$current_routine->batch->shift->slug.$section_name;
                                                    }
                                                @endphp
                                                <td class="text-center font-weight-bold" colspan="{{ $colspan }}">
                                                    @if($current_routine)
                                                        {{ $course_code.$course_type }} <br>
                                                        {{ $course_name }} <br>
                                                        {{ $room }} <br>
                                                        {{ $faculty_details }} <br>
                                                    @endif
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
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">x
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

