<?php

namespace App\Http\Controllers;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SectionController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $sections = Section::orderBy('id', 'DESC')->get();

        $sections = Section::select(['sections.*', 'sub.section_name as sub'])
            ->leftJoin('sections as sub', 'sub.id', '=', 'sections.parent')
            ->get();

        return view('admin.section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::orderBy('section_name', 'ASC')->where('parent',0)->pluck('section_name','id')->prepend('Select section',0);
        return view('admin.section.create',compact('sections'));
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
            'section_name' => 'required|max:2|unique:sections'
        ],
            [
                'section_name.required' => 'Enter Section',
                'section_name.unique' => 'Section already exist',
            ]);

        $section = new Section();
        $section->section_name = $request->section_name;
        $section->parent = $request->parent;
        $section->type = $request->type;
        $section->slug = strtolower($request->section_name);
        $section->is_active = 1;
        $section->save();

        Session::flash('message', 'Section created successfully');
        return redirect()->route('sections.index');
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
    public function edit(Section $section)
    {
        $parents = Section::orderBy('section_name', 'ASC')->where('parent',0)->get();
        return view('admin.section.edit', compact('section','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $this->validate($request, [
            'section_name' => 'required|max:2|unique:sections,section_name,' . $section->id
        ],
            [
                'section_name.required' => 'Enter Section',
                'section_name.unique' => 'Section already exist',
            ]);

        $section->section_name = $request->section_name;
        $section->parent = $request->parent;
        $section->type = $request->type;
        $section->slug = strtolower($request->section_name);
        $section->is_active = $request->is_active;
        $section->save();

        Session::flash('message', 'Section Updated successfully');
        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        Session::flash('delete-message', 'Section deleted successfully');
        return redirect()->route('sections.index');
    }

}
