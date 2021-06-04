<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\DayWiseSlot;
use App\Models\Student;
use App\Models\YearlySession;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function routine(){


            $sessions = YearlySession::with('session')->where('is_active','yes')->get();
            $batches = Student::select('*','sections.id as section_id','batch.id as batch_id')
                ->leftJoin('section_students', 'section_students.student_id', '=', 'students.id')
                ->leftJoin('sections', 'sections.id', '=', 'section_students.section_id')
                ->leftJoin('batch', 'students.batch_id', '=', 'batch.id')
                ->leftJoin('shifts', 'shifts.id', '=', 'batch.shift_id')
                ->leftJoin('departments', 'departments.id', '=', 'batch.department_id')
                ->leftJoin('yearly_sessions', 'yearly_sessions.id', '=', 'students.yearly_session_id')
                ->leftJoin('shift_sessions', 'shift_sessions.session_id', '=', 'yearly_sessions.session_id')
                ->get();

            return view('routine',compact('sessions','batches'));
    }

    public function routine_view(Request $request){

        $batch_id = $request->batch_id;
        $y_session_id = $request->y_session_id;

        list($batch_id, $section_id) = explode(',', $batch_id);

        $slots = Day::with(['routine' => function ($query) use ($batch_id,$y_session_id,$section_id) {
            if ($section_id != ''){
                $query->select('id','teacher_id','batch_id','section_id','room_id','day_id','time_slot_id','course_id','yearly_session_id','room_id')->where('batch_id', $batch_id)->where('yearly_session_id',$y_session_id)->where('section_id',$section_id);
            }else{
                $query->select('id','teacher_id','batch_id','section_id','room_id','day_id','time_slot_id','course_id','yearly_session_id','room_id')->where('batch_id', $batch_id)->where('yearly_session_id',$y_session_id);
            }

        },'routine.course' => function ($query) {
            $query->select('id','course_name','course_code','course_type');
        },'routine.teacher' => function ($query) {
            $query->select('id','user_id')->where('is_active','yes');
        },'routine.room' => function ($query) {
            $query->select('id','room_type','building','room_no')->where('is_active','yes');
        }
        ])->get();


        $day_wise_slots = DayWiseSlot::with('day','time_slot')->get();

        $batch = Student::select('*','sections.id as section_id','batch.id as batch_id')
            ->leftJoin('section_students', 'section_students.student_id', '=', 'students.id')
            ->leftJoin('sections', 'sections.id', '=', 'section_students.section_id')
            ->leftJoin('batch', 'students.batch_id', '=', 'batch.id')
            ->leftJoin('shifts', 'shifts.id', '=', 'batch.shift_id')
            ->leftJoin('departments', 'departments.id', '=', 'batch.department_id')
            ->leftJoin('yearly_sessions', 'yearly_sessions.id', '=', 'students.yearly_session_id')
            ->leftJoin('shift_sessions', 'shift_sessions.session_id', '=', 'yearly_sessions.session_id')
            ->leftJoin('sessions', 'sessions.id', '=', 'yearly_sessions.session_id')
            ->where('batch.id',$batch_id)
            ->where(function($query) use ($section_id){
                if ($section_id != ''){
                    $query->where('sections.id',$section_id);
                }
            })->first();

        $data = compact('slots','y_session_id','batch','day_wise_slots');
        return view('routine_view', $data);

    }

    public function routine_print(Request $request){

        $batch_id = $request->batch_id;
        $y_session_id = $request->y_session_id;
        list($batch_id, $section_id) = explode(',', $batch_id);

        $slots = Day::with(['routine' => function ($query) use ($batch_id,$y_session_id,$section_id) {
            if ($section_id != ''){
                $query->select('id','teacher_id','batch_id','section_id','room_id','day_id','time_slot_id','course_id','yearly_session_id','room_id')->where('batch_id', $batch_id)->where('yearly_session_id',$y_session_id)->where('section_id',$section_id);
            }else{
                $query->select('id','teacher_id','batch_id','section_id','room_id','day_id','time_slot_id','course_id','yearly_session_id','room_id')->where('batch_id', $batch_id)->where('yearly_session_id',$y_session_id);
            }

        },'routine.course' => function ($query) {
            $query->select('id','course_name','course_code','course_type');
        },'routine.teacher' => function ($query) {
            $query->select('id','user_id')->where('is_active','yes');
        },'routine.room' => function ($query) {
            $query->select('id','room_type','building','room_no')->where('is_active','yes');
        }
        ])->get();


        $day_wise_slots = DayWiseSlot::with('day','time_slot')->get();

        $batch = Student::select('*','sections.id as section_id','batch.id as batch_id')
            ->leftJoin('section_students', 'section_students.student_id', '=', 'students.id')
            ->leftJoin('sections', 'sections.id', '=', 'section_students.section_id')
            ->leftJoin('batch', 'students.batch_id', '=', 'batch.id')
            ->leftJoin('shifts', 'shifts.id', '=', 'batch.shift_id')
            ->leftJoin('departments', 'departments.id', '=', 'batch.department_id')
            ->leftJoin('yearly_sessions', 'yearly_sessions.id', '=', 'students.yearly_session_id')
            ->leftJoin('shift_sessions', 'shift_sessions.session_id', '=', 'yearly_sessions.session_id')
            ->leftJoin('sessions', 'sessions.id', '=', 'yearly_sessions.session_id')
            ->where('batch.id',$batch_id)
            ->where(function($query) use ($section_id){
                if ($section_id != ''){
                    $query->where('sections.id',$section_id);
                }
            })->first();



        $data = compact('slots','y_session_id','batch','day_wise_slots');
//        return view('routine_print', $data);
        $section = $batch->section_name != '' ? "_".$batch->section_name : '';
        $pdf_name = $batch->department_name."_".$batch->batch_no."_".$batch->slug.$section;

//        dd($pdf_name);

        $pdf = PDF::loadView('routine_print',$data);
        return $pdf->download('routine_'.$pdf_name.".pdf");
    }
}
