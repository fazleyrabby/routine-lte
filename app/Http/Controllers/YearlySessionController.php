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
//        $shift_sessions = ShiftSession::with(['session','shift'])
//            ->select(DB::raw('shift_id','GROUP_CONCAT(sessions.session_name)'))
//            ->groupBy('shift_id')
//            ->get();


//        $shift_sessions = DB::table('shift_sessions')
//                          ->leftJoin('shifts', 'shifts.id', '=', 'shift_sessions.shift_id')
//                          ->leftJoin('sessions', 'sessions.id', '=', 'shift_sessions.session_id')
//                          ->select('shift_name',DB::raw('group_concat(sessions.session_name) as session_names'))
//                          ->groupBy('shift_id')->get();

//         $sessions = SS::all();
//        $shift_sessions = ShiftSession::groupBy('shift_id')->with(['session','shift'])->select('shift_id',DB::raw(group_concat(session_name))->get();

//        dd($shift_sessions);

//        $yearly_sessions = YearlySession::groupBy('year')->select('year','is_active', DB::raw('count(*) as total'))->get();
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











//        echo (json_encode($request->year));


//        $this->validate($request, [
//            'shift_id' => 'required',
//            'session_id' => 'required'
//        ],
//            [
//                'shift_id.required' => 'Select Shift',
//                'session_id.required' => 'Select Session',
//            ]);
//
//        $shift_session = new ShiftSession();
//        $shift_session->shift_id = $request->shift_id;
//        $shift_session->session_id = $request->session_id;
//
//        if ($existShift){
//            Session::flash('error', 'Shift wise session already assigned');
//            return redirect()->route('shift_sessions.create');
//        }
//        else{
//            $shift_session->save();
//            Session::flash('message', 'Shift wise session assigned successfully');
//            return redirect()->route('shift_sessions.index');
//        }
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
//        $shift_session = ShiftSession::find($shiftSession->id);
//        $shift_session->delete();
        YearlySession::where('year',$year)->delete();
        Session::flash('delete-message', 'Yearly Session deleted successfully');
        return redirect()->route('yearly_sessions.index');
    }
}
