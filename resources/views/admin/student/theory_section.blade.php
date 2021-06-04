@extends('layouts.app')

@section('title', 'Student')

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
                                Assign Section for <strong>{{ $student->batch->department->department_name ."-". $student->batch->batch_no ."-".$student->batch->shift->slug  }}</strong>
                                Total Students - <strong>{{ $student->number_of_student }}</strong>
                                <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary float-right">Student List</a>
                            </div>
                                <br>
                            {!! Form::open(['route' =>'theory_section_store'])!!}
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <input type="hidden" name="total_students" value="{{ $student->number_of_student }}">
                                <input type="hidden" name="batch_id" value={{ $student->batch->id }}>

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="form-group">
                                        @php $flag = 0 @endphp
                                        @foreach($sections as $section)
                                            @foreach($student->section_student as $section_student)
                                                @if($section->id == $section_student->section_id)
                                                    @php($flag = 1) @break
                                                @else
                                                    @php($flag = 0)
                                                @endif
                                            @endforeach
                                            <input type="checkbox" class="section" id="{{ $section->slug }}" name="student_section[{{ $section->id }}][section]" {{ $flag == 1 ? 'checked' : '' }} value={{ $section->id }}>
                                            <label for="{{ $section->slug }}">{{ $section->section_name }}</label>
                                            <input data-student="#{{ $section->slug }}" value="{{ $flag == 1 ? $section_student->students : '' }}"  max="{{ $student->number_of_student }}" type="number" name="student_section[{{ $section->id }}][student]" class="form-control-sm student" {{ $flag == 1 ? '' : 'disabled' }}>
                                            <br>
                                        @endforeach

                                        @if ($errors->has('students'))
                                            <span class="help-block">
                                            {!! $errors->first('students') !!}

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

        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
    </div>
    <!-- end page content-->
@endsection


@push('script')
    <script>
        let sections = document.querySelectorAll('.section');
        sections.forEach((e) => {
            e.addEventListener('input', event=>{

                if(event.target.checked == true){
                    //console.log(event.target.id);
                    document.querySelector( `[data-student="#${event.target.id}"]`).removeAttribute('disabled','false');
                }else{
                    document.querySelector( `[data-student="#${event.target.id}"]`).setAttribute('disabled','true');
                }
            })
        })
    </script>
    @endpush



