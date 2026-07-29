<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Cassandra\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\Models\User;
use App\Models\TeacherRank;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Laravel\Facades\Image;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;

class TeacherController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\Services\AdminListingService $listing)
    {
        $result = $listing->process(
            Teacher::query()->with(['department','rank','user','teachers_offday.day']),
            ['slug', 'user.firstname', 'user.lastname', 'user.email']
        );

        return view('admin.teacher.index', $result + ['teachers' => $result['items']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ranks = TeacherRank::orderBy('id', 'ASC')->where('is_active','yes')->pluck('rank', 'id');
        $departments = Department::orderBy('id', 'ASC')->where('is_active','yes')->pluck('department_name', 'id');
        return view('admin.teacher.create', compact('ranks','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        $teacher = new Teacher();
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->contact = $request->contact;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->gender = $request->gender;
        $user->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
        $user->password = Hash::make(config('app.default_password', '123456'));

        $teacher->department_id = $request->department_id;
        $teacher->slug = $request->slug;
        $teacher->rank_id = $request->rank_id;
        $teacher->join_date = date('Y-m-d', strtotime($request->join_date));

        if ($request->photo) {
            $image_url = $request->photo;
            $fileNameWithExt = $image_url->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $image_url->getClientOriginalExtension();
            $fileNameToStore = $filename.time().'_'. $fileExt;

            $user->photo = $fileNameToStore;
            $path = storage_path().'/app/public/uploads/';

            $image_url->move($path, $fileNameToStore);
            Image::read($path.$fileNameToStore)
                ->resize(300, 300)
                ->save($path.$fileNameToStore);
        }

        $user->save();
        User::find($user->id)->teacher()->save($teacher);

        Session::flash('message', 'Teacher added successfully');
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
    public function edit(Teacher $teacher)
    {
        $ranks = TeacherRank::orderBy('id', 'ASC')->where('is_active','yes')->pluck('rank', 'id');
        $departments = Department::orderBy('id', 'ASC')->where('is_active','yes')->pluck('department_name', 'id');
        return view('admin.teacher.edit', compact('teacher','ranks','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $user = User::find($teacher->user_id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->contact = $request->contact;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->gender = $request->gender;
        $user->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));

        $teacher->department_id = $request->department_id;
        $teacher->rank_id = $request->rank_id;
        $teacher->slug = $request->slug;
        $teacher->join_date = date('Y-m-d', strtotime($request->join_date));


        if ($request->photo){
            $image_url = $request->photo;
            $fileNameWithExt = $image_url->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $image_url->getClientOriginalExtension();
            $fileNameToStore = $filename.time().'_'. $fileExt;

            $user->photo = $fileNameToStore;

            $path = storage_path().'/app/public/uploads/';

            $image_url->move($path, $fileNameToStore);
            Image::read($path.$fileNameToStore)
                ->cover(300, 300)
                ->save($path.$fileNameToStore);
        }

        $user->save();
        User::find($teacher->user_id)->teacher()->save($teacher);

        Session::flash('message', 'Teacher Updated successfully');
        return redirect()->route('teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $user = User::find($teacher->user_id);
        $user->teacher()->delete();
        $user->delete();
        Session::flash('delete-message', 'Teacher deleted successfully');
        return redirect()->route('teachers.index');
    }


}
