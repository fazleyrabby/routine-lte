<?php

namespace App\Http\Controllers;

use App\Models\AssignCourse;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\YearlySession;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignCourseController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $assign_courses = AssignCourse::with(['teacher','session','course','teacher.user','teacher.rank','session.session','batch','batch.shift','batch.department'])->get();

//        $assign_courses = DB::table('assign_courses_to_teachers')
//                ->select('assign_courses_to_teachers.id as assign_courses_to_teachers_id','users.firstname','users.lastname','years','', DB::raw("GROUP_CONCAT(courses.course_code,' | ',courses.course_name,' | ', if(courses.course_type='0','Theory','Sessional'), ' | Credit - ',courses.credit) as course "))
//                ->leftJoin('teachers', 'teachers.id','assign_courses_to_teachers.teacher_id')
//                ->leftJoin('users', 'teachers.user_id','users.id')
//                ->leftJoin('yearly_sessions', 'assign_courses_to_teachers.session_id','yearly_sessions.id')
//                ->leftJoin('sessions', 'yearly_sessions.session_id','sessions.id')
//                ->leftJoin('batch', 'batch.id','assign_courses_to_teachers.batch_id')
//                ->leftJoin('courses', 'courses.id','assign_courses_to_teachers.course_id')
//                ->groupBy('teacher_id')
//                ->get();

        $assign_courses = AssignCourse::select("*","assign_courses_to_teachers.id as assign_courses_id", DB::raw("GROUP_CONCAT(courses.course_code,' | ',courses.course_name,' | ', if(courses.course_type='0','Theory','Sessional'), ' | Credit -',courses.credit) as course "))
            ->leftJoin('yearly_sessions','yearly_sessions.id','assign_courses_to_teachers.session_id')
            ->leftJoin('teachers', 'teachers.id','assign_courses_to_teachers.teacher_id')
            ->leftJoin('users', 'teachers.user_id','users.id')
            ->leftJoin('sessions','sessions.id','yearly_sessions.session_id')
            ->leftjoin('courses',DB::raw("FIND_IN_SET(courses.id, assign_courses_to_teachers.courses)"),">", DB::raw("'0'"))
            ->groupBy('assign_courses_to_teachers.id')
            ->get();


//        dd($courses);
//        $course = AssignCourse::all();
//        dd($assign_courses);
        return view('admin.assign_course.index',compact('assign_courses'))->with('i',1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $batches = Batch::with(['shift','department'])->get();
        $teachers = Teacher::with(['user'])->get();
        $courses = Course::where('is_active','yes')->get();
        $sessions = YearlySession::with('session')->where('is_active','yes')->get();

        return view('admin.assign_course.create',compact('batches','teachers','courses','sessions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courses = implode(",", $request->courses);

        $exists = AssignCourse::where([
            ['teacher_id', $request->teacher_id],
            ['session_id', $request->session_id],
        ])->count();

        $assign_course = new AssignCourse();
        $assign_course->session_id = $request->session_id;
        $assign_course->courses = $courses;
        $assign_course->teacher_id = $request->teacher_id;

        if ($exists){
            Session::flash('error', 'Data already assigned');
            return redirect()->route('assign_courses.create');
        }else{
            $assign_course->save();
            Session::flash('success', 'Data assigned successfully');
            return redirect()->route('assign_courses.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignCourse $assign_course)
    {
        $teachers = Teacher::with(['user'])->get();
        $courses = Course::where('is_active','yes')->get();
        $sessions = YearlySession::with('session')->where('is_active','yes')->get();
        return view('admin.assign_course.edit', compact('teachers','courses','sessions','assign_course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignCourse $assign_course)
    {
        $courses = implode(",", $request->courses);

        $exists = AssignCourse::where([
            ['teacher_id', $request->teacher_id],
            ['id', '!=', $assign_course->id],
            ['session_id', $request->session_id],
        ])->count();

        $assign_course->session_id = $request->session_id;
        $assign_course->courses = $courses;
        $assign_course->teacher_id = $request->teacher_id;

        if ($exists){
            Session::flash('error', 'Data already assigned');
            return redirect()->route('assign_courses.edit',$assign_course->id);
        }else{
            $assign_course->save();
            Session::flash('success', 'Data updated successfully');
            return redirect()->route('assign_courses.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignCourse $assignCourse)
    {
        $assignCourse->delete();
        Session::flash('delete-message', 'Data deleted successfully');
        return redirect()->route('assign_courses.index');
    }
}
