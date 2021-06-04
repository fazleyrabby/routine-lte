<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Session;

class CourseController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('id', 'DESC')->get();
        return view('admin.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course_name' => 'required|unique:courses',
            'course_code' => 'required|unique:courses',
            'credit' => 'required'
        ],
            [
                'course_name.required' => 'Enter course name',
                'course_name.unique' => 'Course already exist',
                'course_code.required' => 'Enter course code',
                'course_code.unique' => 'Course code already exist',
                'credit.required' => 'Enter course credit',
            ]);

        $course = new Course();
        $course->course_name = $request->course_name;
        $course->course_code = $request->course_code;
        $course->course_type = $request->course_type;
        $course->credit = $request->credit;
        $course->is_active = 1;
        $course->save();

        Session::flash('message', 'Course created successfully');
        return redirect()->route('courses.index');
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
    public function edit(Course $course)
    {
        return view('admin.course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {

//        dd($request->all());

        $this->validate($request, [
            'course_name' => 'required|unique:courses,course_name,' . $course->id,
            'course_code' => 'required|unique:courses,course_code,' . $course->id,
            'credit' => 'required'
        ],
            [
                'course_name.required' => 'Enter course name',
                'course_name.unique' => 'Course already exist',
                'course_code.required' => 'Enter course code',
                'course_code.unique' => 'Course code already exist',
                'credit.required' => 'Enter course credit',
            ]);

        $course->course_name = $request->course_name;
        $course->course_code = $request->course_code;
        $course->credit = $request->credit;
        $course->course_type = $request->course_type;
        $course->is_active = $request->is_active;
        $course->save();

        Session::flash('message', 'Course updated successfully');
        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        Session::flash('delete-message', 'Course deleted successfully');
        return redirect()->route('courses.index');
    }
}
