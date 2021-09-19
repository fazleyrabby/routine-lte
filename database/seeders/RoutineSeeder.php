<?php

namespace Database\Seeders;

use App\Models\Day;
use App\Models\Room;
use App\Models\User;
use App\Models\Batch;
use App\Models\Shift;
use App\Models\Course;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TimeSlot;
use App\Models\Department;
use App\Models\CourseOffer;
use App\Models\DayWiseSlot;
use App\Models\FullRoutine;
use App\Models\TeacherRank;
use App\Models\ShiftSession;
use App\Models\YearlySession;
use App\Models\SectionStudent;
use App\Models\TeachersOffday;
use Illuminate\Database\Seeder;
use App\Models\Session;

class RoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $users = array(
                array(
                    "id" => 1,
                    "key" => null,
                    "firstname" => "Mr.Showmitra",
                    "lastname" => "Das",
                    "date_of_birth" => "1985-07-26",
                    "username" => "superadmin",
                    "gender" => 1,
                    "email" => "superadmin@gmail.com",
                    "email_verified_at" => null,
                    "password" => '$2y$10$bq8oxoS9UJLhh7t2RCbNAui3buLlKHLgL20BOEuiMTIQHBwRUWjAW',
                    "role" => "admin",
                    "is_active" => "yes",
                    "is_teacher" => "yes",
                    "in_committee" => "yes",
                    "remember_token" => "tiLj8B1unSUea8xYAbGEOMoPoRUnqrfadOi7wd5dSICbfsfBPlUiI0UhjW8P",
                    "photo" => null,
                    "contact" => "01881075015",
                    "created_at" => "2020-07-21 00:41:06",
                    "updated_at" => "2020-11-23 22:42:14"
                ),
                array(
                    "id" => 8,
                    "key" => null,
                    "firstname" => "Mr. Md. Maqsudur",
                    "lastname" => "Rahman",
                    "date_of_birth" => "1970-01-01",
                    "username" => "maqsudur_rahman",
                    "gender" => 1,
                    "email" => "mr@gmail.com",
                    "email_verified_at" => null,
                    "password" => '$2y$10$bq8oxoS9UJLhh7t2RCbNAui3buLlKHLgL20BOEuiMTIQHBwRUWjAW',
                    "role" => "user",
                    "is_active" => "yes",
                    "is_teacher" => "yes",
                    "in_committee" => "no",
                    "remember_token" => null,
                    "photo" => null,
                    "contact" => "01833788270",
                    "created_at" => "2020-11-23 22:43:36",
                    "updated_at" => "2020-11-23 22:43:36"
                ),
                array(
                    "id" => 9,
                    "key" => null,
                    "firstname" => "Mr. Abdur",
                    "lastname" => "Rahman",
                    "date_of_birth" => "1970-01-01",
                    "username" => "abdur_rahman",
                    "gender" => 1,
                    "email" => "csetanim11@gmail.com",
                    "email_verified_at" => null,
                    "password" => '$2y$10$JqOPW.wGmANko1TtZTQDAOpBi2GnMru2VUoWHyNdpqpAhDl2x35Vm',
                    "role" => "user",
                    "is_active" => "yes",
                    "is_teacher" => "yes",
                    "in_committee" => "yes",
                    "remember_token" => null,
                    "photo" => null,
                    "contact" => "01733839289",
                    "created_at" => "2020-11-23 22:45:33",
                    "updated_at" => "2020-12-01 13:41:43"
                ),
                array(
                    "id" => 10,
                    "key" => null,
                    "firstname" => "Mr. Emam",
                    "lastname" => "Hossain",
                    "date_of_birth" => "1970-01-01",
                    "username" => "emam_hossain",
                    "gender" => 1,
                    "email" => "ehfahad01@gmail.com",
                    "email_verified_at" => null,
                    "password" => '$2y$10$sYLKMsglNqqAuZ5spBMJSeXm71ttUReTm5L2QetzCL6PLVcAI1wYi',
                    "role" => "user",
                    "is_active" => "yes",
                    "is_teacher" => "yes",
                    "in_committee" => "yes",
                    "remember_token" => null,
                    "photo" => null,
                    "contact" => "01675234510",
                    "created_at" => "2020-11-23 22:46:39",
                    "updated_at" => "2020-12-01 13:41:51"
                ),
                array(
                    "id" => 11,
                    "key" => null,
                    "firstname" => "Mrs. Manoara",
                    "lastname" => "Begum",
                    "date_of_birth" => "1970-01-01",
                    "username" => "manoara_begum",
                    "gender" => 2,
                    "email" => "mb@gmail.com",
                    "email_verified_at" => null,
                    "password" => '$2y$10$fr48BlNFS5xiJyhUK.q9CePO7j7\/aQdH3MgBcViuhdUJu8PCkexve',
                    "role" => "user",
                    "is_active" => "yes",
                    "is_teacher" => "yes",
                    "in_committee" => "no",
                    "remember_token" => null,
                    "photo" => null,
                    "contact" => "01845110925",
                    "created_at" => "2020-11-23 22:47:46",
                    "updated_at" => "2020-11-23 22:50:23"
                ),
                array(
                    "id" => 12,
                    "key" => null,
                    "firstname" => "Mr. Armanuzzaman",
                    "lastname" => "Chowdhury",
                    "date_of_birth" => "1970-01-01",
                    "username" => "armanuzzaman_chy",
                    "gender" => 1,
                    "email" => "az@gmail.com",
                    "email_verified_at" => null,
                    "password" => '$2y$10$fr48BlNFS5xiJyhUK.q9CePO7j7\/aQdH3MgBcViuhdUJu8PCkexve',
                    "role" => "user",
                    "is_active" => "yes",
                    "is_teacher" => "yes",
                    "in_committee" => "no",
                    "remember_token" => null,
                    "photo" => null,
                    "contact" => "01925568358",
                    "created_at" => "2020-11-23 22:49:07",
                    "updated_at" => "2020-11-23 22:49:07"
                )
            );
    
            User::insert($users);
    
    
    
    
            $batch = array(
                array(
                    "id" => 1,
                    "batch_no" => 1,
                    "department_id" => 1,
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "created_at" => "2020-08-10 00:42:07",
                    "updated_at" => "2020-08-10 00:42:07"
                ),
                array(
                    "id" => 2,
                    "batch_no" => 2,
                    "department_id" => 1,
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "created_at" => "2020-08-10 00:42:48",
                    "updated_at" => "2020-08-10 00:42:48"
                ),
                array(
                    "id" => 3,
                    "batch_no" => 1,
                    "department_id" => 1,
                    "shift_id" => 2,
                    "is_active" => "yes",
                    "created_at" => "2020-08-10 00:50:18",
                    "updated_at" => "2020-08-10 00:50:18"
                ),
                array(
                    "id" => 4,
                    "batch_no" => 13,
                    "department_id" => 1,
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 12:44:33",
                    "updated_at" => "2020-09-21 12:44:33"
                ),
                array(
                    "id" => 5,
                    "batch_no" => 10,
                    "department_id" => 1,
                    "shift_id" => 2,
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 12:44:39",
                    "updated_at" => "2020-09-21 12:44:39"
                ),
                array(
                    "id" => 6,
                    "batch_no" => 13,
                    "department_id" => 1,
                    "shift_id" => 2,
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 12:44:47",
                    "updated_at" => "2020-09-21 12:44:47"
                )
            );
    
    
            Batch::insert($batch);
    
    
            $course_offers = array(
                array(
                    "id" => 4,
                    "batch_id" => 1,
                    "courses" => "1,2",
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-20 07:34:15",
                    "updated_at" => "2020-11-20 07:34:15"
                ),
                array(
                    "id" => 5,
                    "batch_id" => 4,
                    "courses" => "3,4,5",
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-20 07:34:25",
                    "updated_at" => "2020-11-20 07:34:25"
                ),
                array(
                    "id" => 6,
                    "batch_id" => 5,
                    "courses" => "1,3,4",
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-20 07:34:34",
                    "updated_at" => "2020-11-20 07:34:34"
                )
            );
    
            CourseOffer::insert($course_offers);
    
            $courses = array(
                array(
                    "id" => 1,
                    "course_name" => "Data Communication",
                    "credit" => "3",
                    "course_code" => "CSE435",
                    "created_at" => "2020-07-19 01:04:30",
                    "updated_at" => "2020-11-30 12:11:31",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 2,
                    "course_name" => "Theory of Computing",
                    "credit" => "3",
                    "course_code" => "CSE317",
                    "created_at" => "2020-07-19 01:05:11",
                    "updated_at" => "2020-07-19 01:05:11",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 3,
                    "course_name" => "Operating System Concepts",
                    "credit" => "3",
                    "course_code" => "CSE231",
                    "created_at" => "2020-07-19 01:05:48",
                    "updated_at" => "2020-07-19 01:05:48",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 4,
                    "course_name" => "Operating System Concepts Sessional",
                    "credit" => "1.5",
                    "course_code" => "CSE232",
                    "created_at" => "2020-07-19 01:06:04",
                    "updated_at" => "2020-07-19 01:06:04",
                    "is_active" => "yes",
                    "course_type" => "1"
                ),
                array(
                    "id" => 6,
                    "course_name" => "Diff. Equations and F.A",
                    "credit" => "3",
                    "course_code" => "MATH325",
                    "created_at" => "2020-11-23 22:31:54",
                    "updated_at" => "2020-11-23 22:31:54",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 7,
                    "course_name" => "Computer Peripherals & Interfacing",
                    "credit" => "3",
                    "course_code" => "CSE333",
                    "created_at" => "2020-11-23 22:32:48",
                    "updated_at" => "2020-11-23 22:32:48",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 8,
                    "course_name" => "Introduction to Computer & Programming Techniques",
                    "credit" => "3",
                    "course_code" => "CSE212",
                    "created_at" => "2020-11-23 22:33:07",
                    "updated_at" => "2020-11-23 22:33:07",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 9,
                    "course_name" => "Mobile and Telecommunication",
                    "credit" => "3",
                    "course_code" => "CSE443",
                    "created_at" => "2020-11-23 22:33:57",
                    "updated_at" => "2020-11-23 22:33:57",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 10,
                    "course_name" => "Software Engineering",
                    "credit" => "3",
                    "course_code" => "CSE321",
                    "created_at" => "2020-11-23 22:34:17",
                    "updated_at" => "2020-11-23 22:34:17",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 11,
                    "course_name" => "Artificial Intelligence Sessional",
                    "credit" => "1.5",
                    "course_code" => "CSE342",
                    "created_at" => "2020-11-23 22:34:45",
                    "updated_at" => "2020-11-23 22:34:45",
                    "is_active" => "yes",
                    "course_type" => "1"
                ),
                array(
                    "id" => 12,
                    "course_name" => "Simulation & Modeling Sessional",
                    "credit" => "1.5",
                    "course_code" => "CSE424",
                    "created_at" => "2020-11-23 22:35:07",
                    "updated_at" => "2020-11-23 22:35:07",
                    "is_active" => "yes",
                    "course_type" => "0"
                ),
                array(
                    "id" => 13,
                    "course_name" => "Multimedia Systems Design Sessional",
                    "credit" => "1.5",
                    "course_code" => "CSE448",
                    "created_at" => "2020-11-23 22:36:09",
                    "updated_at" => "2020-11-23 22:36:09",
                    "is_active" => "yes",
                    "course_type" => "1"
                )
            );
    
            Course::insert($courses);
    
            $day_wise_slots = array(
                array(
                    "id" => 118,
                    "day_id" => 6,
                    "time_slot_id" => 1,
                    "class_slot" => 1,
                    "created_at" => "2020-10-04 05:10:13",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 119,
                    "day_id" => 6,
                    "time_slot_id" => 2,
                    "class_slot" => 9,
                    "created_at" => "2020-10-04 05:10:13",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 120,
                    "day_id" => 6,
                    "time_slot_id" => 3,
                    "class_slot" => 8,
                    "created_at" => "2020-10-04 05:10:13",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 121,
                    "day_id" => 6,
                    "time_slot_id" => 4,
                    "class_slot" => 4,
                    "created_at" => "2020-10-04 05:10:13",
                    "updated_at" => "2020-11-19 01:34:29"
                ),
                array(
                    "id" => 122,
                    "day_id" => 6,
                    "time_slot_id" => 5,
                    "class_slot" => 5,
                    "created_at" => "2020-10-04 05:10:13",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 123,
                    "day_id" => 6,
                    "time_slot_id" => 6,
                    "class_slot" => 9,
                    "created_at" => "2020-10-04 05:10:13",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 124,
                    "day_id" => 7,
                    "time_slot_id" => 7,
                    "class_slot" => 3,
                    "created_at" => "2020-10-04 05:10:29",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 125,
                    "day_id" => 7,
                    "time_slot_id" => 8,
                    "class_slot" => 1,
                    "created_at" => "2020-10-04 05:10:29",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 126,
                    "day_id" => 7,
                    "time_slot_id" => 6,
                    "class_slot" => 4,
                    "created_at" => "2020-10-04 05:10:29",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 127,
                    "day_id" => 2,
                    "time_slot_id" => 1,
                    "class_slot" => 1,
                    "created_at" => "2020-10-07 16:24:49",
                    "updated_at" => "2020-11-19 01:35:04"
                ),
                array(
                    "id" => 128,
                    "day_id" => 2,
                    "time_slot_id" => 2,
                    "class_slot" => 4,
                    "created_at" => "2020-10-07 16:24:49",
                    "updated_at" => "2020-11-19 01:35:04"
                ),
                array(
                    "id" => 129,
                    "day_id" => 2,
                    "time_slot_id" => 3,
                    "class_slot" => 7,
                    "created_at" => "2020-10-07 16:24:49",
                    "updated_at" => "2020-11-19 01:35:04"
                ),
                array(
                    "id" => 130,
                    "day_id" => 2,
                    "time_slot_id" => 4,
                    "class_slot" => 2,
                    "created_at" => "2020-10-07 16:24:49",
                    "updated_at" => "2020-11-19 01:35:04"
                ),
                array(
                    "id" => 131,
                    "day_id" => 2,
                    "time_slot_id" => 5,
                    "class_slot" => 1,
                    "created_at" => "2020-10-07 16:24:49",
                    "updated_at" => "2020-11-19 01:35:04"
                ),
                array(
                    "id" => 132,
                    "day_id" => 2,
                    "time_slot_id" => 6,
                    "class_slot" => 8,
                    "created_at" => "2020-10-07 16:24:49",
                    "updated_at" => "2020-11-19 01:35:04"
                ),
                array(
                    "id" => 133,
                    "day_id" => 3,
                    "time_slot_id" => 1,
                    "class_slot" => 2,
                    "created_at" => "2020-10-07 16:25:00",
                    "updated_at" => "2020-11-19 01:35:04"
                ),
                array(
                    "id" => 134,
                    "day_id" => 3,
                    "time_slot_id" => 2,
                    "class_slot" => 5,
                    "created_at" => "2020-10-07 16:25:00",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 135,
                    "day_id" => 3,
                    "time_slot_id" => 3,
                    "class_slot" => 4,
                    "created_at" => "2020-10-07 16:25:00",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 136,
                    "day_id" => 3,
                    "time_slot_id" => 4,
                    "class_slot" => 7,
                    "created_at" => "2020-10-07 16:25:00",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 137,
                    "day_id" => 3,
                    "time_slot_id" => 5,
                    "class_slot" => 3,
                    "created_at" => "2020-10-07 16:25:00",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 138,
                    "day_id" => 3,
                    "time_slot_id" => 6,
                    "class_slot" => 4,
                    "created_at" => "2020-10-07 16:25:00",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 139,
                    "day_id" => 4,
                    "time_slot_id" => 1,
                    "class_slot" => 8,
                    "created_at" => "2020-10-07 16:25:09",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 140,
                    "day_id" => 4,
                    "time_slot_id" => 2,
                    "class_slot" => 8,
                    "created_at" => "2020-10-07 16:25:09",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 141,
                    "day_id" => 4,
                    "time_slot_id" => 3,
                    "class_slot" => 6,
                    "created_at" => "2020-10-07 16:25:09",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 142,
                    "day_id" => 4,
                    "time_slot_id" => 4,
                    "class_slot" => 4,
                    "created_at" => "2020-10-07 16:25:09",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 143,
                    "day_id" => 4,
                    "time_slot_id" => 5,
                    "class_slot" => 7,
                    "created_at" => "2020-10-07 16:25:09",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 144,
                    "day_id" => 4,
                    "time_slot_id" => 6,
                    "class_slot" => 3,
                    "created_at" => "2020-10-07 16:25:09",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 145,
                    "day_id" => 5,
                    "time_slot_id" => 1,
                    "class_slot" => 5,
                    "created_at" => "2020-10-07 16:25:21",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 146,
                    "day_id" => 5,
                    "time_slot_id" => 2,
                    "class_slot" => 5,
                    "created_at" => "2020-10-07 16:25:21",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 147,
                    "day_id" => 5,
                    "time_slot_id" => 3,
                    "class_slot" => 4,
                    "created_at" => "2020-10-07 16:25:21",
                    "updated_at" => "2020-11-19 01:35:05"
                ),
                array(
                    "id" => 148,
                    "day_id" => 5,
                    "time_slot_id" => 4,
                    "class_slot" => 3,
                    "created_at" => "2020-10-07 16:25:21",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 149,
                    "day_id" => 5,
                    "time_slot_id" => 5,
                    "class_slot" => 2,
                    "created_at" => "2020-10-07 16:25:21",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 150,
                    "day_id" => 5,
                    "time_slot_id" => 6,
                    "class_slot" => 1,
                    "created_at" => "2020-10-07 16:25:21",
                    "updated_at" => "2020-11-19 01:35:06"
                ),
                array(
                    "id" => 151,
                    "day_id" => 1,
                    "time_slot_id" => 1,
                    "class_slot" => 3,
                    "created_at" => "2020-11-26 16:20:24",
                    "updated_at" => "2021-05-18 22:10:48"
                ),
                array(
                    "id" => 152,
                    "day_id" => 1,
                    "time_slot_id" => 2,
                    "class_slot" => 1,
                    "created_at" => "2020-11-26 16:20:24",
                    "updated_at" => "2020-11-28 06:20:14"
                ),
                array(
                    "id" => 153,
                    "day_id" => 1,
                    "time_slot_id" => 3,
                    "class_slot" => 2,
                    "created_at" => "2020-11-26 16:20:24",
                    "updated_at" => "2020-11-26 16:20:24"
                ),
                array(
                    "id" => 154,
                    "day_id" => 1,
                    "time_slot_id" => 4,
                    "class_slot" => 6,
                    "created_at" => "2020-11-26 16:20:24",
                    "updated_at" => "2020-11-26 16:20:24"
                ),
                array(
                    "id" => 155,
                    "day_id" => 1,
                    "time_slot_id" => 5,
                    "class_slot" => 7,
                    "created_at" => "2020-11-26 16:20:24",
                    "updated_at" => "2020-11-26 16:20:24"
                ),
                array(
                    "id" => 156,
                    "day_id" => 1,
                    "time_slot_id" => 6,
                    "class_slot" => 6,
                    "created_at" => "2020-11-26 16:20:24",
                    "updated_at" => "2020-11-26 16:20:24"
                )
            );
    
            DayWiseSlot::insert($day_wise_slots);
    
    
            $days = array(
                array(
                    "id" => 1,
                    "day_title" => "Saturday",
                    "slug" => "SAT",
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 00:00:00",
                    "updated_at" => "2020-09-21 00:00:00"
                ),
                array(
                    "id" => 2,
                    "day_title" => "Sunday",
                    "slug" => "SUN",
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 00:00:00",
                    "updated_at" => "2020-09-21 00:00:00"
                ),
                array(
                    "id" => 3,
                    "day_title" => "Monday",
                    "slug" => "MON",
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 00:00:00",
                    "updated_at" => "2020-09-21 00:00:00"
                ),
                array(
                    "id" => 4,
                    "day_title" => "Tuesday",
                    "slug" => "TUE",
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 00:00:00",
                    "updated_at" => "2020-09-21 00:00:00"
                ),
                array(
                    "id" => 5,
                    "day_title" => "Wednesday",
                    "slug" => "WED",
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 00:00:00",
                    "updated_at" => "2020-09-21 00:00:00"
                ),
                array(
                    "id" => 6,
                    "day_title" => "Thursday",
                    "slug" => "THU",
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 00:00:00",
                    "updated_at" => "2020-09-21 00:00:00"
                ),
                array(
                    "id" => 7,
                    "day_title" => "Friday",
                    "slug" => "FRI",
                    "is_active" => "yes",
                    "created_at" => "2020-09-21 00:00:00",
                    "updated_at" => "2020-09-21 00:00:00"
                )
            );
    
            Day::insert($days);
    
            $departments = array(
                array(
                    "id" => 1,
                    "department_name" => "CSE",
                    "is_active" => "yes",
                    "created_at" => "2021-05-18 22:06:41",
                    "updated_at" => "2021-05-18 22:06:41"
                ),
                array(
                    "id" => 2,
                    "department_name" => "EEE",
                    "is_active" => "yes",
                    "created_at" => "2021-05-18 22:06:45",
                    "updated_at" => "2021-05-18 22:06:45"
                ),
                array(
                    "id" => 3,
                    "department_name" => "BBA",
                    "is_active" => "no",
                    "created_at" => "2020-07-22 13:28:26",
                    "updated_at" => "2020-07-22 13:28:26"
                ),
                array(
                    "id" => 4,
                    "department_name" => "MBA",
                    "is_active" => "yes",
                    "created_at" => "2020-07-22 13:28:30",
                    "updated_at" => "2020-07-22 13:28:30"
                ),
                array(
                    "id" => 5,
                    "department_name" => "CEN",
                    "is_active" => "yes",
                    "created_at" => "2020-07-22 13:28:51",
                    "updated_at" => "2020-07-22 13:43:20"
                )
            );
    
            Department::insert($departments);
    
    
            $rooms = array(
                array(
                    "id" => 1,
                    "building" => "A",
                    "room_no" => "101",
                    "capacity" => 60,
                    "room_type" => "0",
                    "created_at" => "2020-07-21 06:50:22",
                    "updated_at" => "2020-09-21 12:26:55",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 2,
                    "building" => "A",
                    "room_no" => "102",
                    "capacity" => 70,
                    "room_type" => "0",
                    "created_at" => "2020-07-21 06:54:18",
                    "updated_at" => "2020-09-21 12:27:02",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 4,
                    "building" => "B",
                    "room_no" => "203",
                    "capacity" => 100,
                    "room_type" => "1",
                    "created_at" => "2020-07-21 06:54:55",
                    "updated_at" => "2020-09-21 12:27:06",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 5,
                    "building" => "C",
                    "room_no" => "333",
                    "capacity" => 100,
                    "room_type" => "1",
                    "created_at" => "2020-07-21 07:06:27",
                    "updated_at" => "2020-09-21 12:27:10",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 6,
                    "building" => "A",
                    "room_no" => "601",
                    "capacity" => 65,
                    "room_type" => "1",
                    "created_at" => "2020-09-21 12:27:30",
                    "updated_at" => "2020-09-21 12:27:30",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 7,
                    "building" => "A",
                    "room_no" => "301",
                    "capacity" => 50,
                    "room_type" => "0",
                    "created_at" => "2020-11-19 01:28:08",
                    "updated_at" => "2020-11-19 01:28:08",
                    "is_active" => "yes"
                )
            );
    
            Room::insert($rooms);
    
    
            $routine = array(
                array(
                    "id" => 1,
                    "teacher_id" => 8,
                    "batch_id" => 5,
                    "section_id" => 1,
                    "day_id" => 1,
                    "time_slot_id" => 1,
                    "course_id" => 1,
                    "room_id" => 2,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-05 13:00:56",
                    "updated_at" => "2020-12-05 13:00:56"
                ),
                array(
                    "id" => 2,
                    "teacher_id" => 9,
                    "batch_id" => 6,
                    "section_id" => null,
                    "day_id" => 1,
                    "time_slot_id" => 2,
                    "course_id" => 3,
                    "room_id" => 2,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-05 13:01:17",
                    "updated_at" => "2020-12-05 13:01:17"
                ),
                array(
                    "id" => 3,
                    "teacher_id" => 10,
                    "batch_id" => 4,
                    "section_id" => 2,
                    "day_id" => 2,
                    "time_slot_id" => 3,
                    "course_id" => 1,
                    "room_id" => 2,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-05 13:01:31",
                    "updated_at" => "2020-12-05 13:01:31"
                ),
                array(
                    "id" => 4,
                    "teacher_id" => 11,
                    "batch_id" => 6,
                    "section_id" => null,
                    "day_id" => 2,
                    "time_slot_id" => 1,
                    "course_id" => 4,
                    "room_id" => 4,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-05 13:09:09",
                    "updated_at" => "2020-12-05 13:09:09"
                ),
                array(
                    "id" => 5,
                    "teacher_id" => 11,
                    "batch_id" => 6,
                    "section_id" => null,
                    "day_id" => 2,
                    "time_slot_id" => 2,
                    "course_id" => 4,
                    "room_id" => 4,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-05 13:09:09",
                    "updated_at" => "2020-12-05 13:09:09"
                ),
                array(
                    "id" => 6,
                    "teacher_id" => 11,
                    "batch_id" => 6,
                    "section_id" => null,
                    "day_id" => 3,
                    "time_slot_id" => 6,
                    "course_id" => 13,
                    "room_id" => 6,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-05 13:09:41",
                    "updated_at" => "2020-12-05 13:09:41"
                ),
                array(
                    "id" => 7,
                    "teacher_id" => 9,
                    "batch_id" => 4,
                    "section_id" => 1,
                    "day_id" => 3,
                    "time_slot_id" => 1,
                    "course_id" => 4,
                    "room_id" => 6,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-05 13:13:47",
                    "updated_at" => "2020-12-05 13:13:47"
                ),
                array(
                    "id" => 8,
                    "teacher_id" => 9,
                    "batch_id" => 4,
                    "section_id" => 1,
                    "day_id" => 3,
                    "time_slot_id" => 2,
                    "course_id" => 4,
                    "room_id" => 6,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-05 13:13:47",
                    "updated_at" => "2020-12-05 13:13:47"
                ),
                array(
                    "id" => 9,
                    "teacher_id" => 1,
                    "batch_id" => 5,
                    "section_id" => 1,
                    "day_id" => 7,
                    "time_slot_id" => 7,
                    "course_id" => 4,
                    "room_id" => 4,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-12-09 18:53:09",
                    "updated_at" => "2020-12-09 18:53:09"
                ),
                array(
                    "id" => 10,
                    "teacher_id" => 9,
                    "batch_id" => 2,
                    "section_id" => 2,
                    "day_id" => 1,
                    "time_slot_id" => 4,
                    "course_id" => 6,
                    "room_id" => 1,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2021-05-18 22:44:28",
                    "updated_at" => "2021-05-18 22:44:28"
                ),
                array(
                    "id" => 11,
                    "teacher_id" => 12,
                    "batch_id" => 5,
                    "section_id" => 2,
                    "day_id" => 1,
                    "time_slot_id" => 6,
                    "course_id" => 13,
                    "room_id" => 4,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2021-05-18 22:44:39",
                    "updated_at" => "2021-05-18 22:44:39"
                ),
                array(
                    "id" => 12,
                    "teacher_id" => 11,
                    "batch_id" => 6,
                    "section_id" => null,
                    "day_id" => 1,
                    "time_slot_id" => 4,
                    "course_id" => 11,
                    "room_id" => 6,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2021-05-18 22:45:09",
                    "updated_at" => "2021-05-18 22:45:09"
                ),
                array(
                    "id" => 13,
                    "teacher_id" => 10,
                    "batch_id" => 5,
                    "section_id" => 2,
                    "day_id" => 1,
                    "time_slot_id" => 3,
                    "course_id" => 2,
                    "room_id" => 2,
                    "created_by" => 1,
                    "edited_by" => null,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2021-05-18 22:46:15",
                    "updated_at" => "2021-05-18 22:46:15"
                )
            );
    
            FullRoutine::insert($routine);
    
    
            $section_students = array(
                array(
                    "id" => 33,
                    "student_id" => 18,
                    "section_id" => 1,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 50,
                    "created_at" => "2020-10-06 23:55:23",
                    "updated_at" => "2020-10-06 23:55:23"
                ),
                array(
                    "id" => 34,
                    "student_id" => 18,
                    "section_id" => 2,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 50,
                    "created_at" => "2020-10-06 23:55:23",
                    "updated_at" => "2020-10-06 23:55:23"
                ),
                array(
                    "id" => 35,
                    "student_id" => 18,
                    "section_id" => 3,
                    "section_type" => "lab",
                    "is_active" => "yes",
                    "students" => 25,
                    "created_at" => "2020-11-18 17:08:50",
                    "updated_at" => "2020-11-18 17:08:50"
                ),
                array(
                    "id" => 36,
                    "student_id" => 18,
                    "section_id" => 4,
                    "section_type" => "lab",
                    "is_active" => "yes",
                    "students" => 25,
                    "created_at" => "2020-11-18 17:08:50",
                    "updated_at" => "2020-11-18 17:08:50"
                ),
                array(
                    "id" => 37,
                    "student_id" => 18,
                    "section_id" => 5,
                    "section_type" => "lab",
                    "is_active" => "yes",
                    "students" => 25,
                    "created_at" => "2020-11-18 17:08:50",
                    "updated_at" => "2020-11-18 17:08:50"
                ),
                array(
                    "id" => 38,
                    "student_id" => 18,
                    "section_id" => 6,
                    "section_type" => "lab",
                    "is_active" => "yes",
                    "students" => 25,
                    "created_at" => "2020-11-18 17:08:50",
                    "updated_at" => "2020-11-18 17:08:50"
                ),
                array(
                    "id" => 39,
                    "student_id" => 17,
                    "section_id" => 1,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 50,
                    "created_at" => "2020-11-18 17:11:13",
                    "updated_at" => "2020-11-18 17:11:13"
                ),
                array(
                    "id" => 40,
                    "student_id" => 20,
                    "section_id" => 1,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 30,
                    "created_at" => "2020-11-19 00:35:52",
                    "updated_at" => "2020-11-19 00:35:52"
                ),
                array(
                    "id" => 41,
                    "student_id" => 20,
                    "section_id" => 2,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 30,
                    "created_at" => "2020-11-19 00:35:52",
                    "updated_at" => "2020-11-19 00:35:52"
                ),
                array(
                    "id" => 50,
                    "student_id" => 21,
                    "section_id" => 1,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 40,
                    "created_at" => "2020-11-19 00:59:36",
                    "updated_at" => "2020-11-19 00:59:36"
                ),
                array(
                    "id" => 51,
                    "student_id" => 21,
                    "section_id" => 2,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 30,
                    "created_at" => "2020-11-19 00:59:36",
                    "updated_at" => "2020-11-19 00:59:36"
                ),
                array(
                    "id" => 52,
                    "student_id" => 24,
                    "section_id" => 1,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 35,
                    "created_at" => "2020-11-21 08:02:48",
                    "updated_at" => "2020-11-21 08:02:48"
                ),
                array(
                    "id" => 53,
                    "student_id" => 24,
                    "section_id" => 2,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 25,
                    "created_at" => "2020-11-21 08:02:48",
                    "updated_at" => "2020-11-21 08:02:48"
                ),
                array(
                    "id" => 54,
                    "student_id" => 30,
                    "section_id" => 1,
                    "section_type" => "theory",
                    "is_active" => "yes",
                    "students" => 55,
                    "created_at" => "2020-11-22 01:30:30",
                    "updated_at" => "2020-11-22 01:30:30"
                ),
                array(
                    "id" => 57,
                    "student_id" => 30,
                    "section_id" => 3,
                    "section_type" => "lab",
                    "is_active" => "yes",
                    "students" => 55,
                    "created_at" => "2020-11-22 01:34:21",
                    "updated_at" => "2020-11-22 01:34:21"
                )
            );
    
            SectionStudent::insert($section_students);
    
            $sections = array(
                array(
                    "id" => 1,
                    "section_name" => "A",
                    "parent" => 0,
                    "slug" => "a",
                    "type" => "theory",
                    "created_at" => "2020-08-10 15:25:48",
                    "updated_at" => "2020-08-10 15:25:48",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 2,
                    "section_name" => "B",
                    "parent" => 0,
                    "slug" => "b",
                    "type" => "theory",
                    "created_at" => "2020-08-10 15:25:52",
                    "updated_at" => "2020-08-10 15:25:52",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 3,
                    "section_name" => "A1",
                    "parent" => 1,
                    "slug" => "a1",
                    "type" => "lab",
                    "created_at" => "2020-09-21 12:43:18",
                    "updated_at" => "2020-09-21 12:43:18",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 4,
                    "section_name" => "A2",
                    "parent" => 1,
                    "slug" => "a2",
                    "type" => "lab",
                    "created_at" => "2020-09-21 12:43:24",
                    "updated_at" => "2020-09-21 12:43:24",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 5,
                    "section_name" => "B1",
                    "parent" => 2,
                    "slug" => "b1",
                    "type" => "lab",
                    "created_at" => "2020-09-21 12:43:38",
                    "updated_at" => "2020-09-21 12:43:38",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 6,
                    "section_name" => "B2",
                    "parent" => 2,
                    "slug" => "b2",
                    "type" => "lab",
                    "created_at" => "2020-09-21 12:43:44",
                    "updated_at" => "2020-09-21 12:43:44",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 7,
                    "section_name" => "C",
                    "parent" => 0,
                    "slug" => "c",
                    "type" => "theory",
                    "created_at" => "2020-11-18 04:52:48",
                    "updated_at" => "2020-11-18 04:52:48",
                    "is_active" => "yes"
                )
            );
    
            Section::insert($sections);
    
            $sessions = array(
                array(
                    "id" => 1,
                    "session_name" => "Fall",
                    "session_code" => null,
                    "created_at" => "2020-08-01 03:12:57",
                    "updated_at" => "2020-08-01 03:24:38",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 2,
                    "session_name" => "Summer",
                    "session_code" => null,
                    "created_at" => "2020-08-01 03:14:07",
                    "updated_at" => "2020-08-01 03:14:07",
                    "is_active" => "yes"
                ),
                array(
                    "id" => 4,
                    "session_name" => "Spring",
                    "session_code" => null,
                    "created_at" => "2020-08-08 00:36:23",
                    "updated_at" => "2020-08-08 00:36:23",
                    "is_active" => "yes"
                )
            );
    
            Session::insert($sessions);
    
            $shift_sessions = array(
                array(
                    "id" => 11,
                    "session_id" => 4,
                    "shift_id" => 1,
                    "day_id" => null,
                    "is_active" => "yes",
                    "created_at" => "2020-08-08 00:53:28",
                    "updated_at" => "2020-08-08 04:25:06"
                ),
                array(
                    "id" => 14,
                    "session_id" => 2,
                    "shift_id" => 1,
                    "day_id" => null,
                    "is_active" => "yes",
                    "created_at" => "2020-08-08 01:11:02",
                    "updated_at" => "2020-08-08 01:11:02"
                ),
                array(
                    "id" => 16,
                    "session_id" => 1,
                    "shift_id" => 2,
                    "day_id" => null,
                    "is_active" => "yes",
                    "created_at" => "2020-08-08 01:36:32",
                    "updated_at" => "2020-08-08 04:30:17"
                ),
                array(
                    "id" => 17,
                    "session_id" => 2,
                    "shift_id" => 2,
                    "day_id" => null,
                    "is_active" => "yes",
                    "created_at" => "2020-08-08 01:36:36",
                    "updated_at" => "2020-08-08 01:36:36"
                ),
                array(
                    "id" => 18,
                    "session_id" => 4,
                    "shift_id" => 2,
                    "day_id" => null,
                    "is_active" => "yes",
                    "created_at" => "2020-08-08 01:36:42",
                    "updated_at" => "2020-08-08 01:36:42"
                )
            );
    
            ShiftSession::insert($shift_sessions);
    
            $shifts = array(
                array(
                    "id" => 1,
                    "shift_name" => "Day",
                    "slug" => "D",
                    "is_active" => "yes",
                    "created_at" => "2021-05-18 22:06:50",
                    "updated_at" => "2021-05-18 22:06:50"
                ),
                array(
                    "id" => 2,
                    "shift_name" => "Morning",
                    "slug" => "M",
                    "is_active" => "yes",
                    "created_at" => "2021-05-18 22:06:53",
                    "updated_at" => "2021-05-18 22:06:53"
                )
            );
    
            Shift::insert($shifts);
    
    
            $students = array(
                array(
                    "id" => 20,
                    "number_of_student" => 60,
                    "batch_id" => 5,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-19 00:35:43",
                    "updated_at" => "2020-11-19 00:35:43"
                ),
                array(
                    "id" => 21,
                    "number_of_student" => 70,
                    "batch_id" => 2,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-19 00:36:09",
                    "updated_at" => "2020-11-19 00:59:19"
                ),
                array(
                    "id" => 24,
                    "number_of_student" => 60,
                    "batch_id" => 4,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-21 08:02:37",
                    "updated_at" => "2020-11-21 08:02:37"
                ),
                array(
                    "id" => 30,
                    "number_of_student" => 55,
                    "batch_id" => 3,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-21 08:22:53",
                    "updated_at" => "2020-11-22 01:30:21"
                ),
                array(
                    "id" => 31,
                    "number_of_student" => 40,
                    "batch_id" => 6,
                    "yearly_session_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-23 23:59:58",
                    "updated_at" => "2020-11-25 12:33:20"
                )
            );
    
            Student::insert($students);
    
            $teacher_ranks = array(
                array(
                    "id" => 1,
                    "rank" => "Lecturer",
                    "is_active" => "yes",
                    "created_at" => "2020-07-23 06:00:00",
                    "updated_at" => "2020-07-23 06:00:00"
                ),
                array(
                    "id" => 3,
                    "rank" => "Sr. Lecturer",
                    "is_active" => "yes",
                    "created_at" => "2020-07-26 23:28:52",
                    "updated_at" => "2020-07-26 23:37:39"
                )
            );
    
            TeacherRank::insert($teacher_ranks);
    
    
    
            $teachers = array(
                array(
                    "id" => 1,
                    "user_id" => 1,
                    "slug" => "SD",
                    "rank_id" => 3,
                    "department_id" => 1,
                    "is_active" => "yes",
                    "join_date" => "2020-07-02",
                    "created_at" => "2020-07-23 00:00:00",
                    "updated_at" => "2020-11-23 22:41:25"
                ),
                array(
                    "id" => 8,
                    "user_id" => 8,
                    "slug" => "MR",
                    "rank_id" => 3,
                    "department_id" => 1,
                    "is_active" => "yes",
                    "join_date" => "1970-01-01",
                    "created_at" => "2020-11-23 22:43:38",
                    "updated_at" => "2020-11-23 22:43:38"
                ),
                array(
                    "id" => 9,
                    "user_id" => 9,
                    "slug" => "AR",
                    "rank_id" => 3,
                    "department_id" => 1,
                    "is_active" => "yes",
                    "join_date" => "1970-01-01",
                    "created_at" => "2020-11-23 22:45:33",
                    "updated_at" => "2020-11-23 22:45:33"
                ),
                array(
                    "id" => 10,
                    "user_id" => 10,
                    "slug" => "EH",
                    "rank_id" => 3,
                    "department_id" => 1,
                    "is_active" => "yes",
                    "join_date" => "1970-01-01",
                    "created_at" => "2020-11-23 22:46:39",
                    "updated_at" => "2020-11-23 22:50:12"
                ),
                array(
                    "id" => 11,
                    "user_id" => 11,
                    "slug" => "MB",
                    "rank_id" => 3,
                    "department_id" => 1,
                    "is_active" => "yes",
                    "join_date" => "1970-01-01",
                    "created_at" => "2020-11-23 22:47:46",
                    "updated_at" => "2020-11-23 22:50:24"
                ),
                array(
                    "id" => 12,
                    "user_id" => 12,
                    "slug" => "AZC",
                    "rank_id" => 3,
                    "department_id" => 1,
                    "is_active" => "yes",
                    "join_date" => "1970-01-01",
                    "created_at" => "2020-11-23 22:49:09",
                    "updated_at" => "2020-11-23 22:49:09"
                )
            );
    
            Teacher::insert($teachers);
    
    
            $teachers_offday = array(
                array(
                    "id" => 19,
                    "teacher_id" => 3,
                    "day_id" => 2,
                    "is_active" => "yes",
                    "created_at" => "2020-09-25 20:26:34",
                    "updated_at" => "2020-09-25 20:26:34"
                ),
                array(
                    "id" => 20,
                    "teacher_id" => 3,
                    "day_id" => 7,
                    "is_active" => "yes",
                    "created_at" => "2020-09-25 20:26:34",
                    "updated_at" => "2020-09-25 20:26:34"
                ),
                array(
                    "id" => 25,
                    "teacher_id" => 4,
                    "day_id" => 3,
                    "is_active" => "yes",
                    "created_at" => "2020-09-29 17:41:11",
                    "updated_at" => "2020-09-29 17:41:11"
                ),
                array(
                    "id" => 26,
                    "teacher_id" => 4,
                    "day_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-09-29 17:41:11",
                    "updated_at" => "2020-09-29 17:41:11"
                ),
                array(
                    "id" => 27,
                    "teacher_id" => 6,
                    "day_id" => 6,
                    "is_active" => "yes",
                    "created_at" => "2020-11-19 01:01:23",
                    "updated_at" => "2020-11-19 01:01:23"
                ),
                array(
                    "id" => 28,
                    "teacher_id" => 6,
                    "day_id" => 7,
                    "is_active" => "yes",
                    "created_at" => "2020-11-19 01:01:23",
                    "updated_at" => "2020-11-19 01:01:23"
                ),
                array(
                    "id" => 31,
                    "teacher_id" => 5,
                    "day_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-19 01:01:43",
                    "updated_at" => "2020-11-19 01:01:43"
                ),
                array(
                    "id" => 32,
                    "teacher_id" => 5,
                    "day_id" => 5,
                    "is_active" => "yes",
                    "created_at" => "2020-11-19 01:01:43",
                    "updated_at" => "2020-11-19 01:01:43"
                ),
                array(
                    "id" => 33,
                    "teacher_id" => 2,
                    "day_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-19 01:31:38",
                    "updated_at" => "2020-11-19 01:31:38"
                ),
                array(
                    "id" => 34,
                    "teacher_id" => 2,
                    "day_id" => 7,
                    "is_active" => "yes",
                    "created_at" => "2020-11-19 01:31:38",
                    "updated_at" => "2020-11-19 01:31:38"
                ),
                array(
                    "id" => 74,
                    "teacher_id" => 1,
                    "day_id" => 1,
                    "is_active" => "yes",
                    "created_at" => "2020-11-26 16:18:21",
                    "updated_at" => "2020-11-26 16:18:21"
                ),
                array(
                    "id" => 75,
                    "teacher_id" => 9,
                    "day_id" => 5,
                    "is_active" => "yes",
                    "created_at" => "2020-11-26 16:19:11",
                    "updated_at" => "2020-11-26 16:19:11"
                ),
                array(
                    "id" => 76,
                    "teacher_id" => 8,
                    "day_id" => 3,
                    "is_active" => "yes",
                    "created_at" => "2020-11-28 05:48:48",
                    "updated_at" => "2020-11-28 05:48:48"
                ),
                array(
                    "id" => 77,
                    "teacher_id" => 10,
                    "day_id" => 7,
                    "is_active" => "yes",
                    "created_at" => "2020-11-28 05:48:52",
                    "updated_at" => "2020-11-28 05:48:52"
                ),
                array(
                    "id" => 78,
                    "teacher_id" => 11,
                    "day_id" => 6,
                    "is_active" => "yes",
                    "created_at" => "2020-11-28 05:48:55",
                    "updated_at" => "2020-11-28 05:48:55"
                ),
                array(
                    "id" => 79,
                    "teacher_id" => 12,
                    "day_id" => 4,
                    "is_active" => "yes",
                    "created_at" => "2020-11-28 05:48:59",
                    "updated_at" => "2020-11-28 05:48:59"
                )
            );
            TeachersOffday::insert($teachers_offday);
    
            $time_slots = array(
                array(
                    "id" => 1,
                    "from" => "09:00:00",
                    "to" => "10:25:00",
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "type" => "1",
                    "created_at" => "2020-09-21 12:54:45",
                    "updated_at" => "2020-09-21 12:54:45"
                ),
                array(
                    "id" => 2,
                    "from" => "10:30:00",
                    "to" => "11:55:00",
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "type" => "1",
                    "created_at" => "2020-09-21 12:54:57",
                    "updated_at" => "2020-09-21 12:54:57"
                ),
                array(
                    "id" => 3,
                    "from" => "12:00:00",
                    "to" => "13:25:00",
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "type" => "1",
                    "created_at" => "2020-09-21 12:55:12",
                    "updated_at" => "2020-09-21 12:55:12"
                ),
                array(
                    "id" => 4,
                    "from" => "14:00:00",
                    "to" => "15:25:00",
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "type" => "1",
                    "created_at" => "2020-09-21 12:55:26",
                    "updated_at" => "2020-09-21 12:55:26"
                ),
                array(
                    "id" => 5,
                    "from" => "15:30:00",
                    "to" => "17:00:00",
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "type" => "1",
                    "created_at" => "2020-09-21 12:55:43",
                    "updated_at" => "2020-09-21 12:55:43"
                ),
                array(
                    "id" => 6,
                    "from" => "18:30:00",
                    "to" => "21:30:00",
                    "shift_id" => 2,
                    "is_active" => "yes",
                    "type" => "2",
                    "created_at" => "2020-09-21 12:56:01",
                    "updated_at" => "2020-09-21 12:56:01"
                ),
                array(
                    "id" => 7,
                    "from" => "09:30:00",
                    "to" => "12:30:00",
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "type" => "2",
                    "created_at" => "2020-09-24 12:40:28",
                    "updated_at" => "2020-09-24 12:40:28"
                ),
                array(
                    "id" => 8,
                    "from" => "15:00:00",
                    "to" => "18:00:00",
                    "shift_id" => 1,
                    "is_active" => "yes",
                    "type" => "2",
                    "created_at" => "2020-09-24 12:40:43",
                    "updated_at" => "2020-09-24 12:40:43"
                )
            );
    
            TimeSlot::insert($time_slots);
    
            $yearly_sessions = array(
                array(
                    "id" => 4,
                    "session_id" => 1,
                    "year" => 2020,
                    "is_active" => "yes",
                    "created_at" => "2020-10-06 23:54:03",
                    "updated_at" => "2020-10-13 12:58:23"
                ),
                array(
                    "id" => 5,
                    "session_id" => 2,
                    "year" => 2020,
                    "is_active" => "no",
                    "created_at" => "2020-10-06 23:54:03",
                    "updated_at" => "2020-12-02 04:54:16"
                ),
                array(
                    "id" => 6,
                    "session_id" => 4,
                    "year" => 2020,
                    "is_active" => "no",
                    "created_at" => "2020-10-06 23:54:03",
                    "updated_at" => "2020-11-20 00:16:11"
                )
            );
    
            YearlySession::insert($yearly_sessions);
        }
    }
}
