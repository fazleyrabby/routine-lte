<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\DayWiseSlot;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DayWiseSlotController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days = Day::with(['day_wise_slot','day_wise_slot.time_slot'])->get();
        return view('admin.day_wise_slot.index', compact('days'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $day = Day::with(['day_wise_slot','day_wise_slot.time_slot'])->where('id',$id)->first();
        $time_slots = TimeSlot::orderBy('from')->get();
        return view('admin.day_wise_slot.create', compact('day','time_slots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            if (!empty($request->day_wise_slot)){
                foreach($request->day_wise_slot as $key => $day_wise_slot){
                    $data[] = [
                        'day_id' => $request->day_id,
                        'time_slot_id' => $day_wise_slot['time_slot'],
                        'class_slot' => $day_wise_slot['class_slot'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                DayWiseSlot::where('day_id',$request->day_id)->delete();
                DayWiseSlot::insert($data);
                Session::flash('message', 'Time slots & Class slot assigned successfully!!');
                return redirect()->route('day_wise_slots');
            }
            else{
                Session::flash('message', 'No Class/Time Slot selected!!');
                return redirect()->route('day_wise_slot_create',$request->day_id);
            }
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $days = Day::all();
        $time_slots = TimeSlot::all();
        return view('admin.day_wise_slot.create', compact('days','time_slots'));
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
