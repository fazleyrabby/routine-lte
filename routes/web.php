<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ShiftSessionController;
use App\Http\Controllers\YearlySessionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherRankController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeachersOffdayController;
use App\Http\Controllers\SectionStudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssignCourseController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\DayWiseSlotController;
use App\Http\Controllers\FullRoutineController;
use App\Http\Controllers\RoutineCommitteeController;
use App\Http\Controllers\CourseOfferController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/routine', [HomeController::class, 'routine'])->name('routine');
Route::post('/routine_view', [HomeController::class, 'routine_view'])->name('routine_view');
Route::post('/routine_print', [HomeController::class, 'routine_print'])->name('routine_print');
Route::post('reset_password_with_token', [UserController::class, 'resetPassword'])->name('reset_password_with_token');

Route::group(['prefix' => 'admin','middleware' => 'auth'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('teachers/requests', [TeacherController::class, 'requests'])->name('teachers.requests');
    Route::resource('sessions', SessionController::class);
    Route::resource('shift_sessions', ShiftSessionController::class);
    Route::resource('yearly_sessions', YearlySessionController::class);
    Route::resource('shifts', ShiftController::class)->middleware('auth_admin');
    Route::resource('rooms', RoomController::class)->middleware('auth_admin');
    Route::resource('departments', DepartmentController::class)->middleware('auth_admin');
    Route::resource('teachers', TeacherController::class)->middleware('auth_admin');
    Route::resource('batches', BatchController::class)->middleware('auth_admin');
    Route::resource('sections', SectionController::class)->middleware('auth_admin');

    Route::resource('users', UserController::class);

    Route::get('teacher_offday/{teacher_id}', [UserController::class, 'teacher_offday'])->name('teacher_offday');
    Route::post('assign_teacher_offday', [UserController::class, 'assign_teacher_offday'])->name('assign_teacher_offday');

    Route::get('profile_edit/{id}', [UserController::class, 'profile_edit'])->name('profile_edit');
    Route::get('password_edit', [UserController::class, 'password_edit'])->name('password_edit');
    Route::post('password_update', [UserController::class, 'password_update'])->name('password_update');

    Route::resource('ranks', TeacherRankController::class)->middleware('auth_admin');
    Route::resource('students', StudentController::class)->middleware('auth_admin');

    Route::get('students_create/{id}', [StudentController::class, 'create'])->name('students_create')->middleware('auth_admin');

    Route::get('teachers_offday/{id}', [TeachersOffdayController::class, 'create'])->name('teachers_offday')->middleware('auth_admin');
    Route::post('teachers_offday_store', [TeachersOffdayController::class, 'store'])->name('teachers_offday_store')->middleware('auth_admin');

    Route::get('theory_section/{id}', [StudentController::class, 'theory_section'])->name('theory_section')->middleware('auth_admin');
    Route::post('theory_section_store', [StudentController::class, 'theory_section_store'])->name('theory_section_store')->middleware('auth_admin');

    Route::post('lab_section_store', [StudentController::class, 'lab_section_store'])->name('lab_section_store')->middleware('auth_admin');
    Route::get('lab_section/{id}', [StudentController::class, 'lab_section'])->name('lab_section')->middleware('auth_admin');

    Route::resource('section_students', SectionStudentController::class)->middleware('auth_admin');
    Route::resource('courses', CourseController::class)->middleware('auth_admin');
    Route::resource('assign_courses', AssignCourseController::class)->middleware('auth_admin');

    Route::resource('time_slots', TimeSlotController::class)->middleware('auth_admin');

    Route::get('day_wise_slots', [DayWiseSlotController::class, 'index'])->name('day_wise_slots')->middleware('auth_admin');
    Route::get('day_wise_slot_create/{id}', [DayWiseSlotController::class, 'create'])->name('day_wise_slot_create')->middleware('auth_admin');
    Route::post('day_wise_slot_store', [DayWiseSlotController::class, 'store'])->name('day_wise_slot_store')->middleware('auth_admin');
    Route::post('day_wise_slot_destroy/{id}', [DayWiseSlotController::class, 'destroy'])->name('day_wise_slot_destroy')->middleware('auth_admin');

    Route::get('full_routine/{yearly_session}', [FullRoutineController::class, 'index'])->name('full_routine');
    Route::get('full_routine/{yearly_session}/edit/{batch_id}/{section_id}', [FullRoutineController::class, 'batchEditor'])->name('routine_batch_editor');
    Route::post('routine_create', [FullRoutineController::class, 'create'])->name('routine_create');
    Route::post('course_check', [FullRoutineController::class, 'course_check'])->name('course_check');
    Route::post('routine_reset', [FullRoutineController::class, 'reset'])->name('routine_reset')->middleware('auth_admin');
    Route::post('routine_cell_delete', [FullRoutineController::class, 'routine_cell_delete'])->name('routine_cell_delete')->middleware('auth_admin');
    Route::post('full_routine_print', [FullRoutineController::class, 'full_routine_print'])->name('full_routine_print');
    Route::post('class_slot_update', [FullRoutineController::class, 'class_slot_update'])->name('class_slot_update');
    Route::post('teacher_wise_view', [FullRoutineController::class, 'teacher_wise_view'])->name('teacher_wise_view');
    Route::get('routine_list/{session}', [FullRoutineController::class, 'routine_list'])->name('routine_list');
    Route::get('teacher_search', [FullRoutineController::class, 'teacher_search'])->name('teacher_search');
    Route::get('batch_search', [FullRoutineController::class, 'batch_search'])->name('batch_search');
    Route::post('batch_wise_view', [FullRoutineController::class, 'batch_wise_view'])->name('batch_wise_view');
    Route::post('teacher_wise_print', [FullRoutineController::class, 'teacher_wise_print'])->name('teacher_wise_print');

    Route::post('routine_committee_invite', [RoutineCommitteeController::class, 'store'])->name('routine_committee_invite');
    Route::post('temp_routine_access', [RoutineCommitteeController::class, 'temp_routine_access'])->name('temp_routine_access');
    Route::post('routine_committee_status', [RoutineCommitteeController::class, 'routine_committee_status'])->name('routine_committee_status');

    Route::get('roles', [AdminController::class, 'roles'])->name('roles');

    Route::resource('course_offers', CourseOfferController::class);
});

Route::get('/logout', function(){
    Auth::logout();
    Session::flush();
    return Redirect::to('login');
});
