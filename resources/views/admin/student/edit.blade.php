@extends('layouts.app')

@section('title', 'Student')

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
                                Student - Create
                                <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary float-right">Student List</a>
                            </div>
{{--                            {!! Form::open(['route' =>'students.update'])!!}--}}

                                {!! Form::open(['route' =>['students.update', $student->id], 'method'=>'put'])!!}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Batch') !!}
                                        {{--                                        {!! Form::select('batch_id', $batches, null ,['class'=> 'form-control']) !!}--}}
                                        <select name="batch_id" id="" class="form-control">
                                            @foreach($batches as $batch)
                                                <option  {{ $student->batch_id == $batch->id ? "selected" : "" }} value={{ $batch->id }}> {{ $batch->department->department_name. '-' . $batch->batch_no. '-' . $batch->shift->slug}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('batch_id'))
                                            <span class="help-block">
                                            {!! $errors->first('batch_id') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Session') !!}
{{--                                        {{ $sessions }}--}}
                                        <select name="yearly_session_id" id="" class="form-control">
                                            @foreach($sessions as $session)

                                                <option {{ $student->yearly_session_id == $session->id ? "selected" : "" }} value={{ $session->id }} > {{ $session->session->session_name. '-' . $session->year}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('session'))
                                            <span class="help-block">
                                            {!! $errors->first('session') !!}
                                        </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Total Student Number') !!}
                                        {!! Form::number('number_of_student', $student->number_of_student ,['class'=> 'form-control']) !!}

                                        @if ($errors->has('number_of_student'))
                                            <span class="help-block">
                                            {!! $errors->first('number_of_student') !!}
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



