@extends('layouts.app')

@section('title', 'Assign Course')

@section('stylesheets')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
                                Assign Course
                                <a href="{{ route('assign_courses.index') }}" class="btn btn-sm btn-primary float-right">Assigned Course List</a>
                            </div>

                          {!! Form::open(['route' =>['assign_courses.update', $assign_course->id], 'method'=>'put'])!!}

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group @if($errors->has('session_id')) has-error @endif">
                                        {!! Form::label('Session') !!}
                                        {{--                                    {!! Form::select('session_id', null, ['class'=> 'form-control']) !!}--}}
                                        <select name="session_id" id="" class="form-control">
                                            <option value="">Select</option>
                                            @foreach($sessions as $session)
                                                <option {{ $assign_course->session_id == $session->id ? 'selected' : '' }} value={{ $session->id }} {{ old($session->id) }}> {{ $session->session->session_name. '-' . $session->year}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('session_id'))
                                            <span class="help-block">
                                    {!! $errors->first('session_id') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group @if($errors->has('teacher_id')) has-error @endif">
                                        {!! Form::label('Teacher') !!}
                                        {{--                                    {!! Form::select('teacher_id', null, ['class'=> 'form-control']) !!}--}}
                                        <select class="form-control" name="teacher_id" id="">
                                            <option value="">Select</option>
                                            @foreach($teachers as $teacher)
                                                <option value={{ $teacher->id }} {{ old($teacher->id) }} {{ $assign_course->teacher_id == $teacher->id ? 'selected' : '' }}> {{ $teacher->user->firstname." ".$teacher->user->lastname }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('teacher_id'))
                                            <span class="help-block">
                                        {!! $errors->first('teacher_id') !!}
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">

                                            {!! Form::label('course Name') !!}


                                            <select name="courses[]" class="select2 form-control select2-multiple"
                                                    multiple="multiple" data-placeholder="Choose courses">
                                                <optgroup>

                                                    @foreach($courses as $course)
                                                        @php $flag = 0 @endphp
                                                        @foreach(explode(',', $assign_course->courses) as $course_id)
                                                            @if($course_id == $course->id)
                                                                @php($flag = 1)
                                                            @endif
                                                        @endforeach

                                                        <option
                                                            {{ $flag == 1 ? 'selected' : '' }} value={{ $course->id }} > {{ $course->course_code." | ".$course->course_name. " | "  }} {{ $course->course_type == 0 ? 'Theory' : 'Sessional' }}
                                                        </option>

                                                    @endforeach
                                                </optgroup>
                                            </select>

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
@push('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(".select2").select2();

        // $(".select2-limiting").select2({
        //     maximumSelectionLength: 2
        // });
    </script>
@endpush




