@extends('layouts.app')

@section('title', 'Section Wise Student')

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
                                Section wise Student - Assign
                                <a href="{{ route('section_students.index') }}" class="btn btn-sm btn-primary float-right">Section wise student list</a>
                            </div>
                            {!! Form::open(['route' =>'batches.store']) !!}

{{--                                <table id="datatable-buttons"--}}
{{--                                       class="table table-striped table-bordered dt-responsive nowrap"--}}
{{--                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>#</th>--}}
{{--                                        <th>Batch</th>--}}
{{--                                        <th>Student Numbers</th>--}}
{{--                                        <th>Section wise student</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}


{{--                                    <tbody>--}}

{{--                                    @foreach($batches as $batch)--}}
{{--                                    <tr>--}}
{{--                                        <td></td>--}}
{{--                                    </tr>--}}
{{--                                    @endforeach --}}
{{--                                    </tbody>--}}

{{--                                </table>--}}




                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('Batch') !!}
                                            {{--                                        {!! Form::select('batch_id', $batches, null ,['class'=> 'form-control']) !!}--}}
                                            <select name="batch_id" id="" class="form-control">
                                                <option value="">Select Batch</option>
                                                @foreach($batches as $batch)
                                                    <option value={{ $batch->id }} > {{ $batch->department->department_name. '-' . $batch->batch_no. '-' . $batch->shift->slug}}</option>
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
{{--                                            {!! Form::label('Total Student Number') !!}--}}
{{--                                            {!! Form::text('number_of_student', null ,['class'=> 'form-control']) !!}--}}
                                            @foreach($sections as $section)




                                                <input type="checkbox" id="{{ $section->slug }}" name="section[]" value={{ $section->id }}>

                                                <label for="{{ $section->slug }}">{{ $section->section_name }}</label>
                                                <input type="number" name="number_of_student" class="form-control-sm" value="{{ $section->slug == 'a' ? 50 : 0 }}">
                                                <br>


                                            @endforeach

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



