<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Session as SS;
use App\Models\ShiftSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ShiftSessionController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shift_sessions = ShiftSession::with(['session','shift'])->get();
        return view('admin.shift_session.index', compact('shift_sessions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $sessions = SS::orderBy('id', 'ASC')->where('is_active','yes')->pluck('session_name', 'id');
        $shifts = Shift::orderBy('id', 'ASC')->where('is_active','yes')->pluck('shift_name', 'id');
        return view('admin.shift_session.create', compact('sessions','shifts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existShift = ShiftSession::where([
            ['shift_id',$request->shift_id],
            ['session_id',$request->session_id]
        ])->first();

        $this->validate($request, [
            'shift_id' => 'required',
            'session_id' => 'required'
        ],
            [
                'shift_id.required' => 'Select Shift',
                'session_id.required' => 'Select Session',
            ]);

        $shift_session = new ShiftSession();
        $shift_session->shift_id = $request->shift_id;
        $shift_session->session_id = $request->session_id;

        if ($existShift){
            Session::flash('error', 'Shift wise session already assigned');
            return redirect()->route('shift_sessions.create');
        }
        else{
            $shift_session->save();
            Session::flash('message', 'Shift wise session assigned successfully');
            return redirect()->route('shift_sessions.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShiftSession  $shiftSession
     * @return \Illuminate\Http\Response
     */
    public function show(ShiftSession $shiftSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShiftSession  $shiftSession
     * @return \Illuminate\Http\Response
     */
    public function edit(ShiftSession $shiftSession)
    {
        $sessions = SS::orderBy('id', 'ASC')->where('is_active','yes')->pluck('session_name', 'id');
        $shifts = Shift::orderBy('id', 'ASC')->where('is_active','yes')->pluck('shift_name', 'id');
        return view('admin.shift_session.edit', compact('shiftSession','sessions','shifts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShiftSession  $shiftSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShiftSession $shiftSession)
    {
//        dd($request->all());

        $existShift = ShiftSession::where([
            ['id','!=',$shiftSession->id],
            ['shift_id',$request->shift_id],
            ['session_id',$request->session_id]
        ])->count();
//        dd($existShift);
        $this->validate($request, [
            'shift_id' => 'required',
            'session_id' => 'required'
        ],
            [
                'shift_id.required' => 'Select Shift',
                'session_id.required' => 'Select Session',
            ]);


        $shiftSession->shift_id = $request->shift_id;
        $shiftSession->session_id = $request->session_id;
        $shiftSession->is_active = $request->is_active;

        if ($existShift > 0){
            Session::flash('error', 'Shift wise session already assigned');
            return redirect()->route('shift_sessions.edit', $shiftSession->id);
        }
        else{
            $shiftSession->save();
            Session::flash('message', 'Shift wise session assigned successfully');
            return redirect()->route('shift_sessions.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShiftSession  $shiftSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShiftSession $shiftSession)
    {
        $shift_session = ShiftSession::find($shiftSession->id);
        $shift_session->delete();
        Session::flash('delete-message', 'Shift Session deleted successfully');
        return redirect()->route('shift_sessions.index');
    }
}
