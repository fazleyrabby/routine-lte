<?php

namespace App\Http\Controllers;

use App\Models\YearlySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ShiftSession;
use Illuminate\Support\Facades\DB;
use App\Models\Session as SS;

class YearlySessionController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $yearly_sessions = YearlySession::with('session')->get();

        return view('admin.yearly_session.index', compact('yearly_sessions'));
    }

    public function status(Request $request)
    {
        YearlySession::where('year', '=', $request->year)->update(array('is_active' => $request->is_active));
        Session::flash('message', 'Status Updated successfully');
        return redirect()->route('yearly_sessions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.yearly_session.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sessions = SS::where('is_active','yes')->pluck('id');
        $existSession = YearlySession::where('year',$request->year)->count();

        if ($existSession == 0){
            if ($sessions->count() > 0){
                foreach($sessions as $session){
                    $data[] = [
                        'session_id' => $session,
                        'is_active' => 'no',
                        'year' => $request->year,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
            YearlySession::insert($data);
            Session::flash('error', 'Yearly Sessions Assigned successfully');
            return redirect()->route('yearly_sessions.index');
        }
        else{
            Session::flash('error', 'This year already assigned for sessions');
            return redirect()->route('yearly_sessions.create');
        }











    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\YearlySession  $yearlySession
     * @return \Illuminate\Http\Response
     */
    public function show(YearlySession $yearlySession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\YearlySession  $yearlySession
     * @return \Illuminate\Http\Response
     */
    public function edit(YearlySession $yearlySession)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\YearlySession  $yearlySession
     * @return \Illuminate\Http\Response
     */
    public function update(YearlySession $yearlySession)
    {

        if ($yearlySession->is_active == 'yes'){
            $status = 'no';
        }
        else {
            $status = 'yes';
        }

        $yearlySession->is_active = $status;
        $yearlySession->save();
        Session::flash('error', 'Status changed successfully!!');
        return redirect()->route('yearly_sessions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\YearlySession  $yearlySession
     * @return \Illuminate\Http\Response
     */


    public function destroy($year)
    {
        YearlySession::where('year',$year)->delete();
        Session::flash('delete-message', 'Yearly Session deleted successfully');
        return redirect()->route('yearly_sessions.index');
    }
}
