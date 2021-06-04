@extends('layouts.app')

@section('title', 'Batch')

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
                            @if (Session::has('error'))
                                <div class="alert-dismissable alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('error') }}
                                </div>
                            @endif
                            <div class="mt-0 header-title mb-4">
                                Batch - Create
                                <a href="{{ route('batches.index') }}" class="btn btn-sm btn-primary float-right">Batch List</a>
                            </div>
                            {!! Form::open(['route' =>'batches.store']) !!}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group @if($errors->has('batch_no')) has-error @endif">
                                        {!! Form::label('Batch No') !!}
                                        {!! Form::number('batch_no', 1, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('batch_no'))
                                            <span class="help-block">
                                            {!! $errors->first('batch_no') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Department') !!}
                                        {!! Form::select('department_id', $departments, null ,['class'=> 'form-control']) !!}

                                        @if ($errors->has('department_id'))
                                            <span class="help-block">
                                            {!! $errors->first('department_id') !!}
                                        </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Shift') !!}
                                        {!! Form::select('shift_id', $shifts, null ,['class'=> 'form-control']) !!}

                                        @if ($errors->has('shift_id'))
                                            <span class="help-block">
                                            {!! $errors->first('shift_id') !!}
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



