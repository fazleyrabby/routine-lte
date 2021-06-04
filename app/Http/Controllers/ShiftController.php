<?php

namespace App\Http\Controllers;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShiftController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts = Shift::orderBy('id', 'DESC')->get();
        return view('admin.shift.index', compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'shift_name' => 'required|unique:shifts'
        ],
            [
                'shift_name.required' => 'Enter shift name',
                'shift_name.unique' => 'Shift already exist',
            ]);

        $shift = new Shift();
        $shift->shift_name = $request->shift_name;
        $shift->slug = strtoupper(substr($shift->shift_name, 0, 1));
        $shift->save();

        Session::flash('message', 'Shift created successfully');
        return redirect()->route('shifts.index');
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
    public function edit(Shift $shift)
    {
        return view('admin.shift.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        $this->validate($request, [
            'shift_name' => 'required|unique:shifts,shift_name,' . $shift->id
        ],
            [
                'shift_name.required' => 'Enter shift name',
                'shift_name.unique' => 'Shift already exist',
            ]);

        $shift->shift_name = $request->shift_name;
        $shift->slug = strtoupper(substr($shift->shift_name, 0, 1));
        $shift->is_active = $request->is_active;
        $shift->save();

        Session::flash('message', 'Shift Updated successfully');
        return redirect()->route('shifts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();
        Session::flash('delete-message', 'Shift deleted successfully');
        return redirect()->route('shifts.index');
    }
}
