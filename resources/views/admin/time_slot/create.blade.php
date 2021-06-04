@extends('layouts.app')

@section('title', 'Time Slot')

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
                            @if (Session::has('error'))
                                <div class="alert-dismissable alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('error') }}
                                </div>
                            @endif
                            <div class="mt-0 header-title mb-4">
                                Time Slot - Create
                                <a href="{{ route('time_slots.index') }}" class="btn btn-sm btn-primary float-right">Time Slot list</a>
                            </div>
                            {!! Form::open(['route' =>'time_slots.store']) !!}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group @if($errors->has('shift')) has-error @endif">
                                        {!! Form::label('Shift Name') !!}
                                        {!! Form::select('shift', $shifts, null, ['class'=> 'form-control']) !!}
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
                                    <div class="form-group @if($errors->has('lastname')) has-error @endif">
                                        {!! Form::label('From') !!}
                                        {!! Form::time('from', '10:00:00', ['class'=> 'form-control']) !!}
                                        @if ($errors->has('from'))
                                            <span class="help-block">
                                            {!! $errors->first('from') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->has('lastname')) has-error @endif">
                                        {!! Form::label('To') !!}
                                        {!! Form::time('to', '12:00:00', ['class'=> 'form-control']) !!}
                                        @if ($errors->has('to'))
                                            <span class="help-block">
                                            {!! $errors->first('to') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {!! Form::submit('Create',['class' => 'btn btn-sm btn-primary'] ) !!}

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
@endpush



