@extends('layouts.app')

@section('title', 'Section')

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
                                Section - Update
                                <a href="{{ route('sections.index') }}" class="btn btn-sm btn-primary float-right">Section List</a>
                            </div>
                            {!! Form::open(['route' => ['sections.update', $section->id], "method"=>"put" ])!!}

                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Parent') !!}
                                </div>
                                <div class="col-md-10">
{{--                                    {!! Form::select('parent', $parent, $section->parent ,['class'=> 'form-control']) !!}--}}
                                    <select class="form-control" name="parent" id="">
                                        <option value="0">Select section</option>
                                        @foreach($parents as $parent)
                                            <option {{ $section->parent == $parent->id ? 'selected' : '' }} value="{{ $parent->id }}">{{ $parent->section_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row @if($errors->has('section_name')) has-error @endif">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Section') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::text('section_name', $section->section_name, ['class'=> 'form-control']) !!}
                                    @if ($errors->has('section_name'))
                                        <span class="help-block">
                                    {!! $errors->first('section_name') !!}
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row @if($errors->has('type')) has-error @endif">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Section Type') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::select('type', ['theory' => 'Theory','lab' => 'Lab'], $section->type ,['class'=> 'form-control']) !!}
                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                    {!! $errors->first('type') !!}
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Status') !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::select('is_active', ['no'=> 'Inactive','yes' => 'Active'], $section->is_active ,['class'=> 'form-control']) !!}
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



