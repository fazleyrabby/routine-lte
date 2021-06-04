<?php

namespace App\Http\Controllers;
use App\Models\CourseOffer;
use App\Models\Batch;
use App\Models\Course;
use App\Models\YearlySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CourseOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $course_offers = CourseOffer::with(['batch','session.session','course:id'])->get();
        $course_offers = CourseOffer::select("*","course_offers.id as course_offer_id", DB::raw("GROUP_CONCAT(courses.course_code,' | ',courses.course_name,' | ', if(courses.course_type='0','Theory','Sessional'), ' | Credit -',courses.credit) as course "))
            ->leftJoin('batch','batch.id','course_offers.batch_id')
            ->leftJoin('yearly_sessions','yearly_sessions.id','course_offers.yearly_session_id')
            ->leftJoin('sessions','sessions.id','yearly_sessions.session_id')
            ->leftJoin('shifts','shifts.id','batch.shift_id')
            ->leftJoin('departments','departments.id','batch.department_id')
            ->leftjoin('courses',DB::raw("FIND_IN_SET(courses.id, course_offers.courses)"),">", DB::raw("'0'"))
            ->groupBy('course_offers.id')
            ->get();


        return view('admin.course_offer.index', compact('course_offers'))->with('i', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $batches = Batch::with(['shift','department'])->get();
        $courses = Course::where('is_active','yes')->get();
        $sessions = YearlySession::with('session')->where('is_active','yes')->get();

        return view('admin.course_offer.create', compact('batches','sessions','courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courses = implode(",", $request->courses);

        $exists = CourseOffer::where([
            ['batch_id', $request->batch_id],
            ['yearly_session_id', $request->yearly_session_id],
        ])->count();

            $course_offer = new CourseOffer();
            $course_offer->yearly_session_id = $request->yearly_session_id;
            $course_offer->courses = $courses;
            $course_offer->batch_id = $request->batch_id;

        if ($exists){
            Session::flash('error', 'Data already assigned');
            return redirect()->route('course_offers.create');
        }else{
            $course_offer->save();
            Session::flash('success', 'Data assigned successfully');
            return redirect()->route('course_offers.index');
        }


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
     * @param CourseOffer $courseOffer
     * @return void
     */
    public function edit(CourseOffer $course_offer)
    {
        $batches = Batch::with(['shift','department'])->get();
        $courses = Course::where('is_active','yes')->get();
        $sessions = YearlySession::with('session')->where('is_active','yes')->get();
        return view('admin.course_offer.edit', compact('batches','sessions','courses','course_offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseOffer $course_offer)
    {
        $courses = implode(",", $request->courses);

        $exists = CourseOffer::where([
            ['batch_id', $request->batch_id],
            ['id', '!=', $course_offer->id],
            ['yearly_session_id', $request->yearly_session_id],
        ])->count();

        $course_offer->yearly_session_id = $request->yearly_session_id;
        $course_offer->courses = $courses;
        $course_offer->batch_id = $request->batch_id;

        if ($exists){
            Session::flash('error', 'Data already assigned');
            return redirect()->route('course_offers.edit',$course_offer->id);
        }else{
            $course_offer->save();
            Session::flash('success', 'Data updated successfully');
            return redirect()->route('course_offers.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseOffer $courseOffer)
    {
        $courseOffer->delete();
        Session::flash('delete-message', 'Data deleted successfully');
        return redirect()->route('course_offers.index');
    }
}
