@extends('layouts.app')

@section('title', 'Time Slot')

@section('stylesheets')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
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
                            <div class="mt-0 header-title mb-4">
                                Time Slot - Update
                                <a href="{{ route('time_slots.index') }}" class="btn btn-sm btn-primary float-right">Time Slot List</a>
                            </div>
                            {!! Form::open(['route' =>['time_slots.update', $time_slot->id], 'method'=>'put','enctype'=> 'multipart/form-data']) !!}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group @if($errors->has('shift')) has-error @endif">
                                        {!! Form::label('Shift Name') !!}
                                        {!! Form::select('shift', $shifts, $time_slot->shift_id, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('shift'))
                                            <span class="help-block">
                                        {!! $errors->first('shift') !!}
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->has('from')) has-error @endif">
                                        {!! Form::label('From') !!}
                                        {!! Form::time('from', $time_slot->from, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('from'))
                                            <span class="help-block">
                                            {!! $errors->first('from') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group @if($errors->has('to')) has-error @endif">
                                        {!! Form::label('To') !!}
                                        {!! Form::time('to', $time_slot->to, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('to'))
                                            <span class="help-block">
                                            {!! $errors->first('to') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {!! Form::submit('Update',['class' => 'btn btn-sm btn-warning'] ) !!}
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

    </div>
    <!-- page wrapper end -->
@endsection

@push('script')
    <script src="{{ asset('assets/pages/form-advanced.js') }}"></script>
@endpush



