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
                                Routine View for <strong>{{ $batch->department_name."-".$batch->batch_no."-".$batch->slug }}{{ $batch->section_name != '' ? " - ".$batch->section_name : '' }}</strong>
                                {{--                                <a href="{{ route('ranks.create') }}" class="btn btn-sm btn-primary float-end">Add New</a>--}}
                            </div>

                            <form action="{{ route('routine_print') }}" method="post">
                                @csrf
                                <input type="hidden" name="batch_id" value="{{  $batch->batch_id.",".$batch->section_id }}">
                                <input type="hidden" name="y_session_id" value="{{  $y_session_id }}">
                                <button type="submit" class="btn btn-primary">
                                    Download as PDF
                                </button>
                            </form>
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


                            <table class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                {{--                                    <thead>--}}
                                {{--                                    --}}
                                {{--                                    </thead>--}}

                                <tbody>
                                @foreach($slots as $slot)
                                    @php $count = 0; @endphp
                                    @if($slot->slug == 'SAT' || $slot->slug == 'FRI')
                                    <tr>
                                        <th class="p-0" style="overflow: hidden">
                                            <span class="px-3 py-2 d-block border-bottom">Day/Time </span>
                                        </th>


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
                                                <th colspan="{{ $colspan }}" class="p-0 text-center" style="overflow: hidden">
                                                    <span class="px-3 py-2 d-block">{{ date('g:i a', strtotime($timeslot->time_slot->from)).'-'.date('g:i a', strtotime($timeslot->time_slot->to)) }}</span>
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
                                                    }
                                                @endphp

                                                <td class="text-center font-weight-bold" colspan="{{ $colspan }}">
                                                    @if($current_routine)
                                                        {{ $current_routine->course->course_code }}-{{ $current_routine->course->course_type == '0' ? '(T)': '(L)' }} <br>
                                                        {{ $current_routine->course->course_name }} <br>
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




