@extends('layouts.app')

@section('title', 'Course Offer')

@section('stylesheets')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>

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
                                Course offers assign
                                {{--                                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-primary float-right">Course List</a>--}}
                            </div>
                            @if (Session::has('success'))
                                <div class="alert-dismissable alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('success') }}
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert-dismissable alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('error') }}
                                </div>
                            @endif
                            {!! Form::open(['route' =>['course_offers.update', $course_offer->id], 'method'=>'put'])!!}

                            <div class="form-group row @if($errors->has('batch')) has-error @endif">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Batch') !!}
                                </div>
                                <div class="col-md-10">
                                    <select name="batch_id" id="" class="form-control">
                                        @foreach($batches as $batch)
                                            <option
                                                {{ $course_offer->batch_id == $batch->id ? 'selected' : '' }} value={{ $batch->id }} {{ old($batch->id) }}> {{ $batch->department->department_name. '-' . $batch->batch_no. '-' . $batch->shift->slug}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row @if($errors->has('yearly_session')) has-error @endif">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('Session') !!}
                                </div>
                                <div class="col-md-10">
                                    <select name="yearly_session_id" id="" class="form-control">
                                        @foreach($sessions as $session)
                                            <option
                                                {{ $course_offer->yearly_session_id == $session->id ? 'selected' : '' }} value={{ $session->id }} {{ old($session->id) }}> {{ $session->session->session_name. '-' . $session->year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2 align-self-center">
                                    {!! Form::label('course Name') !!}
                                </div>
                                <div class="col-md-10">
                                    <select name="courses[]" class="select2 form-control select2-multiple"
                                            multiple="multiple" data-placeholder="Choose courses">
                                        <optgroup>

                                            @foreach($courses as $course)
                                                @php $flag = 0 @endphp
                                                @foreach(explode(',', $course_offer->courses) as $course_id)
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

                            {!! Form::submit('Update',['class' => 'btn btn-sm btn-primary'] ) !!}

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
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(".select2").select2()
    </script>
@endpush



