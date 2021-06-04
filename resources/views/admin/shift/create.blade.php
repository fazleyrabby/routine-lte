@extends('layouts.app')

@section('title', 'Shift')

@section('stylesheets')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-xl-6 offset-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-0 header-title mb-4">
                                    Shift - Create
                                    <a href="{{ route('shifts.index') }}" class="btn btn-sm btn-primary float-right">Shift List</a>
                                </div>
                                {!! Form::open(['route' =>'shifts.store'])!!}
                                <div class="form-group row @if($errors->has('shift_name')) has-error @endif">
                                    <div class="col-md-2 align-self-center">
                                        {!! Form::label('Shift Name') !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::text('shift_name', null, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('shift_name'))
                                            <span class="help-block">
                                            {!! $errors->first('shift_name') !!}
                                            </span>
                                        @endif
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

    </div>
    <!-- page wrapper end -->
@endsection



