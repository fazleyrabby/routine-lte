<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherRank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TeacherRankController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ranks = TeacherRank::orderBy('id', 'DESC')->get();
        return view('admin.rank.index', compact('ranks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rank.create');
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
            'rank' => 'required|unique:teacher_ranks'
        ],
            [
                'rank.required' => 'Enter Rank',
                'rank.unique' => 'Rank already exist',
            ]);

        $rank = new TeacherRank();
        $rank->rank = $request->rank;
        $rank->is_active = 1;
        $rank->save();

        Session::flash('message', 'Rank created successfully');
        return redirect()->route('ranks.index');
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
    public function edit(TeacherRank $rank)
    {
        return view('admin.rank.edit', compact('rank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,TeacherRank $rank)
    {
        $this->validate($request, [
            'rank' => 'required|unique:teacher_ranks,rank,' . $rank->id
        ],
            [
                'rank.required' => 'Enter rank name',
                'rank.unique' => 'Rank already exist',
            ]);

        $rank->rank = $request->rank;
        $rank->is_active = $request->is_active;
        $rank->save();

        Session::flash('message', 'Rank Updated successfully');
        return redirect()->route('ranks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherRank $rank)
    {
        $rank->delete();
        Session::flash('delete-message', 'Rank deleted successfully');
        return redirect()->route('ranks.index');
    }
}
