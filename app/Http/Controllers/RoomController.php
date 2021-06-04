<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoomController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::orderBy('id', 'DESC')->get();
        return view('admin.room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'room_no' => 'required|unique:rooms',
            'building' => 'required',
            'capacity' => 'required',
        ],
            [
                'room_no.required' => 'Enter Room No',
                'capacity.required' => 'Enter Capacity',
                'room_no.unique' => 'Room no already exist',
                'building.required' => 'Enter Building Name'
            ]);

        $room = new Room();
        $room->building = $request->building;
        $room->room_no = $request->room_no;
        $room->capacity = $request->capacity;
        $room->room_type = $request->room_type;
        $room->save();

        Session::flash('message', 'Room created successfully');
        return redirect()->route('rooms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        return view('admin.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $this->validate($request, [
            'room_no' => 'required|unique:rooms,room_no,' . $room->id,
            'capacity' => 'required',
            'building' => 'required',
        ],
            [
                'room_no.required' => 'Enter Room No',
                'room_no.unique' => 'Room no already exist',
                'capacity.required' => 'Enter Capacity',
                'building.required' => 'Enter Building Name'
            ]);

        $room->building = $request->building;
        $room->room_no = $request->room_no;
        $room->room_type = $request->room_type;
        $room->capacity = $request->capacity;
        $room->is_active = $request->is_active;
        $room->save();

        Session::flash('message', 'Room updated successfully');
        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();
        Session::flash('delete-message', 'Room deleted successfully');
        return redirect()->route('rooms.index');
    }
}
