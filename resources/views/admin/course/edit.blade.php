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

                            {!! Form::open(['route' =>['courses.update', $course->id], 'method'=>'put'])!!}

                            <div class="form-group row @if($errors->has('course_name')) has-error @endif">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('course Name') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::text('course_name', $course->course_name, ['class'=> 'form-control']) !!}
                                    @if ($errors->has('course_name'))
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
                                    {!! Form::text('course_code', $course->course_code, ['class'=> 'form-control']) !!}
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
                                    {!! Form::text('credit', $course->credit, ['class'=> 'form-control']) !!}
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
                                    {!! Form::select('course_type', [0=> 'Theory',1 => 'Sessional'], $course->course_type ,['class'=> 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Status') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::select('is_active', ['no'=> 'Inactive','yes' => 'Active'], $course->is_active ,['class'=> 'form-control']) !!}
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



