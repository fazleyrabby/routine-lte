<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Department;
use App\Models\RoutineCommittee;
use App\Models\Teacher;
use App\Models\TeacherRank;
use App\Models\TeachersOffday;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'user'){
            abort(404);
        }
        return redirect()->route('teachers.index');
//        if (Auth::user()->role == 'user'){
//            abort(404);
//        }
//        $users = User::with('sender','receiver')->get();
////        $requests = RoutineCommittee::all();
//        return view('admin.user.index',compact('users'))->with('sl',1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role == 'user'){
            abort(404);
        }
        return redirect()->route('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role == 'user'){
            abort(404);
        }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $is_teacher = User::where('id', $id)->pluck('is_teacher')->first();

        if ( Auth::user()->role == 'user' && Auth::id() != $id ){
            abort(404);
        }

        if($is_teacher == 'yes'){
            $user = Teacher::with(['department','rank','user','teachers_offday.day'])->where('user_id',$id)->first();
        }else{
            $user = User::where('id',$id)->first();
        }

        return view('admin.user.show', compact('user','id','is_teacher'));
    }

    public function teacher_offday($id){
        $days = Day::all();
        $teacher = Teacher::with(['user','teachers_offday'])->where('teachers.id',$id)->first();
        return view('admin.user.offday', compact('days','teacher'));
    }
    public function assign_teacher_offday(Request $request){
          if (count($request->offday) <= 2){
                foreach ($request->offday as $key => $offday) {
                    $data[] = [
                        'teacher_id' => $request->teacher_id,
                        'day_id' => $offday,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                TeachersOffday::where('teacher_id',$request->teacher_id)->delete();
                TeachersOffday::insert($data);
                return redirect()->route('users.show',$request->user_id);
            }
            else{
                Session::flash('message', 'Off Day Cannot be more than 2 days!!');
                return redirect()->route('teacher_offday',$request->teacher_id);
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
        $user = Teacher::with(['department','rank','user','teachers_offday.day'])->where('user_id',$id)->first();
        $ranks = TeacherRank::orderBy('id', 'ASC')->where('is_active','yes')->pluck('rank', 'id');
        $departments = Department::orderBy('id', 'ASC')->where('is_active','yes')->pluck('department_name', 'id');
        return view('admin.user.edit', compact('user','ranks','departments'));
//        return view('admin.user.edit', compact('user'));
    }

    public function profile_edit($id){
        $user = Teacher::with(['department','rank','user','teachers_offday.day'])->where('user_id',$id)->first();
        $ranks = TeacherRank::orderBy('id', 'ASC')->where('is_active','yes')->pluck('rank', 'id');
        $departments = Department::orderBy('id', 'ASC')->where('is_active','yes')->pluck('department_name', 'id');
        return view('admin.user.profile_edit', compact('user','ranks','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ],
            [
                'firstname.required' => 'Enter First name',
                'lastname.required' => 'Enter Last name',
                'email.required' => 'Enter email',
                'email.unique' => 'Email already exists',
            ]);

        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->contact = '123456';
        $user->email = $request->email;
        $user->username = $request->username;
        $user->gender = $request->gender;
        $user->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
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


        if (Auth::user()->role == 'superadmin'){
            $teacher->department_id = $request->department_id;
            $teacher->rank_id = $request->rank_id;
            $user->role = $request->role;
        }

        $user->save();
        $teacher->save();

        Session::flash('message', 'Updated successfully');
        return redirect()->route('users.show',$user->id);
    }


    public function password_edit(){
        return view('admin.user.password_edit');
    }

    public function password_update(Request $request){
        $existing_password_hash = User::where('id', $request->user_id)->pluck('password')->first();
        $new_password = $request->password;
        $new_password_repeat = $request->re_password;

//        echo Auth::user()->password;
//        echo "<br>";
//        echo Auth::user()->id;
//        echo "<br>";
//        echo $old_password_hash;
//        exit();

        if (!Hash::check($request->old_password, $existing_password_hash)) {
            Session::flash('message', 'Old password did not match!');
            return redirect()->route('password_edit');
        }

        if ($new_password != $new_password_repeat){
            Session::flash('password', 'Password did not match!');
            return redirect()->route('password_edit');
        }

        User::where("id", $request->user_id)->update(["password" => Hash::make($request->password)]);
        Auth::logout();
        Session::flush();
        return redirect()->route('login');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
//        $user->delete();
        $user->is_active = $request->is_active;

        Session::flash('delete-message', 'User deleted successfully');
        return redirect()->route('users.index');
    }
}
