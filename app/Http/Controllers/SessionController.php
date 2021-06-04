<?php

namespace App\Http\Controllers;

use App\Models\Session as SS;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class SessionController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = SS::orderBy('id', 'DESC')->get();
        return view('admin.session.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.session.create');
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
            'session_name' => 'required|unique:sessions'
        ],
            [
                'session_name.required' => 'Enter session',
                'session_name.unique' => 'session already exist',
            ]);

        $session = new SS();
        $session->session_name = $request->session_name;
        $session->is_active = 1;
        $session->save();

        \Illuminate\Support\Facades\Session::flash('message', 'session created successfully');
        return redirect()->route('sessions.index');
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
    public function edit(SS $session)
    {
        return view('admin.session.edit', compact('session'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SS $session)
    {
        $this->validate($request, [
            'session_name' => 'required|unique:sessions,session_name,' . $session->id
        ],
            [
                'session_name.required' => 'Enter session',
                'session_name.unique' => 'session already exist',
            ]);

        $session->session_name = $request->session_name;
        $session->is_active = $request->is_active;
        $session->save();

        \Illuminate\Support\Facades\Session::flash('message', 'Session created successfully');
        return redirect()->route('sessions.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SS $session)
    {
        $session->delete();
        Session::flash('delete-message', 'session deleted successfully');
        return redirect()->route('sessions.index');
    }
}
