<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeachersOffday;
use Illuminate\Http\Request;
use App\Models\Day;
use Illuminate\Support\Facades\Session;

class TeachersOffdayController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $days = Day::all();
        $teacher = Teacher::with(['user','teachers_offday'])->where('teachers.id',$id)->first();
        return view('admin.teacher.offday', compact('days','teacher'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (count($request->offday) <= 2){
            foreach ($request->offday as $key => $offday) {
                $data[] = [
                    'teacher_id' => $request->teacher_id,
                    'day_id' => $offday,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            TeachersOffday::where('teacher_id',$request->teacher_id)->delete();
            TeachersOffday::insert($data);
            return redirect()->route('teachers.index');
        }
        else{
            Session::flash('message', 'Off Day Cannot be more than 2 days!!');
            return redirect()->route('teachers_offday',$request->teacher_id);
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
