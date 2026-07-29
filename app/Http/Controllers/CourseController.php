<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\Services\AdminListingService $listing)
    {
        $result = $listing->process(
            Course::query(),
            ['course_name', 'course_code'],
            ['is_active' => ['yes', 'no'], 'course_type' => ['0', '1']]
        );

        return view('admin.course.index', $result + ['courses' => $result['items']]);
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
    public function store(StoreCourseRequest $request)
    {
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
    public function update(UpdateCourseRequest $request, Course $course)
    {
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
