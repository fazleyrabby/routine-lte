@extends('layouts.app')

@section('title', 'Routine')

@section('stylesheets')
<style>
    .batch-card { transition: box-shadow 0.2s, transform 0.2s; }
    .batch-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.12); transform: translateY(-2px); }
    .progress { height: 6px; border-radius: 3px; }
    .fill-badge { font-size: 0.75rem; }
    .dept-tab.active { font-weight: 700; background: #f8f9fa !important; }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="mt-0 header-title mb-4 d-flex flex-wrap align-items-start gap-2">
                            <div class="me-auto">
                                <h5 class="mb-1">Routine Management</h5>
                                <small class="text-muted">
                                    @if($last_created_by)
                                        Last input by <strong>{{ ucwords($last_created_by->firstname . ' ' . $last_created_by->lastname) }}</strong>
                                        at {{ date('d-m-Y h:i a', strtotime($last_created_by->created_at)) }}
                                    @endif
                                    @if($last_edited_by)
                                        &nbsp;&bull;&nbsp; Edited by <strong>{{ ucwords($last_edited_by->firstname . ' ' . $last_edited_by->lastname) }}</strong>
                                        at {{ date('d-m-Y h:i a', strtotime($last_edited_by->updated_at)) }}
                                    @endif
                                </small>
                            </div>
                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                <form action="{{ route('full_routine_print') }}" method="post" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="yearly_session_id" value="{{ $yearly_session }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Download PDF</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#routineResetModal">Full Reset</button>
                            @endif
                        </div>

                        @if($request_check && ($request_check->request_status == 'active' && $request_check->expired_date >= now()))
                            <div class="alert alert-warning py-2 mb-3">
                                Your editing access expires at <strong>{{ date('d-m-Y h:i a', strtotime($request_check->expired_date)) }}</strong>
                            </div>
                        @endif

                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                {{ Session('message') }}
                            </div>
                        @endif

                        <ul class="nav nav-tabs mb-3">
                            @foreach($departments as $dept)
                                <li class="nav-item">
                                    <a class="nav-link dept-tab {{ $selected_department_id == $dept->id ? 'active' : '' }}"
                                       href="{{ route('full_routine', [$yearly_session, 'department_id' => $dept->id, 'shift_id' => $selected_shift_id]) }}">
                                        {{ $dept->department_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <form method="GET" action="{{ route('full_routine', [$yearly_session]) }}" class="row mb-4">
                            <input type="hidden" name="department_id" value="{{ $selected_department_id }}">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Filter by Shift</label>
                                <select name="shift_id" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Shifts</option>
                                    @foreach($shifts as $s)
                                        <option value="{{ $s->id }}" {{ $selected_shift_id == $s->id ? 'selected' : '' }}>{{ $s->shift_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        @if($sections->isEmpty())
                            <div class="text-center py-5 text-muted">No batches found for the selected department/shift.</div>
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
                                @foreach($sections as $section)
                                    @php
                                        $key = $section->batch_id . '_' . $section->section_id;
                                        $filled = $fillCounts[$key]->filled_slots ?? 0;
                                        $total = $totalDailySlots * 6;
                                        $percent = $total > 0 ? min(100, round($filled / $total * 100)) : 0;
                                        $canEdit = (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin' || Auth::user()->in_committee == 'yes')
                                                   || ($request_check && $request_check->request_status == 'active' && $request_check->expired_date >= now());
                                    @endphp
                                    <div class="col">
                                        <div class="card batch-card h-100">
                                            <div class="card-body py-3 px-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="mb-0 fw-bold">
                                                        {{ $section->department_name }}-{{ $section->batch_no }}-{{ $section->slug }}
                                                        @if($section->section_name)
                                                            <span class="badge bg-secondary ms-1">{{ $section->section_name }}</span>
                                                        @endif
                                                    </h6>
                                                    <span class="badge {{ $percent >= 80 ? 'bg-success' : ($percent >= 40 ? 'bg-warning text-dark' : 'bg-light text-dark border') }} fill-badge">
                                                        {{ $filled }} slots
                                                    </span>
                                                </div>
                                                <div class="progress mb-3">
                                                    <div class="progress-bar {{ $percent >= 80 ? 'bg-success' : ($percent >= 40 ? 'bg-warning' : 'bg-danger') }}"
                                                         role="progressbar" style="width: {{ $percent }}%"></div>
                                                </div>
                                                @if($canEdit)
                                                    <a href="{{ route('routine_batch_editor', [$yearly_session, $section->batch_id, $section->section_id ?? '0']) }}"
                                                       class="btn btn-sm btn-primary w-100">Edit Routine</a>
                                                @else
                                                    <a href="{{ route('routine_batch_editor', [$yearly_session, $section->batch_id, $section->section_id ?? '0']) }}"
                                                       class="btn btn-sm btn-outline-secondary w-100">View Routine</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
<div class="modal fade" id="routineResetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Reset Full Routine?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>This will permanently delete <strong>all scheduled classes</strong> for the current session. This cannot be undone.</p>
                {!! Form::open(['route' => ['routine_reset'], 'method' => 'post']) !!}
                {!! Form::hidden('yearly_session_id', $yearly_session) !!}
                <div class="d-flex gap-2">
                    {!! Form::submit('Yes, Reset Everything', ['class' => 'btn btn-danger']) !!}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endif
@endsection
