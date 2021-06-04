@extends('layouts.app')

@section('title', 'Day wise Slot')

@section('stylesheets')
    <link href="{{ asset('assets/plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <!-- DataTables -->
{{--    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"--}}
{{--          type="text/css"/>--}}
{{--    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>--}}
@endsection

@section('content')
    <!-- page wrapper start -->
    <!-- page-title-box -->
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <!-- end row -->
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="card">
                        <div class="card-body">
                            @if (Session::has('message'))
                                <div class="alert-dismissable alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('message') }}
                                </div>
                            @endif
                            <div class="mt-0 header-title mb-4">
                                Assign Time Slots & Class Slot for <strong>{{ $day->day_title }}</strong>
                                <a href="{{ route('day_wise_slots') }}" class="btn btn-sm btn-primary float-right">Daywise Slot list</a>
                            </div>
                            {!! Form::open(['route' =>'day_wise_slot_store']) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" name="day_id" value="{{ $day->id }}">
                                        <table class="w-100 table-bordered table-responsive-md table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Time Range</th>
                                                    <th>Class Slots</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $flag = 0 @endphp
                                            @foreach($time_slots as $time_slot)
                                                @foreach($day->day_wise_slot as $day_wise_slot)
                                                    @if($time_slot->id == $day_wise_slot->time_slot_id)
                                                        @php($flag = 1) @break
                                                    @else
                                                        @php($flag = 0)
                                                    @endif
                                                    @endforeach
                                                    <tr>
                                                    <td>
                                                        <input  type="checkbox" class="slot mx-auto d-block" id="id_{{ $time_slot->id }}" name="day_wise_slot[{{ $time_slot->id}}][time_slot]" {{ $flag == 1 ? 'checked' : '' }} value={{ $time_slot->id }}></td>
                                                    <td>
                                                        <label for="id_{{ $time_slot->id }}">{{ date('g:i a', strtotime($time_slot->from)).'-'.date('g:i a', strtotime($time_slot->to)) }}</label></td>
                                                    <td>
                                                        <input name="day_wise_slot[{{ $time_slot->id }}][class_slot]" data-slot="#id_{{ $time_slot->id }}" value="{{ $flag == 1 ? $day_wise_slot->class_slot : '' }}"  max="" type="number" name="" class="form-control" {{ $flag == 1 ? '' : 'disabled' }}></td>
                                                    </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {!! Form::submit('Assign',['class' => 'btn btn-sm btn-primary'] ) !!}

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end page content-->
@endsection


@push('script')
    <script src="{{ asset('assets/plugins/bootstrap-md-datetimepicker/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-md-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

    <script src="{{ asset('assets/pages/form-advanced.js') }}"></script>


    @push('script')
        <script>
            let sections = document.querySelectorAll('.slot');
            sections.forEach((e) => {
                e.addEventListener('input', event=>{
                    if(event.target.checked == true){
                        //console.log(event.target.id);
                        document.querySelector( `[data-slot="#${event.target.id}"]`).removeAttribute('disabled','false');
                    }else{
                        document.querySelector( `[data-slot="#${event.target.id}"]`).setAttribute('disabled','true');
                    }
                })
            })
        </script>
    @endpush
@endpush



