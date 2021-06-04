@extends('layouts.app')

@section('title', 'Password Update')

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
                                Password Edit

                                @if (Session::has('success'))
                                    <div class="alert-dismissable alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                        </button>
                                        {{ Session('success') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8 offset-md-4">
                                {!! Form::open(['route' => ['password_update']])!!}
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">{!! Form::label('Old Password') !!}</div>
                                                <div class="col-md-9">{!! Form::password('old_password',  null, ['class'=> 'form-control']) !!}
                                                    @if (Session::has('message'))
                                                        <div class="text-danger">
                                                            {{ Session('message') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">{!! Form::label('New Password') !!}</div>
                                                <div class="col-md-9">{!! Form::password('password',  null, ['class'=> 'form-control']) !!}
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">{!! Form::label('Re Enter Password') !!}</div>
                                                <div class="col-md-9">{!! Form::password('re_password',  null, ['class'=> 'form-control']) !!}
                                                    @if (Session::has('password'))
                                                        <div class="text-danger">
                                                            {{ Session('password') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::submit('Update',['class' => 'btn btn-sm btn-primary'] ) !!}
                                {!! Form::close() !!}
                            </div>

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



