@extends('layouts.app')

@section('title', 'Offday')

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
                <div class="col-xl-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-0 header-title mb-4">
                                Assign offday for <strong>{{ strtoupper($teacher->user->firstname)." ".strtoupper($teacher->user->lastname) }}</strong>
                            </div>
                            @if (Session::has('message'))
                                <div class="alert-dismissable alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('message') }}
                                </div>
                            @endif
                            {!! Form::open(['route' =>'assign_teacher_offday' ])!!}
                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                            <input type="hidden" name="user_id" value="{{ $teacher->user->id }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        @php $flag = 0 @endphp
                                        @foreach($days as $day)
                                            @foreach($teacher->teachers_offday as $offday)
                                                @if($offday->day_id == $day->id)
                                                    @php($flag = 1) @break
                                                @else
                                                    @php($flag = 0)
                                                @endif
                                            @endforeach
                                            <input type="checkbox" name="offday[]" {{ $flag == 1 ? 'checked' : '' }} id="{{ $day->slug }}" value={{ $day->id }}>
                                            <label for="{{ $day->slug }}">{{ $day->day_title }}</label>
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {!! Form::submit('Assign',['class' => 'btn btn-sm btn-primary'] ) !!}

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



