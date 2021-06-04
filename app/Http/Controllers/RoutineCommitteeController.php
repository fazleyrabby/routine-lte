<?php

namespace App\Http\Controllers;
use App\Models\Teacher;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RoutineInviteRequest;
use App\Models\RoutineCommittee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoutineCommitteeController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.routine_committee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.routine_committee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expired_on = date('Y-m-d H:i:s', strtotime($request->expired_date));
//        dd($expired_on);
        $existData = RoutineCommittee::where([
            ['receiver_id',$request->receiver_id],
            ['request_status','active'],
            ['expired_date','>', now()]
        ])->count();

        if($existData == 0){
            $user = User::where('id', $request->receiver_id)->select('firstname','lastname','email')->first();
//            $expire_after = $request->expire_after;
            $routine_committee = new RoutineCommittee();
            $routine_committee->sender_id = $request->sender_id;
            $routine_committee->receiver_id = $request->receiver_id;
//            $routine_committee->expire_after = $request->expire_after;
            $routine_committee->expired_date = $expired_on;
            RoutineCommittee::where('receiver_id',$request->receiver_id)->delete();
            $routine_committee->save();

            $data = [
                'receiver' => $user->firstname." ".$user->lastname,
                'sender' => Auth::user()->firstname." ".Auth::user()->lastname,
                'expired_date' => date('d-m-Y h:i a', strtotime($routine_committee->expired_date))
            ];

            Mail::to($user->email)->send(new RoutineInviteRequest($data));

            Session::flash('message', 'Invitation Send successfully!');
        }else{
            Session::flash('message', 'Sorry Invitation already sent!!');
        }
        return redirect()->route('teachers.index');
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

    public function temp_routine_access(Request $request){
        RoutineCommittee::where("receiver_id", $request->user_id)->update(["request_status" => 'expired']);
        Session::flash('message', 'Temporary access removed!');
        return redirect()->route('teachers.index');
    }

    public function routine_committee_status(Request $request){
        User::where("id", $request->user_id)->update(["in_committee" => $request->in_committee]);
        Session::flash('message', 'Routine Access Updated!');
        return redirect()->route('teachers.index');
    }


}
