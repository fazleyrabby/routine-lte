@extends('layouts.app')

@section('title', 'Routine Management System')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <h4>Routine Management System</h4>
        </div>
        <div class="col-auto ms-auto">
            <a class="btn btn-danger" href="{{ route('home') }}">Go Back</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Search with your batch</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('routine_view') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Batch</label>
                        <select name="batch_id" class="form-control" required>
                            <option value="">Select</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->batch_id.",".$batch->section_id }}">
                                    {{ $batch->department_name."-".$batch->batch_no."-".$batch->slug }}{{ $batch->section_name != '' ? " - ".$batch->section_name : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Session</label>
                        <select name="y_session_id" class="form-control" required>
                            @foreach($sessions as $session)
                                <option value="{{ $session->id }}">{{ $session->session->session_name."-".$session->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
@endsection



