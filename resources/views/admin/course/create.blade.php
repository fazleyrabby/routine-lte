@extends('layouts.app')

@section('title', 'Course')

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
                                    Course - Create
                                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-primary float-right">Course List</a>
                                </div>
                                {!! Form::open(['route' =>'courses.store'])!!}

                                <div class="form-group row @if($errors->has('course_name')) has-error @endif">
                                    <div class="col-md-2 align-self-center">
                                        {!! Form::label('course Name') !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::text('course_name', null, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('course_namecourse_name'))
                                            <span class="help-block">
                                            {!! $errors->first('course_name') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row @if($errors->has('course_code')) has-error @endif">
                                    <div class="col-md-2 align-self-center">
                                        {!! Form::label('course Code') !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::text('course_code', null, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('course_code'))
                                            <span class="help-block">
                                            {!! $errors->first('course_code') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row @if($errors->has('credit')) has-error @endif">
                                    <div class="col-md-2 align-self-center">
                                        {!! Form::label('Credit') !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::text('credit', null, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('credit'))
                                            <span class="help-block">
                                            {!! $errors->first('credit') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-2 align-self-center">
                                        {!! Form::label('Course Type') !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::select('course_type', [0=> 'Theory',1 => 'Sessional'], null ,['class'=> 'form-control']) !!}
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



