@extends('layouts.app')

@section('title', 'Edit Routine')

@section('stylesheets')
<style>
    .routine-cell { min-width: 110px; vertical-align: middle; }
    .slot-filled { background: #fff3cd; border-left: 3px solid #ffc107; }
    .slot-filled.lab-class { background: #f8d7da; border-left-color: #dc3545; }
    .slot-empty { background: #f8f9fa; }
    .slot-empty:hover { background: #e9ecef; }
    .time-header { font-size: 0.78rem; white-space: nowrap; }
    .cell-course { font-weight: 700; font-size: 0.82rem; }
    .cell-sub { font-size: 0.75rem; color: #555; }
    .offcanvas-end { width: 380px !important; }
    .day-header { background: #343a40; color: #fff; padding: 6px 12px; border-radius: 4px; font-size: 0.9rem; }
    .batch-info-bar { background: #f8f9fa; border-left: 4px solid #007bff; padding: 10px 16px; border-radius: 4px; margin-bottom: 1rem; }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        {{-- Breadcrumb + Batch Info --}}
        <div class="batch-info-bar d-flex flex-wrap align-items-center gap-3 mb-3">
            <div>
                <a href="{{ route('full_routine', [$yearly_session, 'department_id' => optional($batch)->batch_id]) }}"
                   class="btn btn-sm btn-outline-secondary me-2">
                    &larr; Back to Overview
                </a>
            </div>
            @if($batch)
                <div>
                    <strong>{{ $batch->department_name }}-{{ $batch->batch_no }}-{{ $batch->slug }}</strong>
                    @if($batch->section_name)
                        <span class="badge bg-secondary ms-1">{{ $batch->section_name }}</span>
                    @endif
                </div>
            @endif
            <div class="ms-auto text-muted small">
                @if($request_check && ($request_check->request_status == 'active' && $request_check->expired_date >= now()))
                    <span class="badge bg-warning text-dark">Access expires {{ date('d-m-Y h:i a', strtotime($request_check->expired_date)) }}</span>
                @endif
            </div>
        </div>

        @if(Session::has('message'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                {{ Session('message') }}
            </div>
        @endif

        @php
            $canEdit = (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin' || Auth::user()->in_committee == 'yes')
                       || ($request_check && $request_check->request_status == 'active' && $request_check->expired_date >= now());
        @endphp

        {{-- Day-by-Day Grid --}}
        @foreach($slots as $slot)
            @php
                $daySlots = $day_wise_slots->where('day_id', $slot->id)->values();
            @endphp
            @if($daySlots->isEmpty()) @continue @endif

            <div class="card mb-3">
                <div class="card-header py-2">
                    <span class="day-header">{{ $slot->day_title }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" style="min-width:600px">
                            <thead>
                                <tr>
                                    <th class="time-header text-center" style="width:60px">#</th>
                                    @foreach($daySlots as $ts)
                                        <th class="time-header text-center routine-cell">
                                            {{ date('g:i a', strtotime($ts->time_slot->from)) }}<br>
                                            <small>{{ date('g:i a', strtotime($ts->time_slot->to)) }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center align-middle small text-muted">Slot</td>
                                    @php $skippedSlots = []; @endphp
                                    @foreach($daySlots as $idx => $ts)
                                        @if(in_array($ts->id, $skippedSlots)) @continue @endif
                                        @php
                                            $currentRoutine = null;
                                            foreach($slot->routine as $r) {
                                                if($r->time_slot_id == $ts->time_slot_id) {
                                                    $currentRoutine = $r;
                                                    break;
                                                }
                                            }

                                            $colspan = 1;
                                            if ($currentRoutine) {
                                                $nextIdx = $idx + 1;
                                                while(isset($daySlots[$nextIdx])) {
                                                    $nextTs = $daySlots[$nextIdx];
                                                    $nextRoutine = null;
                                                    foreach($slot->routine as $r) {
                                                        if($r->time_slot_id == $nextTs->time_slot_id &&
                                                           $r->course_id == $currentRoutine->course_id &&
                                                           $r->teacher_id == $currentRoutine->teacher_id &&
                                                           $r->room_id == $currentRoutine->room_id) {
                                                            $nextRoutine = $r;
                                                            break;
                                                        }
                                                    }
                                                    if ($nextRoutine) {
                                                        $colspan++;
                                                        $skippedSlots[] = $nextTs->id;
                                                        $nextIdx++;
                                                    } else { break; }
                                                }
                                            }
                                        @endphp

                                        <td class="p-1 text-center align-middle routine-cell {{ $currentRoutine ? ($currentRoutine->course->course_type == '0' ? 'slot-filled' : 'slot-filled lab-class') : 'slot-empty' }}"
                                            colspan="{{ $colspan }}">
                                            @if($currentRoutine)
                                                <div class="cell-course">
                                                    {{ $currentRoutine->course->course_code }}
                                                    <span class="badge {{ $currentRoutine->course->course_type == '0' ? 'bg-warning text-dark' : 'bg-danger' }} ms-1">
                                                        {{ $currentRoutine->course->course_type == '0' ? 'T' : 'L' }}
                                                    </span>
                                                </div>
                                                <div class="cell-sub">{{ $currentRoutine->room->building }}-{{ $currentRoutine->room->room_no }}</div>
                                                <div class="cell-sub">{{ $currentRoutine->teacher->user->firstname }} {{ $currentRoutine->teacher->user->lastname }}</div>
                                                @if($canEdit)
                                                    <div class="d-flex gap-1 justify-content-center mt-1">
                                                        <button class="btn btn-xs btn-sm btn-primary py-0 px-1 assign-btn"
                                                                style="font-size:0.7rem"
                                                                data-routine-id="{{ $currentRoutine->id }}"
                                                                data-day-id="{{ $ts->day_id }}"
                                                                data-timeslot-id="{{ $ts->time_slot_id }}"
                                                                data-course-id="{{ $currentRoutine->course_id }}"
                                                                data-teacher-id="{{ $currentRoutine->teacher_id }}"
                                                                data-room-id="{{ $currentRoutine->room_id }}"
                                                                 data-bs-toggle="offcanvas" data-bs-target="#assignPanel">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-xs btn-sm btn-danger py-0 px-1"
                                                                style="font-size:0.7rem"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $currentRoutine->id }}">
                                                            Del
                                                        </button>
                                                    </div>

                                                    {{-- Delete Confirm Modal --}}
                                                    <div class="modal fade" id="deleteModal{{ $currentRoutine->id }}" tabindex="-1">
                                                        <div class="modal-dialog modal-sm modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center py-3">
                                                                    <p class="mb-3">Delete this class slot?</p>
                                                                    {!! Form::open(['route' => ['routine_cell_delete'], 'method' => 'post']) !!}
                                                                    {!! Form::hidden('id', $currentRoutine->id) !!}
                                                                    <div class="d-flex gap-2 justify-content-center">
                                                                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                @if($canEdit)
                                                    <button class="btn btn-sm btn-light border assign-btn w-100"
                                                            style="font-size:0.75rem; min-height:60px"
                                                            data-routine-id=""
                                                            data-day-id="{{ $ts->day_id }}"
                                                            data-timeslot-id="{{ $ts->time_slot_id }}"
                                                            data-course-id=""
                                                            data-teacher-id=""
                                                            data-room-id=""
                                                             data-bs-toggle="offcanvas" data-bs-target="#assignPanel">
                                                        + Assign
                                                    </button>
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

{{-- Assign / Edit Offcanvas Panel --}}
@if($canEdit)
<div class="offcanvas offcanvas-end" tabindex="-1" id="assignPanel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="panelTitle">Assign Class</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div id="panelContext" class="alert alert-info py-2 mb-3 small"></div>
        <div id="panelAlert" class="d-none alert alert-danger py-2 small"></div>

        {!! Form::open(['route' => ['routine_create'], 'id' => 'assignForm']) !!}
        <input type="hidden" name="yearly_session_id" value="{{ $yearly_session }}">
        <input type="hidden" name="batch_id" value="{{ $batch_id }}">
        <input type="hidden" name="section_id" value="{{ $section_id != '0' ? $section_id : '' }}">
        <input type="hidden" name="day_id" id="panel_day_id">
        <input type="hidden" name="time_slot_id" id="panel_time_slot_id">
        <input type="hidden" name="routine_id" id="panel_routine_id">

        <div class="mb-3">
            <label class="form-label fw-bold">Course</label>
            @if($courses->isEmpty())
                <div class="alert alert-warning small">No courses assigned to this batch in workload. Please set up workload assignments first.</div>
            @else
                <select name="course_id" id="panel_course_id" class="form-control" required>
                    <option value="">— Select Course —</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                                data-type="{{ $course->course_type }}">
                            {{ $course->course_code }} — {{ $course->course_name }}
                            ({{ $course->course_type == '0' ? 'Theory' : 'Lab' }})
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Teacher</label>
            <select name="teacher_id" id="panel_teacher_id" class="form-control" required>
                <option value="">— Select Teacher —</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">
                        {{ $teacher->user->firstname }} {{ $teacher->user->lastname }} | {{ $teacher->rank->rank ?? '' }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted" id="teacherFilterNote"></small>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Room</label>
            <select name="room_id" id="panel_room_id" class="form-control" required>
                <option value="">— Select Room —</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">
                        {{ $room->building }}-{{ $room->room_no }}
                        {{ $room->room_type == '0' ? '' : '(Lab)' }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100" id="assignSubmitBtn">Assign</button>
        {!! Form::close() !!}
    </div>
</div>
@endif
@endsection

@push('script')
<script>
// Course → Teacher cascade map from server
const courseTeacherMap = @json($courseTeacherMap);

// Day name map for display
const dayNames = @json($slots->pluck('day_title', 'id'));
const timeSlotLabels = {};
@foreach($day_wise_slots as $ts)
    timeSlotLabels[{{ $ts->time_slot_id }}] = '{{ date('g:i a', strtotime($ts->time_slot->from)) }} – {{ date('g:i a', strtotime($ts->time_slot->to)) }}';
@endforeach

const allTeacherOptions = Array.from(document.querySelectorAll('#panel_teacher_id option'));

// Populate panel when any assign button is clicked
document.querySelectorAll('.assign-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const routineId   = this.dataset.routineId;
        const dayId       = this.dataset.dayId;
        const timeslotId  = this.dataset.timeslotId;
        const courseId    = this.dataset.courseId;
        const teacherId   = this.dataset.teacherId;
        const roomId      = this.dataset.roomId;
        // Set context label
        document.getElementById('panelContext').textContent =
            `Day: ${dayNames[dayId] || dayId}  |  Time: ${timeSlotLabels[timeslotId] || timeslotId}`;
        document.getElementById('panelTitle').textContent = routineId ? 'Edit Class' : 'Assign Class';
        document.getElementById('assignSubmitBtn').textContent = routineId ? 'Update' : 'Assign';

        // Set hidden fields
        document.getElementById('panel_day_id').value = dayId;
        document.getElementById('panel_time_slot_id').value = timeslotId;
        document.getElementById('panel_routine_id').value = routineId;

        // Pre-select course
        const courseSelect = document.getElementById('panel_course_id');
        if (courseSelect && courseId) {
            courseSelect.value = courseId;
            filterTeachersByCourse(parseInt(courseId));
        } else if (courseSelect) {
            courseSelect.value = '';
            showAllTeachers();
        }

        // Pre-select teacher
        const teacherSelect = document.getElementById('panel_teacher_id');
        if (teacherSelect && teacherId) teacherSelect.value = teacherId;

        // Pre-select room
        const roomSelect = document.getElementById('panel_room_id');
        if (roomSelect && roomId) roomSelect.value = roomId;

        // Clear alerts
        document.getElementById('panelAlert').classList.add('d-none');
    });
});

// Course change → filter teachers
const courseSelect = document.getElementById('panel_course_id');
if (courseSelect) {
    courseSelect.addEventListener('change', function() {
        filterTeachersByCourse(parseInt(this.value));
    });
}

function filterTeachersByCourse(courseId) {
    const teacherSelect = document.getElementById('panel_teacher_id');
    if (!teacherSelect) return;
    const allowed = courseTeacherMap[courseId] || [];

    // Rebuild options — if no workload mapping exists, show all available teachers
    teacherSelect.innerHTML = '<option value="">— Select Teacher —</option>';
    allTeacherOptions.forEach(opt => {
        if (!opt.value) return;
        const clone = opt.cloneNode(true);
        if (allowed.length === 0 || allowed.includes(parseInt(opt.value))) {
            teacherSelect.appendChild(clone);
        }
    });

    const note = document.getElementById('teacherFilterNote');
    if (note) {
        note.textContent = allowed.length
            ? `Filtered to ${allowed.length} teacher(s) assigned to this course`
            : 'Showing all teachers (no workload assignment found for this course)';
    }
}

function showAllTeachers() {
    const teacherSelect = document.getElementById('panel_teacher_id');
    if (!teacherSelect) return;
    teacherSelect.innerHTML = '<option value="">— Select Teacher —</option>';
    allTeacherOptions.forEach(opt => { if(opt.value) teacherSelect.appendChild(opt.cloneNode(true)); });
}

// Form submit via AJAX to stay on page
const assignForm = document.getElementById('assignForm');
if (assignForm) {
    assignForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('assignSubmitBtn');
        btn.disabled = true;
        btn.textContent = 'Saving...';

        const formData = new FormData(this);
        fetch('{{ route("routine_create") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.type === 'success') {
                const alertBox = document.getElementById('panelAlert');
                alertBox.className = 'alert alert-success py-2 small';
                alertBox.textContent = data.text || 'Success!';
                btn.textContent = 'Success!';
                
                // Wait 1 second so the user can see the success message before reloading
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                const alertBox = document.getElementById('panelAlert');
                alertBox.className = 'alert alert-danger py-2 small';
                alertBox.textContent = data.text || 'An error occurred.';
                btn.disabled = false;
                btn.textContent = 'Assign';
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.textContent = 'Assign';
        });
    });
}
</script>
@endpush
