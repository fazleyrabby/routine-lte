@extends('layouts.app')

@section('title', 'Room')

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
                                Room - Edit
                                <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-primary float-right">Room List</a>
                            </div>
                            {!! Form::open(['route' => ['rooms.update', $room->id], "method"=>"put" ])!!}

                            <div class="form-group row @if($errors->has('building')) has-error @endif">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Building') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::text('building', $room->building, ['class'=> 'form-control']) !!}
                                    @if ($errors->has('building'))
                                        <span class="help-block">
                                            {!! $errors->first('building') !!}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row @if($errors->has('room_no')) has-error @endif">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Room No') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::text('room_no', $room->room_no, ['class'=> 'form-control']) !!}
                                    @if ($errors->has('room_no'))
                                        <span class="help-block">
                                            {!! $errors->first('room_no') !!}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row @if($errors->has('capacity')) has-error @endif">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Capacity') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::number('capacity', $room->capacity, ['class'=> 'form-control']) !!}
                                    @if ($errors->has('room_no'))
                                        <span class="help-block">
                                            {!! $errors->first('capacity') !!}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Room Type') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::select('room_type', [0=> 'Theory',1 => 'Lab'], $room->room_type ,['class'=> 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Status') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::select('is_active',['no'=> 'Inactive','yes' => 'Active'], $room->is_active ,['class'=> 'form-control']) !!}
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



