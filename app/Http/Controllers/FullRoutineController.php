<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\DayWiseSlot;
use App\Models\FullRoutine;
use App\Models\RoutineCommittee;
use App\Models\Shift;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Room;
use App\Models\Department;
use App\Models\AssignCourse;
use App\Models\TeachersOffday;
use App\Models\YearlySession;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FullRoutineController extends MasterController
{
    public function index($yearly_session)
    {
        $departments = Department::where('is_active', 'yes')->orderBy('department_name', 'asc')->get();
        $shifts = Shift::where('is_active', 'yes')->get();

        $selected_department_id = request('department_id') ?? ($departments->first() ? $departments->first()->id : null);
        $selected_shift_id = request('shift_id');

        // Load batch list for the selected department/shift (lightweight — no routine data)
        $sectionsQuery = Student::withBatchDetails()->where('batch.is_active', 'yes');
        if ($selected_department_id) {
            $sectionsQuery->where('batch.department_id', $selected_department_id);
        }
        if ($selected_shift_id) {
            $sectionsQuery->where('batch.shift_id', $selected_shift_id);
        }
        $sections = $sectionsQuery->get();

        // Slot fill counts per batch+section for this session (single aggregate query)
        $fillCounts = FullRoutine::selectRaw('batch_id, section_id, COUNT(*) as filled_slots')
            ->where('yearly_session_id', $yearly_session)
            ->groupBy('batch_id', 'section_id')
            ->get()
            ->keyBy(fn($r) => $r->batch_id . '_' . $r->section_id);

        // Total time slots per day (for calculating max possible slots)
        $totalDailySlots = DayWiseSlot::count();

        // Audit info
        $last_created_by = FullRoutine::select('users.firstname', 'users.lastname', 'routine.created_at')
            ->leftJoin('users', 'users.id', '=', 'routine.created_by')
            ->orderBy('routine.created_at', 'DESC')
            ->limit(1)->first();

        $last_edited_by = FullRoutine::select('users.firstname', 'users.lastname', 'routine.updated_at')
            ->leftJoin('users', 'users.id', '=', 'routine.edited_by')
            ->orderBy('routine.updated_at', 'DESC')
            ->whereNotNull('routine.edited_by')
            ->limit(1)->first();

        $request_check = RoutineCommittee::where('receiver_id', Auth::user()->id)->first();

        return view('admin.routine.index', compact(
            'sections', 'fillCounts', 'totalDailySlots', 'yearly_session',
            'departments', 'shifts', 'selected_department_id', 'selected_shift_id',
            'last_created_by', 'last_edited_by', 'request_check'
        ));
    }

    public function batchEditor($yearly_session, $batch_id, $section_id)
    {
        // Batch detail
        $batch = Student::withBatchDetails()
            ->where('batch.id', $batch_id)
            ->where(function ($q) use ($section_id) {
                $section_id ? $q->where('sections.id', $section_id) : $q->whereNull('sections.id');
            })->first();

        // Routine slots for this batch only — scoped tight
        $slots = Day::with([
            'routine' => fn($q) => $q
                ->where('yearly_session_id', $yearly_session)
                ->where('batch_id', $batch_id)
                ->where(fn($q2) => $section_id
                    ? $q2->where('section_id', $section_id)
                    : $q2->whereNull('section_id')
                ),
            'routine.course:id,course_name,course_code,course_type',
            'routine.teacher:id,user_id',
            'routine.teacher.user:id,firstname,lastname',
            'routine.room:id,room_no,building,room_type',
            'routine.time_slot:id,from,to,type',
        ])->get();

        // Day-wise slots (for column headers)
        $day_wise_slots = DayWiseSlot::with('day', 'time_slot')
            ->get()
            ->sortBy(fn($dws) => $dws->time_slot->from)
            ->values();

        // Step 1: Get courses offered for this batch+session from course_offers
        // course_offers has batch_id + yearly_session_id + courses (comma-sep IDs)
        $courseOffer = \DB::table('course_offers')
            ->where('batch_id', $batch_id)
            ->where('yearly_session_id', $yearly_session)
            ->where('is_active', 'yes')
            ->first();

        $batchCourseIds = collect();
        if ($courseOffer && $courseOffer->courses) {
            $batchCourseIds = collect(explode(',', $courseOffer->courses))->map(fn($v) => (int) $v)->filter();
        }

        $courses = Course::whereIn('id', $batchCourseIds)
            ->where('is_active', 'yes')
            ->select('id', 'course_name', 'course_code', 'course_type')
            ->get();

        // Step 2: Get workload assignments for this session
        // assign_courses_to_teachers has session_id + teacher_id + courses (comma-sep IDs)
        // Filter to only workloads whose courses overlap with this batch's course IDs
        $allWorkloads = AssignCourse::where('session_id', $yearly_session)
            ->where('is_active', 'yes')
            ->get();

        // Keep only workloads that share at least one course with this batch
        $assignedWorkloads = $allWorkloads->filter(function ($w) use ($batchCourseIds) {
            $wCourseIds = collect(explode(',', $w->courses))->map(fn($v) => (int) $v)->filter();
            return $wCourseIds->intersect($batchCourseIds)->isNotEmpty();
        });

        // Teachers who have workload for this batch's courses.
        // If no workload data exists for this session, fall back to all active teachers
        // so the editor is never left with an empty dropdown.
        $teacherIds = $assignedWorkloads->pluck('teacher_id')->unique();
        if ($teacherIds->isEmpty()) {
            $teachers = Teacher::with(['user:id,firstname,lastname', 'rank:id,rank'])
                ->where('is_active', 'yes')
                ->get();
        } else {
            $teachers = Teacher::with(['user:id,firstname,lastname', 'rank:id,rank'])
                ->whereIn('id', $teacherIds)
                ->where('is_active', 'yes')
                ->get();
        }

        // Course→Teacher mapping for JS cascade filter
        // Map: course_id => [teacher_id, ...]  (only for courses in this batch)
        // Courses with no entry in the map will show ALL teachers in the JS filter.
        $courseTeacherMap = [];
        foreach ($assignedWorkloads as $w) {
            foreach (explode(',', $w->courses) as $cid) {
                $cid = (int) $cid;
                if ($cid && $batchCourseIds->contains($cid)) {
                    $courseTeacherMap[$cid][] = (int) $w->teacher_id;
                }
            }
        }

        // Rooms (global — no restriction)
        $rooms = Room::where('is_active', 'yes')
            ->select('id', 'room_no', 'building', 'room_type')->get();

        $request_check = RoutineCommittee::where('receiver_id', Auth::user()->id)->first();

        return view('admin.routine.batch_editor', compact(
            'batch', 'slots', 'day_wise_slots', 'courses', 'teachers', 'rooms',
            'courseTeacherMap', 'yearly_session', 'batch_id', 'section_id', 'request_check'
        ));
    }


    public function batch_search(){
        $sessions = YearlySession::with('session')->where('is_active','yes')->get();
        $batches = Student::withBatchDetails()->get();
        return view('admin.routine.batch_search', compact('sessions','batches'));
    }

    public function batch_wise_view(Request $request){
        $batch_id = $request->batch_id;
        $y_session_id = $request->y_session_id;

        list($batch_id, $section_id) = explode(',', $batch_id);

        $slots = $this->getBatchRoutineSlots($batch_id, $y_session_id, $section_id);

        $day_wise_slots = DayWiseSlot::with('day','time_slot')->get();

        $batch = $this->getBatchDetail($batch_id, $section_id);

        return view('admin.routine.batch_wise_view', compact('slots','y_session_id','batch','day_wise_slots'));
    }

    public function teacher_search(){
        $sessions = YearlySession::with('session')->where('is_active','yes')->get();
        $teachers = Teacher::with(['user','rank'])->where('is_active','yes')->get();
        $y_session_id = YearlySession::where('is_active','yes')->orderBy('id','DESC')->pluck('id')->first();

        $teacher_detail = Teacher::with(['user','rank'])->where('is_active','yes')->where('user_id', Auth::user()->id)->first();
        $teacher_id = $teacher_detail->id;
        $user_id = $teacher_detail->user_id;

        $slots = $this->getTeacherRoutineSlots($teacher_id, $y_session_id, $user_id);

        $day_wise_slots = DayWiseSlot::with('day','time_slot')->get();

        return view('admin.routine.teacher_search', compact('sessions','teachers','slots','y_session_id','teacher_detail','day_wise_slots'));
    }

    public function routine_list($yearly_session_id){
        $teachers = Teacher::with(['user','rank'])->where('is_active','yes')->get();
        $session = YearlySession::with('session')->where('id',$yearly_session_id)->first();

        $batches = Student::withBatchDetails()->get();

        return view('admin.routine.routine_list', compact('teachers','session','batches'));
    }

    public function teacher_wise_view(Request $request){
        $teacher_id = $request->teacher_id;
        $y_session_id = $request->y_session_id;

        $slots = $this->getTeacherRoutineSlots($teacher_id, $y_session_id);

        $day_wise_slots = DayWiseSlot::with('day','time_slot')->get();

        $teacher_detail = Teacher::with(['user','rank'])->where('is_active','yes')->where('id', $teacher_id)->first();

        return view('admin.routine.teacher_wise_view', compact('slots','y_session_id','teacher_detail','day_wise_slots'));
    }

    public function teacher_wise_print(Request $request){
        $teacher_id = $request->teacher_id;
        $y_session_id = $request->y_session_id;

        $slots = $this->getTeacherRoutineSlots($teacher_id, $y_session_id);

        $yearly_session = YearlySession::with('session')->find($y_session_id);

        $day_wise_slots = DayWiseSlot::with('day','time_slot')->get();

        $teacher_detail = Teacher::with(['user','rank'])->where('is_active','yes')->where('id', $teacher_id)->first();

        $data = compact('slots','y_session_id','teacher_detail','day_wise_slots','yearly_session');

        $pdf_name = $teacher_detail->user->firstname."_".$teacher_detail->user->lastname."_".$yearly_session->session->session_name."_".$yearly_session->year;

        $pdf = PDF::loadView('admin.routine.teacher_wise_print',$data);
        return $pdf->download('routine_'.$pdf_name.".pdf");
    }

    public function course_check(Request $request){
        $time_slot_id = $request->time_slot_id;
        $batch_id = $request->batch_id;
        $section_id = $request->section_id;
        $day_id = $request->day_id;

        $data = array();
        $type = Course::where('id',$request->id)->pluck('course_type')->first();
        $time_slot = TimeSlot::where('id', $time_slot_id)->select('from', 'to')->first();
        $time_range_in_hour = intval((strtotime($time_slot->to) - strtotime($time_slot->from))/3600);

        if ($time_range_in_hour == 3){
            return response()->json(['error' => 'Time slot is 3 hours long']);
        }

        if ($type == 1){
            $exclude_ids = [];
            if ($request->routine_id) {
                $cell = FullRoutine::find($request->routine_id);
                if ($cell) {
                    $exclude_ids = FullRoutine::where([
                        ['batch_id', $cell->batch_id],
                        ['section_id', $cell->section_id],
                        ['day_id', $cell->day_id],
                        ['teacher_id', $cell->teacher_id],
                        ['course_id', $cell->course_id],
                        ['room_id', $cell->room_id],
                        ['yearly_session_id', $cell->yearly_session_id],
                    ])->pluck('id')->toArray();
                }
            }

            $next = DB::table('time_slots')->select('id','from','to')
                ->where('time_slots.from', '>' , function($query) use ($time_slot_id){
                    $query->from('time_slots')->select('time_slots.from')->where('time_slots.id',$time_slot_id);
                })
                ->where('type', function($query) use ($time_slot_id){
                    $query->from('time_slots')->select('time_slots.type')->where('time_slots.id',$time_slot_id);
                })
                ->orderBy('time_slots.from')->limit(1)->get()->first();

            $prev = DB::table('time_slots')->select('id','from','to')
                ->where('time_slots.from', '<' ,function($query) use ($time_slot_id){
                    $query->from('time_slots')->select('time_slots.from')->where('time_slots.id',$time_slot_id);
                })
                ->where('type', function($query) use ($time_slot_id){
                    $query->from('time_slots')->select('time_slots.type')->where('time_slots.id',$time_slot_id);
                })
                ->orderBy('time_slots.from','DESC')->limit(1)->get()->first();

            if (!empty($next)){
                 $next_val = DB::table('routine')
                    ->where('routine.day_id',$day_id)
                    ->where('routine.time_slot_id',$next->id)
                    ->where('routine.batch_id',$batch_id)
                    ->where('routine.section_id',$section_id)
                    ->when(!empty($exclude_ids), fn($q) => $q->whereNotIn('id', $exclude_ids))
                    ->count();

                 if ($next_val == 0){
                     $data['next']['id'] = $next->id;
                     $data['next']['from'] = date('h:i a', strtotime($next->from));
                     $data['next']['to'] = date('h:i a', strtotime($next->to));
                 }
            }

            if (!empty($prev)){
                $prev_val = DB::table('routine')
                    ->where('routine.day_id',$day_id)
                    ->where('routine.time_slot_id',$prev->id)
                    ->where('routine.batch_id',$batch_id)
                    ->where('routine.section_id',$section_id)
                    ->when(!empty($exclude_ids), fn($q) => $q->whereNotIn('id', $exclude_ids))
                    ->count();

                if ($prev_val == 0){
                    $data['prev']['id'] = $prev->id;
                    $data['prev']['from'] = date('h:i a', strtotime($prev->from));
                    $data['prev']['to'] = date('h:i a', strtotime($prev->to));
                }
            }
            if (empty($data)){
                $data['msg'] = 'Sorry the previous or next slot must be empty for lab class! Select other time slot';
            }
            return response()->json($data);
        }

        return response()->json([]);
    }

    public function create(Request $request, \App\Services\RoutineSchedulerService $scheduler)
    {
        $day_wise_slot = DayWiseSlot::where('day_id', $request->day_id)->where('time_slot_id', $request->time_slot_id)->pluck('class_slot')->first();
        $course = Course::where('id', $request->course_id)->select('course_type')->first();

        $exist_class_slots = DB::table('routine')->select('*')
            ->where('routine.day_id' , $request->day_id)
            ->where('routine.time_slot_id', $request->time_slot_id)
            ->leftJoin('courses','courses.id', 'routine.course_id')
            ->where('course_type', '0')
            ->count();

        $validationError = $scheduler->checkSchedulingConstraints($request);
        if ($validationError) {
            return response()->json($validationError);
        }

        if ($request->routine_id == '') {
            return $this->performInsert($request, $day_wise_slot, $exist_class_slots, $course);
        }

        return $this->performUpdate($request);
    }

    public function class_slot_update(Request $request){
        $id = $request->id;
        $total_slot = $request->total_slot;
        if (Auth::user()->role == 'admin'){
            DayWiseSlot::where("id", $id)->update(["class_slot" => $total_slot]);
        }
    }

    public function reset(Request $request){
        $yearly_session_id = $request->yearly_session_id;
        FullRoutine::where("yearly_session_id", $yearly_session_id)->delete();
        Session::flash('message', 'Routine Reset successful!!');
        return back();
    }

    public function routine_cell_delete(Request $request){
        $id = $request->id;
        $cell = FullRoutine::find($id);
        if ($cell) {
            FullRoutine::where([
                ['batch_id', $cell->batch_id],
                ['section_id', $cell->section_id],
                ['day_id', $cell->day_id],
                ['teacher_id', $cell->teacher_id],
                ['course_id', $cell->course_id],
                ['room_id', $cell->room_id],
                ['yearly_session_id', $cell->yearly_session_id],
            ])->delete();
        }
        Session::flash('message', 'Routine Cell Delete Successful!!');
        return back();
    }

    private function getBatchRoutineSlots($batch_id, $y_session_id, $section_id)
    {
        return Day::with(['routine' => function ($query) use ($batch_id, $y_session_id, $section_id) {
            $query->select('id','teacher_id','batch_id','section_id','room_id','day_id','time_slot_id','course_id','yearly_session_id','room_id')
                ->where('batch_id', $batch_id)
                ->where('yearly_session_id', $y_session_id);
            if ($section_id != '') {
                $query->where('section_id', $section_id);
            }
        },'routine.course' => function ($query) {
            $query->select('id','course_name','course_code','course_type');
        },'routine.teacher' => function ($query) {
            $query->select('id','user_id')->where('is_active','yes');
        },'routine.room' => function ($query) {
            $query->select('id','room_type','building','room_no')->where('is_active','yes');
        }])->get();
    }

    private function getTeacherRoutineSlots($teacher_id, $y_session_id, $user_id = null)
    {
        return Day::with(['routine' => function ($query) use ($teacher_id, $y_session_id) {
            $query->select('id','teacher_id','batch_id','section_id','room_id','day_id','time_slot_id','course_id','yearly_session_id','room_id')
                ->where('teacher_id', $teacher_id)
                ->where('yearly_session_id', $y_session_id);
        },'routine.course' => function ($query) {
            $query->select('id','course_name','course_code','course_type');
        },'routine.teacher' => function ($query) use ($teacher_id, $user_id) {
            $query->select('id','user_id')->where('is_active','yes')->where('id', $user_id ?? $teacher_id);
        },'routine.room' => function ($query) {
            $query->select('id','room_type','building','room_no')->where('is_active','yes');
        },'routine.batch' => function ($query) {
            $query->select('id','batch_no','department_id','shift_id')->where('is_active','yes');
        },'routine.batch.department' => function ($query) {
            $query->select('id','department_name')->where('is_active','yes');
        },'routine.batch.shift' => function ($query) {
            $query->select('id','slug')->where('is_active','yes');
        },'routine.batch.student.section_student.section' => function ($query) {
            $query->select('id','section_name')->where('is_active','yes');
        }])->get();
    }

    private function getBatchDetail($batch_id, $section_id)
    {
        return Student::withBatchDetails()
            ->where('batch.id', $batch_id)
            ->where(function($query) use ($section_id) {
                if ($section_id != '') {
                    $query->where('sections.id', $section_id);
                }
            })->first();
    }



    private function performInsert(Request $request, $day_wise_slot, $exist_class_slots, $course)
    {
        if ($day_wise_slot == $exist_class_slots && $course->course_type == 0) {
            return response()->json(['type' => 'error', 'text' => 'Class slot limit exceeded!']);
        }

        if ($request->additional_time_slot) {
            $all_time_slot = [$request->time_slot_id, $request->additional_time_slot];
            $data = [];
            foreach ($all_time_slot as $slot) {
                $data[] = [
                    'time_slot_id' => $slot,
                    'batch_id' => $request->batch_id,
                    'section_id' => $request->section_id,
                    'day_id' => $request->day_id,
                    'teacher_id' => $request->teacher_id,
                    'course_id' => $request->course_id,
                    'room_id' => $request->room_id,
                    'created_by' => Auth::user()->id,
                    'yearly_session_id' => $request->yearly_session_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            $save = FullRoutine::insert($data);
        } else {
            $routine = new FullRoutine;
            $routine->batch_id = $request->batch_id;
            $routine->section_id = $request->section_id;
            $routine->day_id = $request->day_id;
            $routine->teacher_id = $request->teacher_id;
            $routine->course_id = $request->course_id;
            $routine->room_id = $request->room_id;
            $routine->created_by = Auth::user()->id;
            $routine->yearly_session_id = $request->yearly_session_id;
            $routine->time_slot_id = $request->time_slot_id;
            $save = $routine->save();
        }

        if ($save) {
            session()->flash('message', 'Data Successfully Inserted');
            return response()->json(['type' => 'success', 'text' => 'Data Successfully Inserted']);
        }
        return response()->json(['type' => 'error', 'text' => 'Data already exists for current data!']);
    }

    private function performUpdate(Request $request)
    {
        $cell = FullRoutine::find($request->routine_id);
        if ($cell) {
            $exclude_ids = FullRoutine::where([
                ['batch_id', $cell->batch_id],
                ['section_id', $cell->section_id],
                ['day_id', $cell->day_id],
                ['teacher_id', $cell->teacher_id],
                ['course_id', $cell->course_id],
                ['room_id', $cell->room_id],
                ['yearly_session_id', $cell->yearly_session_id],
            ])->pluck('id')->toArray();

            FullRoutine::whereIn('id', $exclude_ids)->delete();

            $target_slots = array_filter([$request->time_slot_id, $request->additional_time_slot]);
            $data = [];
            foreach ($target_slots as $slot) {
                $data[] = [
                    'time_slot_id' => $slot,
                    'batch_id' => $request->batch_id,
                    'section_id' => $request->section_id,
                    'day_id' => $request->day_id,
                    'teacher_id' => $request->teacher_id,
                    'course_id' => $request->course_id,
                    'room_id' => $request->room_id,
                    'created_by' => Auth::user()->id,
                    'edited_by' => Auth::user()->id,
                    'yearly_session_id' => $request->yearly_session_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            FullRoutine::insert($data);
        }
        session()->flash('message', 'Data Successfully Updated');
        return response()->json(['type' => 'success', 'text' => 'Data Successfully Updated']);
    }

    public function full_routine_print(Request $request){
        $y_session_id = $request->yearly_session_id;

        $slots = Day::with(['routine','routine.course','routine.teacher','routine.teacher.user','routine.room','routine.day','routine.time_slot'])->get();

        $day_wise_slots = DayWiseSlot::with('day','time_slot')->get();

        $sections = Student::withBatchDetails()->where('batch.is_active','yes')->get();

        $yearly_session = YearlySession::with('session')->find($y_session_id);

        $data = compact('sections','slots','y_session_id','day_wise_slots','yearly_session');

        $pdf_name = "Full_Routine_".$yearly_session->session->session_name."_".$yearly_session->year;

        $pdf = PDF::loadView('admin.routine.full_routine_print',$data)->setPaper('a4', 'landscape');
        return $pdf->download('routine_'.$pdf_name.".pdf");
    }
}



