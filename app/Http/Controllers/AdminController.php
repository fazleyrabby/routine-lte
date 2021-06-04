<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\YearlySession;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;

class AdminController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['teacher'] = Teacher::all()->count();
        $data['student'] = Student::sum('number_of_student');
        $data['batch'] = Batch::all()->count();
        $data['course'] = Course::all()->count();
        $teachers = Teacher::with(['department','rank','user'])->get();
        $rooms = Room::orderBy('id', 'DESC')->get();
        $courses = Course::orderBy('id', 'DESC')->get();

        return view('admin.index',compact('data','teachers','rooms','courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function roles(){
        return view('admin.roles');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
