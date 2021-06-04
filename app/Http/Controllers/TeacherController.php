<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Cassandra\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\User;
use App\Models\TeacherRank;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class TeacherController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::with(['department','rank','user','teachers_offday.day'])->get();
        return view('admin.teacher.index', compact('teachers'));
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
    public function store(Request $request)
    {
//        $this->validate($request, ['file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
        $this->validate($request, [
//            'firstname' => 'required',
//            'lastname' => 'required',
            'email' => 'required',
//            'contact' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000'
        ],
            [
//                'firstname.required' => 'Enter First name',
//                'lastname.required' => 'Enter Last name',
                'email.required' => 'Enter email',
//                'contact.required' => 'Enter contact number',
            ]);



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
        $user->password = Hash::make('123456');

        $teacher->department_id = $request->department_id;
        $teacher->slug = $request->slug;
        $teacher->rank_id = $request->rank_id;
        $teacher->join_date = date('Y-m-d', strtotime($request->join_date));


        if ($request->photo){

            $image_url = $request->photo;
            //Get file with extension
            $fileNameWithExt = $image_url->getClientOriginalName();

            //Get just file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get file extension
            $fileExt = $image_url->getClientOriginalExtension();

            //Get file name to store
            $fileNameToStore = $filename.time().'_'. $fileExt;

            $user->photo = $fileNameToStore;
            $path = storage_path().'/app/public/uploads/';

            $image_url->move($path,$fileNameToStore);
            $image = Image::make($path.$fileNameToStore);
            $image->resize(300,300);
            $image->save($path.$fileNameToStore);
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
    public function update(Request $request, Teacher $teacher)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users,email,' . $teacher->user_id,
            'contact' => 'required|unique:users,contact,' . $teacher->user_id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ],
            [
                'firstname.required' => 'Enter First name',
                'lastname.required' => 'Enter Last name',
                'email.required' => 'Enter email',
                'email.unique' => 'Email already exists',
                'contact.unique' => 'Contact number already exists',
                'contact.required' => 'Enter Contact number',
            ]);

        $user = User::find($teacher->user_id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->contact = $request->contact;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->gender = $request->gender;
        $user->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
        $user->password = Hash::make('123456');

        $teacher->department_id = $request->department_id;
        $teacher->rank_id = $request->rank_id;
        $teacher->slug = $request->slug;
        $teacher->join_date = date('Y-m-d', strtotime($request->join_date));


        if ($request->photo){

            $image_url = $request->photo;
            //Get file with extension
            $fileNameWithExt = $image_url->getClientOriginalName();

            //Get just file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get file extension
            $fileExt = $image_url->getClientOriginalExtension();

            //Get file name to store
            $fileNameToStore = $filename.time().'_'. $fileExt;

            $user->photo = $fileNameToStore;

            $path = storage_path().'/app/public/uploads/';

            $image_url->move($path,$fileNameToStore);
            $image = Image::make($path.$fileNameToStore);
            $image->fit(300,300);
            $image->save($path.$fileNameToStore);
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
