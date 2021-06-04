@extends('layouts.app')

@section('title', 'Rank')

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
                            Rank - Create
                            <a href="{{ route('ranks.index') }}" class="btn btn-sm btn-primary float-right">Rank List</a>
                        </div>
                        {!! Form::open(['route' =>'ranks.store'])!!}

                        <div class="form-group row @if($errors->has('rank')) has-error @endif">
                            <div class="col-md-2 align-self-center">
                                {!! Form::label('rank Name') !!}
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('rank', null, ['class'=> 'form-control']) !!}
                                @if ($errors->has('rank'))
                                <span class="help-block">
                                    {!! $errors->first('rank') !!}
                                </span>
                                @endif
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



