@extends('layouts.app')

@section('title', 'Shift Session')

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
                                Session - Update
                                <a href="{{ route('shift_sessions.index') }}" class="btn btn-sm btn-primary float-right">Session List</a>
                            </div>
                            {!! Form::open(['route' => ['shift_sessions.update', $shiftSession->id], "method"=>"put" ])!!}

                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Shift') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::select('shift_id', $shifts, $shiftSession->shift_id ,['class'=> 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Session') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::select('session_id', $sessions, $shiftSession->session_id ,['class'=> 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Status') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::select('is_active', ['no'=> 'Inactive','yes' => 'Active'], $shiftSession->is_active ,['class'=> 'form-control']) !!}
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



