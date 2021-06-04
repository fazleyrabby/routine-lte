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
                <!-- end row -->
                <div class="row">
                    <div class="col-xl-6 offset-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-0 header-title mb-4">
                                    Shift - Edit
                                    <a href="{{ route('shifts.index') }}" class="btn btn-sm btn-primary float-right">Shift List</a>
                                </div>
                                {!! Form::open(['route' => ['shifts.update', $shift->id], 'method'=>'put'])!!}

                                <div class="form-group row @if($errors->has('shift_name')) has-error @endif">
                                    <div class="col-md-2 align-self-center">
                                        {!! Form::label('Shift Name') !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::text('shift_name', $shift->shift_name, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('shift_name'))
                                            <span class="help-block">
                                            {!! $errors->first('shift_name') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-2 align-self-center">
                                        {!! Form::label('Status') !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::select('is_active', ['no'=> 'Inactive','yes' => 'Active'], isset($shift->is_active) ? $shift->is_active : null,['class'=> 'form-control']) !!}
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



