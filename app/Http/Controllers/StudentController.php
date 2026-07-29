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
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\Services\AdminListingService $listing)
    {
        $result = $listing->process(
            Student::query()->with(['batch', 'batch.shift', 'batch.department', 'section_student', 'yearly_session', 'yearly_session.session', 'section_student.section']),
            ['name', 'roll_no', 'reg_no', 'email', 'phone']
        );

        $shifts = Shift::all();

        return view('admin.student.index', $result + ['students' => $result['items'], 'shifts' => $shifts]);
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

        $sections = Section::where('is_active', 'yes')->get();

        return view('admin.student.create', compact('batches', 'sections', 'sessions'));
    }

    public function store(StoreStudentRequest $request)
    {
        $existStudentId = Student::where('batch_id', $request->batch_id)->pluck('id')->first();

        $student = new Student();


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
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->number_of_student = $request->number_of_student;
        $student->batch_id = $request->batch_id;
        $student->yearly_session_id = $request->yearly_session_id;

        SectionStudent::where('student_id', $student->id)->delete();
        Routine::where('batch_id', $request->batch_id)->delete();
        $student->save();

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
        $student = Student::with(['batch', 'batch.shift', 'batch.department', 'section_student', 'section_student.section'])->orderBy('id', 'DESC')->where('students.id', $id)->first();
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
