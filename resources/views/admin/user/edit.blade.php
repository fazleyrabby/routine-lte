@extends('layouts.app')

@section('title', 'Users')

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
                                User - Update
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-primary float-right">Back</a>
                            </div>
                            {!! Form::open(['route' => ['users.update', $user->id], 'method'=>'put','enctype'=> 'multipart/form-data'])!!}

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('firstname')) has-error @endif">
                                        {!! Form::label('First Name') !!}
                                        {!! Form::text('firstname', $user->user->firstname, ['class'=> 'form-control']) !!}
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
                                        {!! Form::text('lastname',  $user->user->lastname, ['class'=> 'form-control']) !!}
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
                                        {!! Form::text('username',  $user->user->username , ['class'=> 'form-control']) !!}
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
                                        {!! Form::date('date_of_birth', $user->user->date_of_birth, ['class'=> 'form-control','id'=>'example-date-input2']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('Gender') !!}
                                        {!! Form::select('gender', [1=> 'Male',2 => 'Female'], $user->user->gender ,['class'=> 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('email')) has-error @endif">
                                        {!! Form::label('E-mail') !!}
                                        {!! Form::text('email', $user->user->email, ['class'=> 'form-control']) !!}
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
                                        {!! Form::select('role' , ['superadmin' => 'Super admin','admin' => 'Admin','subadmin'=> 'Sub Admin', 'user'=> 'user'], $user->user->role ,['class'=> 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('Join date') !!}
                                        {!! Form::date('join_date', $user->join_date, ['class'=> 'form-control','id'=>'example-date-input']) !!}
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('Rank') !!}
                                        {!! Form::select('rank_id', $ranks, $user->rank->id ,['class'=> 'form-control']) !!}
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
                                    Prev Photo : <img width="100" src={{ asset('storage/uploads/' . $user->user->photo)  }} alt="">
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



