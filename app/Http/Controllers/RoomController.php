<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;

class RoomController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\Services\AdminListingService $listing)
    {
        $result = $listing->process(
            Room::query(),
            ['room_no', 'building'],
            ['is_active' => ['yes', 'no'], 'room_type' => ['0', '1']]
        );

        return view('admin.room.index', $result + ['rooms' => $result['items']]);
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
    public function store(StoreRoomRequest $request)
    {
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
    public function update(UpdateRoomRequest $request, Room $room)
    {
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
