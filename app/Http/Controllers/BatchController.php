<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Models\Batch;
use Illuminate\Support\Facades\Session;

class BatchController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batches = Batch::orderBy('id', 'DESC')->get();
        return view('admin.batch.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('id', 'ASC')->where('is_active','yes')->pluck('department_name', 'id');
        $shifts = Shift::orderBy('id', 'ASC')->where('is_active','yes')->pluck('shift_name', 'id');
        return view('admin.batch.create',compact('departments','shifts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existBatch = Batch::where([
            ['batch_no',$request->batch_no],
            ['department_id',$request->department_id],
            ['shift_id',$request->shift_id]
        ])->first();

        $this->validate($request, [
            'batch_no' => 'required',
            'shift_id' => 'required',
            'department_id' => 'required',
        ],
            [
                'batch_no.required' => 'Enter batch',
                'shift_id.required' => 'Enter Shift',
                'department_id.required' => 'Enter Department',
            ]);

        $batch = new Batch();
        $batch->batch_no = $request->batch_no;
        $batch->department_id = $request->department_id;
        $batch->shift_id = $request->shift_id;

        if ($existBatch){
            Session::flash('error', 'Batch already assigned');
            return redirect()->route('batches.create');
        }else{
            $batch->save();
            Session::flash('message', 'Batch assigned successfully');
            return redirect()->route('batches.index');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        $departments = Department::orderBy('id', 'ASC')->where('is_active','yes')->pluck('department_name', 'id');
        $shifts = Shift::orderBy('id', 'ASC')->where('is_active','yes')->pluck('shift_name', 'id');
        return view('admin.batch.edit', compact('batch','departments','shifts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Batch $batch)
    {
        $existBatch = Batch::where([
            ['id','<>',$batch->id],
            ['batch_no','=',$request->batch_no],
            ['department_id','=',$request->department_id],
            ['shift_id','=',$request->shift_id]
        ])->count();

        $this->validate($request, [
            'batch_no' => 'required',
            'shift_id' => 'required',
            'department_id' => 'required',
        ],
            [
                'batch_no.required' => 'Enter batch',
                'shift_id.required' => 'Enter Shift',
                'department_id.required' => 'Enter Department',
            ]);

        $batch->batch_no = $request->batch_no;
        $batch->department_id = $request->department_id;
        $batch->shift_id = $request->shift_id;
        $batch->is_active = $request->is_active;

        if ($existBatch > 0){
            Session::flash('error', 'Batch already assigned');
            return redirect()->route('batches.edit', $batch->id);
        }else{
            $batch->save();
            Session::flash('message', 'Batch updated successfully');
            return redirect()->route('batches.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();
        Session::flash('delete-message', 'Batch deleted successfully');
        return redirect()->route('batches.index');
    }
}
