@extends('layouts.app')

@section('title', 'Teacher')

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
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-0 header-title mb-4">
                                Teacher - Update
                                <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-primary float-right">Teacher List</a>
                            </div>
                            {!! Form::open(['route' =>['teachers.update', $teacher->id], 'method'=>'put','enctype'=> 'multipart/form-data'])!!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('firstname')) has-error @endif">
                                        {!! Form::label('First Name') !!}
                                        {!! Form::text('firstname', $teacher->user->firstname, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('firstname'))
                                            <span class="help-block">
                                            {!! $errors->first('firstname') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('lastname')) has-error @endif">
                                        {!! Form::label('Last Name') !!}
                                        {!! Form::text('lastname',  $teacher->user->lastname, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('lastname'))
                                            <span class="help-block">
                                            {!! $errors->first('lastname') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('username')) has-error @endif">
                                        {!! Form::label('username') !!}
                                        {!! Form::text('username',  $teacher->user->username , ['class'=> 'form-control']) !!}
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                            {!! $errors->first('username') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('date_of_birth')) has-error @endif">
                                        {!! Form::label('Date of Birth') !!}
                                        {!! Form::date('date_of_birth', $teacher->user->date_of_birth, ['class'=> 'form-control','id'=>'example-date-input2']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('Gender') !!}
                                        {!! Form::select('gender', [1=> 'Male',2 => 'Female'], $teacher->user->gender ,['class'=> 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('email')) has-error @endif">
                                        {!! Form::label('E-mail') !!}
                                        {!! Form::text('email', $teacher->user->email, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                            {!! $errors->first('email') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('Role') !!}
                                        {!! Form::select('role' , ['admin' => 'ADMIN','user' => 'USER'] , $teacher->user->role ,['class'=> 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('Join date') !!}
                                        {!! Form::date('join_date', $teacher->join_date, ['class'=> 'form-control','id'=>'example-date-input']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('Department') !!}
                                        {!! Form::select('department_id',$departments, $teacher->department->id ,['class'=> 'form-control']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('contact')) has-error @endif">
                                        {!! Form::label('Contact') !!}
                                        {!! Form::text('contact', $teacher->user->contact, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('contact'))
                                            <span class="help-block">
                                            {!! $errors->first('contact') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('Rank') !!}
                                        {!! Form::select('rank_id', $ranks, $teacher->rank->id ,['class'=> 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('photo')) has-error @endif">
                                        {!! Form::label('Photo','Photo', ['style'=> 'display:block;']) !!}
                                        {!! Form::file('photo', null, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('photo'))
                                            <span class="help-block text-danger">
                                            {!! $errors->first('photo') !!}
                                        </span>
                                        @endif


                                    </div>
                                     Prev Photo : <img width="100" src={{ asset('storage/uploads/' . $teacher->user->photo)  }} alt="">
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('slug')) has-error @endif">
                                        {!! Form::label('Slug / TN') !!}
                                        {!! Form::text('slug', $teacher->slug , ['class'=> 'form-control']) !!}
                                        @if ($errors->has('slug'))
                                            <span class="help-block">
                                            {!! $errors->first('slug') !!}
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



