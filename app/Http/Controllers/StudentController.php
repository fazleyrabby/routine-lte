<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\SectionStudent;
use App\Models\YearlySession;
use App\Models\Shift;
use App\Models\FullRoutine as Routine;
use App\Models\StudentsLog;

class StudentController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with(['batch', 'batch.shift', 'batch.department', 'section_student', 'yearly_session', 'yearly_session.session', 'section_student.section'])->get();

//        dd($students);

//        $students = Student::select('students.id','department_name','batch_no','shifts.slug','session_name','year','students.number_of_student')
//            ->leftJoin('batch', 'shift_sessions.id', '=', 'yearly_sessions.shift_session_id')
//            ->leftJoin('shifts', 'shifts.id', '=', 'shift_sessions.shift_id')
//            ->leftJoin('sessions', 'sessions.id', '=', 'shift_sessions.session_id')
//            ->leftJoin('departments', 'sessions.id', '=', 'shift_sessions.session_id')
//            ->leftJoin('section_students', 'sessions.id', '=', 'shift_sessions.session_id')
//            ->leftJoin('shift_sessions', 'sessions.id', '=', 'shift_sessions.session_id')
//            ->leftJoin('sections', 'sessions.id', '=', 'shift_sessions.session_id')
//            ->where('shifts.id',$shift_id)
//            ->get();


        // dd($students);

        $shifts = Shift::all();


        return view('admin.student.index', compact('students', 'shifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($shift_id)
    {

        $batches = Batch::with(['shift', 'department'])->where('shift_id', $shift_id)->get();

        $sessions = YearlySession::with('session')->get();

//        dd($sessions);

//        $sessions = YearlySession::select('yearly_sessions.id','session_name','year')
////                            ->leftJoin('shift_sessions', 'shift_sessions.id', '=', 'yearly_sessions.shift_session_id')
////                            ->leftJoin('shifts', 'shifts.id', '=', 'shift_sessions.shift_id')
//                            ->leftJoin('sessions', 'sessions.id', '=', 'yearly_sessions.session_id')
////                            ->where('shifts.id',$shift_id)
//                            ->get();

        $sections = Section::where('is_active', 'yes')->get();

        return view('admin.student.create', compact('batches', 'sections', 'sessions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'number_of_student' => 'required',
////            'batch_id' => 'required|unique:students'
//            'batch_id' => 'required|unique:students,batch_id,' . $request->batch_id . ',id,yearly_session_id,' . $request->yearly_session_id
//        ],
//            [
//                'batch_id.unique' => 'Data already exists for this batch',
//                'batch_id.required' => 'Enter Batch',
//                'number_of_student.required' => 'Enter Number of Student',
//            ]);

        $existStudentId = Student::where('batch_id', $request->batch_id)->pluck('id')->first();

            $student = new Student();
//            $students_log = new StudentsLog();
//            $students_log->number_of_student = $student->number_of_student = $request->number_of_student;
//            $students_log->batch_id = $student->batch_id = $request->batch_id;
//            $students_log->yearly_session_id = $student->yearly_session_id = $request->yearly_session_id;
//            $students_log->save();


        $student->number_of_student = $request->number_of_student;
        $student->batch_id = $request->batch_id;
        $student->yearly_session_id = $request->yearly_session_id;

        if (!empty($existStudentId)) {
            Student::findOrFail($existStudentId)->delete();
//                Routine::where('batch_id', $request->batch_id)->delete();
        }

        $student->save();
        Session::flash('message', 'Student assigned successfully');
        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {

        $shift = Shift::select('shifts.id')->leftJoin('batch', 'batch.shift_id', '=', 'shifts.id')->where('batch.id', $student->batch_id)->pluck('id')->first();

        $batches = Batch::with(['shift', 'department'])->where('shift_id', $shift)->get();


//        $sessions = YearlySession::select('yearly_sessions.id as id','session_name','year')
//            ->leftJoin('shift_sessions', 'shift_sessions.id', '=', 'yearly_sessions.shift_session_id')
//            ->leftJoin('shifts', 'shifts.id', '=', 'shift_sessions.shift_id')
//            ->leftJoin('sessions', 'sessions.id', '=', 'shift_sessions.session_id')
//            ->where('shifts.id',$shift)
//            ->get();

        $sessions = YearlySession::with('session')->get();

        return view('admin.student.edit', compact('batches', 'student', 'sessions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student, StudentsLog $students_log)
    {

        $this->validate($request, [
            'number_of_student' => 'required',
//            'batch_id' => 'required|unique:students,batch_id,' . $student->id
            'batch_id' => 'required|unique:students,batch_id,' . $student->id
        ],
            [
                'number_of_student.required' => 'Enter Section',
                'batch_id.unique' => 'Data already exist for this batch',
            ]);

//        $students_log->number_of_student = $student->number_of_student = $request->number_of_student;
//        $students_log->batch_id = $student->batch_id = $request->batch_id;
//        $students_log->yearly_session_id = $student->yearly_session_id = $request->yearly_session_id;

        $student->number_of_student = $request->number_of_student;
        $student->batch_id = $request->batch_id;
        $student->yearly_session_id = $request->yearly_session_id;

        SectionStudent::where('student_id', $student->id)->delete();
        Routine::where('batch_id', $request->batch_id)->delete();
        $student->save();
//        $students_log->save();

        Session::flash('message', 'Student Number updated successfully');
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {

        $student->delete();
        Routine::where('batch_id', $student->batch_id)->delete();
        Session::flash('delete-message', 'Number of student deleted successfully');
        return redirect()->route('students.index');
    }


    public function theory_section($id)
    {
        $sections = Section::where('type', 'theory')->get();
        $student = Student::with(['batch', 'batch.shift', 'batch.department', 'section_student'])->orderBy('id', 'DESC')->where('students.id', $id)->get()->first();
//        $student = $student[0];
//        $section_student = SectionStudent::where('student_id',$student->id)->get();

        return view('admin.student.theory_section', compact('sections', 'student'));
    }

    public function theory_section_store(Request $request)
    {
        if (empty($request->student_section)) {
            Session::flash('error', 'No value given!!');
            return redirect()->route('theory_section', $request->student_id);
        }
        $total_student = 0;

        foreach ($request->student_section as $student_section) {
            $total_student += $student_section['student'];
        }

        if ($total_student == intval($request->total_students)) {
            foreach ($request->student_section as $key => $student_section) {
                $data[] = [
                    'student_id' => $request->student_id,
                    'section_id' => $student_section['section'],
                    'students' => $student_section['student'],
                    'section_type' => "theory",
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            SectionStudent::where([
                ['student_id', $request->student_id],
                ['section_type', 'theory']
            ])->delete();

            Routine::where('batch_id', $request->batch_id)->delete();

            SectionStudent::insert($data);
            Session::flash('message', 'Section Assigned');
            return redirect()->route('students.index');
        } else {
            Session::flash('error', 'Total Student number not matched');
            return redirect()->route('theory_section', $request->student_id);
        }
    }
    public function lab_section($id)
    {
        $sections = Section::where('type', 'lab')->get();
        $student = Student::with(['batch', 'batch.shift', 'batch.department', 'section_student', 'section_student.section'])->orderBy('id', 'DESC')->whereRaw('students.id=' . $id)->get()->first();
        return view('admin.student.lab_section', compact('sections', 'student'));
    }

    public function lab_section_store(Request $request)
    {
        $total_student = 0;
        foreach ($request->student_section as $student_section) {
            $total_student += $student_section['student'];
        }
        foreach ($request->student_section as $key => $student_section) {
            $data[] = [
                'student_id' => $request->student_id,
                'section_id' => $student_section['section'],
                'students' => $student_section['student'],
                'section_type' => "lab",
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        SectionStudent::where([
            ['student_id', $request->student_id],
            ['section_type', 'lab']
        ])->delete();
        Routine::where('batch_id', $request->batch_id)->delete();
        SectionStudent::insert($data);
        Session::flash('message', 'Section Assigned');
        return redirect()->route('students.index');
    }
}


//public function lab_section($id){
//    $sections = Section::where('type','lab')->get();
//
//    $student = Student::with(['batch','batch.shift','batch.department','section_student','section_student.section'])->orderBy('id', 'DESC')->whereRaw('students.id='.$id)->get()->first();
//
//
////        $student = Student::select('students.*','batch.batch_no','departments.department_name','sections.section_name','shifts.shift_name','section_students.students','section_students.section_type')
////            ->leftJoin('batch', 'batch.id', '=', 'students.batch_id')
////            ->leftJoin('shifts', 'shifts.id', '=', 'batch.shift_id')
////            ->leftJoin('departments', 'departments.id', '=', 'batch.department_id')
////            ->leftJoin('section_students', 'section_students.student_id', '=', 'students.id')
////            ->leftJoin('sections', 'sections.id', '=', 'section_students.section_id')
////            ->where('students.id', $id)
////            ->where('section_students.section_type', 'theory')
////            ->get();
//
//
////        $section_student = SectionStudent::with('section')->orderBy('id', 'DESC')->where('section_students.student_id', $id)->get();
//
////        dd($student);
//
//    return view('admin.student.lab_section',compact('sections','student'));
//}
