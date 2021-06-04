<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/routine', 'HomeController@routine')->name('routine');
Route::post('/routine_view', 'HomeController@routine_view')->name('routine_view');
Route::post('/routine_print', 'HomeController@routine_print')->name('routine_print');
Route::post('reset_password_with_token', 'UserController@resetPassword')->name('reset_password_with_token');


Route::group(['prefix' => 'admin','middleware' => 'auth'], function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('teachers/requests', 'TeacherController@requests')->name('teachers.requests');
    Route::resource('sessions', 'SessionController');
    Route::resource('shift_sessions', 'ShiftSessionController');
    Route::resource('yearly_sessions', 'YearlySessionController');
    Route::resource('shifts', 'ShiftController')->middleware('auth_admin');
    Route::resource('rooms', 'RoomController')->middleware('auth_admin');
    Route::resource('departments', 'DepartmentController')->middleware('auth_admin');
    Route::resource('teachers', 'TeacherController')->middleware('auth_admin');
    Route::resource('courses', 'StudentController')->middleware('auth_admin');
    Route::resource('batches', 'BatchController')->middleware('auth_admin');
    Route::resource('sections', 'SectionController')->middleware('auth_admin');



    Route::resource('users', 'UserController');

    Route::get('teacher_offday/{teacher_id}','UserController@teacher_offday')->name('teacher_offday');
    Route::post('assign_teacher_offday','UserController@assign_teacher_offday')->name('assign_teacher_offday');

    Route::get('profile_edit/{id}', 'UserController@profile_edit')->name('profile_edit');
    Route::get('password_edit', 'UserController@password_edit')->name('password_edit');
    Route::post('password_update', 'UserController@password_update')->name('password_update');

    Route::resource('ranks', 'TeacherRankController')->middleware('auth_admin');
    Route::resource('students', 'StudentController')->middleware('auth_admin');

    Route::get('students_create/{id}', 'StudentController@create')->name('students_create')->middleware('auth_admin');

    Route::get('teachers_offday/{id}', 'TeachersOffdayController@create')->name('teachers_offday')->middleware('auth_admin');
    Route::post('teachers_offday_store', 'TeachersOffdayController@store')->name('teachers_offday_store')->middleware('auth_admin');

    Route::get('theory_section/{id}', 'StudentController@theory_section')->name('theory_section')->middleware('auth_admin');
    Route::post('theory_section_store', 'StudentController@theory_section_store')->name('theory_section_store')->middleware('auth_admin');

    Route::post('lab_section_store', 'StudentController@lab_section_store')->name('lab_section_store')->middleware('auth_admin');
    Route::get('lab_section/{id}', 'StudentController@lab_section')->name('lab_section')->middleware('auth_admin');

    Route::resource('section_students', 'SectionStudentController')->middleware('auth_admin');
    Route::resource('courses', 'CourseController')->middleware('auth_admin');
    Route::resource('assign_courses', 'AssignCourseController')->middleware('auth_admin');

    Route::resource('time_slots', 'TimeSlotController')->middleware('auth_admin');

    //Day wise time slot & class slot
    Route::get('day_wise_slots', 'DayWiseSlotController@index')->name('day_wise_slots')->middleware('auth_admin');
    Route::get('day_wise_slot_create/{id}', 'DayWiseSlotController@create')->name('day_wise_slot_create')->middleware('auth_admin');
    Route::post('day_wise_slot_store', 'DayWiseSlotController@store')->name('day_wise_slot_store')->middleware('auth_admin');
    Route::post('day_wise_slot_destroy/{id}', 'DayWiseSlotController@destroy')->name('day_wise_slot_destroy')->middleware('auth_admin');

    Route::get('full_routine/{yearly_session}', 'FullRoutineController@index')->name('full_routine');
    Route::post('routine_create', 'FullRoutineController@create')->name('routine_create');
    Route::post('course_check', 'FullRoutineController@course_check')->name('course_check');
    Route::post('routine_reset', 'FullRoutineController@reset')->name('routine_reset')->middleware('auth_admin');
    Route::post('routine_cell_delete', 'FullRoutineController@routine_cell_delete')->name('routine_cell_delete')->middleware('auth_admin');

    Route::post('class_slot_update', 'FullRoutineController@class_slot_update')->name('class_slot_update');

    Route::post('teacher_wise_view', 'FullRoutineController@teacher_wise_view')->name('teacher_wise_view');

    Route::get('routine_list/{session}', 'FullRoutineController@routine_list')->name('routine_list');


    Route::get('teacher_search', 'FullRoutineController@teacher_search')->name('teacher_search');
    Route::get('batch_search', 'FullRoutineController@batch_search')->name('batch_search');
    Route::post('batch_wise_view', 'FullRoutineController@batch_wise_view')->name('batch_wise_view');
    Route::post('teacher_wise_print', 'FullRoutineController@teacher_wise_print')->name('teacher_wise_print');

    Route::post('routine_committee_invite', 'RoutineCommitteeController@store')->name('routine_committee_invite');

    Route::post('temp_routine_access', 'RoutineCommitteeController@temp_routine_access')->name('temp_routine_access');

    Route::post('routine_committee_status', 'RoutineCommitteeController@routine_committee_status')->name('routine_committee_status');

    Route::get('roles', 'AdminController@roles')->name('roles');

    Route::resource('course_offers', 'CourseOfferController');
});

#============================ *Logout Route* ============================#

Route::get('/logout', function(){
    Auth::logout();
    Session::flush();
    return Redirect::to('login');
});
