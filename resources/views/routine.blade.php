@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
         <h4 class="text-center mt-4">Routine Management System</h4>
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                    <div class="col-md-6 align-self-center font-20">Search with your batch</div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-danger" href="{{ route('home') }}">
                            Go Back
                        </a>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('routine_view') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Batch</label>
                                            <select name="batch_id" id="" class="form-control" required>
                                                <option value="" >Select</option>
                                                @foreach($batches as $batch)
                                                    <option value="{{ $batch->batch_id.",".$batch->section_id }}">
                                                        {{ $batch->department_name."-".$batch->batch_no."-".$batch->slug }}{{ $batch->section_name != '' ? " - ".$batch->section_name : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Session</label>
                                            <select name="y_session_id" id="" class="form-control" required>
                                                @foreach($sessions as $session)
                                                    <option value="{{ $session->id }}">{{ $session->session->session_name."-".$session->year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>

                            </form>
                        </div>
                    </div>
                </div>


            </div>
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

      <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>



@endsection



