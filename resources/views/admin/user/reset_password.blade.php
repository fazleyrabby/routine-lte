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
                                Teacher - Create
                                <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-primary float-right">Teacher List</a>
                            </div>
                            {!! Form::open(['route' =>'reset_password_with_token'])!!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('email')) has-error @endif">
                                        {!! Form::label('Email') !!}
                                        {!! Form::text('email', Auth::user()->email, ['class'=> 'form-control']) !!}
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                            {!! $errors->first('email') !!}
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

    </div>
    <!-- page wrapper end -->
@endsection

@push('script')
    <script src="{{ asset('assets/pages/form-advanced.js') }}"></script>
@endpush



