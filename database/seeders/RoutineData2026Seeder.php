<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoutineData2026Seeder extends Seeder
{
    public function run()
    {
        // ─── 0. CLEAN SLATE ─────────────────────────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('routine')->truncate();
        DB::table('course_offers')->truncate();
        DB::table('assign_courses_to_teachers')->truncate();
        DB::table('section_students')->truncate();
        DB::table('sections')->truncate();
        DB::table('students')->truncate();
        DB::table('batch')->truncate();
        DB::table('courses')->truncate();
        DB::table('departments')->truncate();
        DB::table('teachers')->truncate();
        DB::table('teacher_ranks')->truncate();
        DB::table('day_wise_slots')->truncate();
        // Remove non-admin users from previous seeds
        DB::table('users')->whereNotIn('role', ['admin', 'superadmin'])->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ─── 0a. ESSENTIAL BASE DATA (Days, Shifts, Sessions, Time Slots) ────────
        if (DB::table('days')->count() == 0) {
            DB::table('days')->insert([
                ['id' => 1, 'day_title' => 'Saturday', 'slug' => 'SAT', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'day_title' => 'Sunday', 'slug' => 'SUN', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'day_title' => 'Monday', 'slug' => 'MON', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 4, 'day_title' => 'Tuesday', 'slug' => 'TUE', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 5, 'day_title' => 'Wednesday', 'slug' => 'WED', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 6, 'day_title' => 'Thursday', 'slug' => 'THU', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 7, 'day_title' => 'Friday', 'slug' => 'FRI', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('shifts')->count() == 0) {
            DB::table('shifts')->insert([
                ['id' => 1, 'shift_name' => 'Day', 'slug' => 'D', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'shift_name' => 'Morning', 'slug' => 'M', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'shift_name' => 'Evening', 'slug' => 'E', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('sessions')->count() == 0) {
            DB::table('sessions')->insert([
                ['id' => 1, 'session_name' => 'Spring', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'session_name' => 'Summer', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 4, 'session_name' => 'Fall', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('time_slots')->count() == 0) {
            DB::table('time_slots')->insert([
                ['id' => 1, 'from' => '09:00:00', 'to' => '10:25:00', 'shift_id' => 1, 'is_active' => 'yes', 'type' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'from' => '10:30:00', 'to' => '11:55:00', 'shift_id' => 1, 'is_active' => 'yes', 'type' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'from' => '12:00:00', 'to' => '13:25:00', 'shift_id' => 1, 'is_active' => 'yes', 'type' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 4, 'from' => '14:00:00', 'to' => '15:25:00', 'shift_id' => 1, 'is_active' => 'yes', 'type' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 5, 'from' => '15:30:00', 'to' => '17:00:00', 'shift_id' => 1, 'is_active' => 'yes', 'type' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 6, 'from' => '18:30:00', 'to' => '21:30:00', 'shift_id' => 2, 'is_active' => 'yes', 'type' => '2', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 7, 'from' => '09:30:00', 'to' => '12:30:00', 'shift_id' => 1, 'is_active' => 'yes', 'type' => '2', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 8, 'from' => '15:00:00', 'to' => '18:00:00', 'shift_id' => 1, 'is_active' => 'yes', 'type' => '2', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (DB::table('shift_sessions')->count() == 0) {
            DB::table('shift_sessions')->insert([
                ['id' => 11, 'session_id' => 4, 'shift_id' => 1, 'day_id' => null, 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 18, 'session_id' => 4, 'shift_id' => 2, 'day_id' => null, 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // ─── 0b. ADMIN USER ──────────────────────────────────────────────────────
        $adminExists = DB::table('users')->where('username', 'superadmin')->exists();
        if (!$adminExists) {
            DB::table('users')->insert([
                'firstname' => 'Mr.Showmitra', 'lastname' => 'Das',
                'username'  => 'superadmin',
                'password'  => Hash::make('123456'),
                'role'       => 'admin', 'email' => 'superadmin@gmail.com',
                'is_active'  => 'yes', 'is_teacher' => 'no',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // ─── 1. DEPARTMENTS ──────────────────────────────────────────────────────
        $deptSwe = DB::table('departments')->insertGetId([
            'department_name' => 'SWE', 'is_active' => 'yes',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $deptDs = DB::table('departments')->insertGetId([
            'department_name' => 'DS', 'is_active' => 'yes',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // ─── 2. SHIFTS ───────────────────────────────────────────────────────────
        $shiftDay = DB::table('shifts')->where('slug', 'D')->value('id')
            ?? DB::table('shifts')->insertGetId(['shift_name' => 'Day', 'slug' => 'D', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $shiftMorning = DB::table('shifts')->where('slug', 'M')->value('id')
            ?? DB::table('shifts')->insertGetId(['shift_name' => 'Morning', 'slug' => 'M', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);

        // ─── 3. ACTIVE SESSION ───────────────────────────────────────────────────
        if (DB::table('yearly_sessions')->count() == 0) {
            DB::table('yearly_sessions')->insert([
                ['id' => 10, 'session_id' => 4, 'year' => 2026, 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        
        $activeSession = DB::table('yearly_sessions')
            ->where('is_active', 'yes')
            ->orderByDesc('id')
            ->value('id');

        // ─── 4. TEACHER RANKS ────────────────────────────────────────────────────
        $rankProf  = DB::table('teacher_ranks')->insertGetId(['rank' => 'Professor',           'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $rankAssoc = DB::table('teacher_ranks')->insertGetId(['rank' => 'Associate Professor', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $rankAsst  = DB::table('teacher_ranks')->insertGetId(['rank' => 'Assistant Professor', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $rankLect  = DB::table('teacher_ranks')->insertGetId(['rank' => 'Lecturer',            'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);

        // ─── 5. TEACHERS ─────────────────────────────────────────────────────────
        $teachersRaw = [
            ['firstname' => 'Dr. Alice',   'lastname' => 'Rahman',  'email' => 'alice@uni.edu',   'username' => 'alice_rahman',  'rank_id' => $rankProf],
            ['firstname' => 'Dr. Bob',     'lastname' => 'Hossain', 'email' => 'bob@uni.edu',     'username' => 'bob_hossain',   'rank_id' => $rankAssoc],
            ['firstname' => 'Mr. Charlie', 'lastname' => 'Karim',   'email' => 'charlie@uni.edu', 'username' => 'charlie_karim', 'rank_id' => $rankAsst],
            ['firstname' => 'Ms. Diana',   'lastname' => 'Akter',   'email' => 'diana@uni.edu',   'username' => 'diana_akter',   'rank_id' => $rankLect],
        ];

        $teacherIds = [];
        foreach ($teachersRaw as $t) {
            $userId = DB::table('users')->where('email', $t['email'])->value('id');
            if (!$userId) {
                $userId = DB::table('users')->insertGetId([
                    'firstname'   => $t['firstname'],
                    'lastname'    => $t['lastname'],
                    'email'       => $t['email'],
                    'username'    => $t['username'],
                    'password'    => Hash::make('password'),
                    'role'        => 'user',
                    'is_active'   => 'yes',
                    'is_teacher'  => 'yes',
                    'in_committee'=> 'no',
                    'gender'      => 1,
                    'contact'     => '01700000000',
                    'created_at'  => now(), 'updated_at' => now(),
                ]);
            }
            $teacherIds[] = DB::table('teachers')->insertGetId([
                'user_id'    => $userId,
                'rank_id'    => $t['rank_id'],
                'is_active'  => 'yes',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
        [$t1, $t2, $t3, $t4] = $teacherIds;

        // ─── 6. COURSES ──────────────────────────────────────────────────────────
        $coursesRaw = [
            // SWE (index 0–3)
            ['code' => 'SWE401', 'name' => 'Software Architecture',          'type' => '0', 'credit' => 3],
            ['code' => 'SWE402', 'name' => 'Software Project Management',    'type' => '0', 'credit' => 3],
            ['code' => 'SWE403', 'name' => 'Mobile Application Development', 'type' => '0', 'credit' => 3],
            ['code' => 'SWE404', 'name' => 'Mobile App Dev Lab',             'type' => '1', 'credit' => 1.5],
            // DS (index 4–7)
            ['code' => 'DS401',  'name' => 'Machine Learning',               'type' => '0', 'credit' => 3],
            ['code' => 'DS402',  'name' => 'Big Data Analytics',             'type' => '0', 'credit' => 3],
            ['code' => 'DS403',  'name' => 'Data Visualization',             'type' => '0', 'credit' => 3],
            ['code' => 'DS404',  'name' => 'Data Science Lab',               'type' => '1', 'credit' => 1.5],
        ];

        $courseIds = [];
        foreach ($coursesRaw as $c) {
            $courseIds[] = DB::table('courses')->insertGetId([
                'course_code' => $c['code'],
                'course_name' => $c['name'],
                'course_type' => $c['type'],
                'credit'      => $c['credit'],
                'is_active'   => 'yes',
                'created_at'  => now(), 'updated_at' => now(),
            ]);
        }

        $sweCoursesStr = implode(',', array_slice($courseIds, 0, 4));
        $dsCoursesStr  = implode(',', array_slice($courseIds, 4, 4));
        [$cSwe1, $cSwe2, $cSwe3, $cSwe4, $cDs1, $cDs2, $cDs3, $cDs4] = $courseIds;

        // ─── 7. BATCHES ──────────────────────────────────────────────────────────
        $sweBatch1 = DB::table('batch')->insertGetId(['batch_no' => 40, 'department_id' => $deptSwe, 'shift_id' => $shiftDay,     'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $sweBatch2 = DB::table('batch')->insertGetId(['batch_no' => 41, 'department_id' => $deptSwe, 'shift_id' => $shiftMorning, 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $dsBatch1  = DB::table('batch')->insertGetId(['batch_no' => 38, 'department_id' => $deptDs,  'shift_id' => $shiftDay,     'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $dsBatch2  = DB::table('batch')->insertGetId(['batch_no' => 39, 'department_id' => $deptDs,  'shift_id' => $shiftMorning, 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);

        // ─── 8. SECTIONS (A & B per batch) ──────────────────────────────────────
        $sectionMap = [];
        foreach ([$sweBatch1, $sweBatch2, $dsBatch1, $dsBatch2] as $batchId) {
            $idA = DB::table('sections')->insertGetId([
                'section_name' => 'A', 'slug' => 'a', 'type' => 'theory', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()
            ]);
            $idB = DB::table('sections')->insertGetId([
                'section_name' => 'B', 'slug' => 'b', 'type' => 'theory', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()
            ]);
            $sectionMap[$batchId] = ['A' => $idA, 'B' => $idB];
        }

        // ─── 9. STUDENTS + SECTION STUDENTS ─────────────────────────────────────
        foreach ([$sweBatch1, $sweBatch2, $dsBatch1, $dsBatch2] as $batchId) {
            $studentIdA = DB::table('students')->insertGetId([
                'batch_id'          => $batchId,
                'yearly_session_id' => $activeSession,
                'number_of_student' => 35,
                'is_active'         => 'yes',
                'created_at'        => now(), 'updated_at' => now(),
            ]);
            DB::table('section_students')->insert([
                'student_id'   => $studentIdA,
                'section_id'   => $sectionMap[$batchId]['A'],
                'section_type' => 'theory',
                'students'     => 18,
                'is_active'    => 'yes',
                'created_at'   => now(), 'updated_at' => now(),
            ]);
            $studentIdB = DB::table('students')->insertGetId([
                'batch_id'          => $batchId,
                'yearly_session_id' => $activeSession,
                'number_of_student' => 35,
                'is_active'         => 'yes',
                'created_at'        => now(), 'updated_at' => now(),
            ]);
            DB::table('section_students')->insert([
                'student_id'   => $studentIdB,
                'section_id'   => $sectionMap[$batchId]['B'],
                'section_type' => 'theory',
                'students'     => 17,
                'is_active'    => 'yes',
                'created_at'   => now(), 'updated_at' => now(),
            ]);
        }

        // ─── 8b. ROOMS ─────────────────────────────────────────────────────────
        $roomsData = [
            ['building' => 'A', 'room_no' => '101', 'capacity' => 60, 'room_type' => '0'],
            ['building' => 'A', 'room_no' => '102', 'capacity' => 70, 'room_type' => '0'],
            ['building' => 'A', 'room_no' => '301', 'capacity' => 50, 'room_type' => '0'],
            ['building' => 'B', 'room_no' => '203', 'capacity' => 100, 'room_type' => '1'],
            ['building' => 'C', 'room_no' => '333', 'capacity' => 100, 'room_type' => '1'],
            ['building' => 'A', 'room_no' => '601', 'capacity' => 65, 'room_type' => '1'],
        ];
        $roomIds = [];
        foreach ($roomsData as $r) {
            $existing = DB::table('rooms')->where('building', $r['building'])->where('room_no', $r['room_no'])->first();
            if ($existing) {
                $roomIds[] = $existing->id;
            } else {
                $roomIds[] = DB::table('rooms')->insertGetId($r + ['is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
            }
        }
        [$rTheory1, $rTheory2, $rTheory3, $rLab1, $rLab2, $rLab3] = $roomIds;

        // ─── 10. DAY-WISE SLOTS ──────────────────────────────────────────────────
        // Sat–Thu: theory slots (1–5) + evening lab (6)
        $workingDays   = DB::table('days')->where('is_active', 'yes')->where('slug', '!=', 'FRI')->pluck('id');
        $theorySlotIds = DB::table('time_slots')->where('type', 1)->pluck('id');
        $eveningLabId  = DB::table('time_slots')->where('type', 2)->where('from', '18:30:00')->value('id');

        foreach ($workingDays as $dayId) {
            foreach ($theorySlotIds as $slotId) {
                DB::table('day_wise_slots')->insert([
                    'day_id'       => $dayId,
                    'time_slot_id' => $slotId,
                    'class_slot'   => 1,
                    'created_at'   => now(), 'updated_at' => now(),
                ]);
            }
            if ($eveningLabId) {
                DB::table('day_wise_slots')->insert([
                    'day_id'       => $dayId,
                    'time_slot_id' => $eveningLabId,
                    'class_slot'   => 1,
                    'created_at'   => now(), 'updated_at' => now(),
                ]);
            }
        }

        // Friday: 3-hour lab blocks (7: 09:30-12:30, 8: 15:00-18:00, 6: 18:30-21:30)
        $fridayId   = DB::table('days')->where('slug', 'FRI')->value('id');
        $fridayLabIds = DB::table('time_slots')->where('type', 2)->pluck('id');
        if ($fridayId) {
            foreach ($fridayLabIds as $slotId) {
                DB::table('day_wise_slots')->insert([
                    'day_id'       => $fridayId,
                    'time_slot_id' => $slotId,
                    'class_slot'   => 1,
                    'created_at'   => now(), 'updated_at' => now(),
                ]);
            }
        }

        // ─── 11. COURSE OFFERS ───────────────────────────────────────────────────
        foreach ([$sweBatch1, $sweBatch2] as $batchId) {
            DB::table('course_offers')->insert([
                'batch_id' => $batchId, 'yearly_session_id' => $activeSession,
                'courses' => $sweCoursesStr, 'is_active' => 'yes',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
        foreach ([$dsBatch1, $dsBatch2] as $batchId) {
            DB::table('course_offers')->insert([
                'batch_id' => $batchId, 'yearly_session_id' => $activeSession,
                'courses' => $dsCoursesStr, 'is_active' => 'yes',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // ─── 12. ASSIGN COURSES TO TEACHERS ──────────────────────────────────────
        // t1 → SWE401 + DS401
        // t2 → SWE402 + DS402
        // t3 → SWE403 + SWE404(lab) + DS403 + DS404(lab)
        // t4 → SWE401 + SWE402 + DS401 + DS402  (backup)
        $workloads = [
            ['teacher_id' => $t1, 'courses' => "{$cSwe1},{$cDs1}"],
            ['teacher_id' => $t2, 'courses' => "{$cSwe2},{$cDs2}"],
            ['teacher_id' => $t3, 'courses' => "{$cSwe3},{$cSwe4},{$cDs3},{$cDs4}"],
            ['teacher_id' => $t4, 'courses' => "{$cSwe1},{$cSwe2},{$cDs1},{$cDs2}"],
        ];
        foreach ($workloads as $w) {
            DB::table('assign_courses_to_teachers')->insert([
                'session_id'  => $activeSession,
                'teacher_id'  => $w['teacher_id'],
                'courses'     => $w['courses'],
                'is_active'   => 'yes',
                'created_at'  => now(), 'updated_at' => now(),
            ]);
        }

        // ─── 13. ROUTINE DATA ────────────────────────────────────────────────────
        $sSecA = $sectionMap[$sweBatch1]['A'];
        $sSecB = $sectionMap[$sweBatch1]['B'];
        $s2SecA = $sectionMap[$sweBatch2]['A'];
        $s2SecB = $sectionMap[$sweBatch2]['B'];
        $dSecA = $sectionMap[$dsBatch1]['A'];
        $dSecB = $sectionMap[$dsBatch1]['B'];
        $d2SecA = $sectionMap[$dsBatch2]['A'];
        $d2SecB = $sectionMap[$dsBatch2]['B'];

        $adminUserId = DB::table('users')->where('role', 'admin')->value('id') ?? 1;

        $routineData = [
            // ── SWE-40-D (Day) ──────────────────────────────────────────────────
            // Sat: SWE401 (Alice/ts1), SWE402 (Bob/ts2), SWE403 (Charlie/ts3)
            ['teacher_id' => $t1, 'batch_id' => $sweBatch1, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 1, 'course_id' => $cSwe1, 'room_id' => $rTheory1],
            ['teacher_id' => $t2, 'batch_id' => $sweBatch1, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 2, 'course_id' => $cSwe2, 'room_id' => $rTheory2],
            ['teacher_id' => $t3, 'batch_id' => $sweBatch1, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 3, 'course_id' => $cSwe3, 'room_id' => $rTheory3],
            // Mon: SWE401 (Alice/ts4), SWE402 (Bob/ts5)
            ['teacher_id' => $t1, 'batch_id' => $sweBatch1, 'section_id' => null, 'day_id' => 3, 'time_slot_id' => 4, 'course_id' => $cSwe1, 'room_id' => $rTheory1],
            ['teacher_id' => $t2, 'batch_id' => $sweBatch1, 'section_id' => null, 'day_id' => 3, 'time_slot_id' => 5, 'course_id' => $cSwe2, 'room_id' => $rTheory2],
            // Tue: SWE403 (Charlie/ts1)
            ['teacher_id' => $t3, 'batch_id' => $sweBatch1, 'section_id' => null, 'day_id' => 4, 'time_slot_id' => 1, 'course_id' => $cSwe3, 'room_id' => $rTheory3],
            // Mon ts6: SWE404 Lab sec A
            ['teacher_id' => $t3, 'batch_id' => $sweBatch1, 'section_id' => $sSecA, 'day_id' => 3, 'time_slot_id' => 6, 'course_id' => $cSwe4, 'room_id' => $rLab1],
            // Wed ts6: SWE404 Lab sec B
            ['teacher_id' => $t3, 'batch_id' => $sweBatch1, 'section_id' => $sSecB, 'day_id' => 5, 'time_slot_id' => 6, 'course_id' => $cSwe4, 'room_id' => $rLab1],

            // ── SWE-41-M (Morning) ─────────────────────────────────────────────
            // Sat: SWE401 (Alice/ts4), SWE402 (Bob/ts5)
            ['teacher_id' => $t1, 'batch_id' => $sweBatch2, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 4, 'course_id' => $cSwe1, 'room_id' => $rTheory1],
            ['teacher_id' => $t2, 'batch_id' => $sweBatch2, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 5, 'course_id' => $cSwe2, 'room_id' => $rTheory2],
            // Sun: SWE403 (Charlie/ts1)
            ['teacher_id' => $t3, 'batch_id' => $sweBatch2, 'section_id' => null, 'day_id' => 2, 'time_slot_id' => 1, 'course_id' => $cSwe3, 'room_id' => $rTheory3],
            // Sun ts6: SWE404 Lab
            ['teacher_id' => $t3, 'batch_id' => $sweBatch2, 'section_id' => null, 'day_id' => 2, 'time_slot_id' => 6, 'course_id' => $cSwe4, 'room_id' => $rLab1],
            // Mon: SWE401 (Alice/ts2)
            ['teacher_id' => $t1, 'batch_id' => $sweBatch2, 'section_id' => null, 'day_id' => 3, 'time_slot_id' => 2, 'course_id' => $cSwe1, 'room_id' => $rTheory1],
            // Tue: SWE402 (Bob/ts3)
            ['teacher_id' => $t2, 'batch_id' => $sweBatch2, 'section_id' => null, 'day_id' => 4, 'time_slot_id' => 3, 'course_id' => $cSwe2, 'room_id' => $rTheory2],

            // ── DS-38-D (Day) ──────────────────────────────────────────────────
            // Sat: DS401 (Alice/ts1), DS402 (Bob/ts2)
            ['teacher_id' => $t1, 'batch_id' => $dsBatch1, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 1, 'course_id' => $cDs1, 'room_id' => $rTheory2],
            ['teacher_id' => $t2, 'batch_id' => $dsBatch1, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 2, 'course_id' => $cDs2, 'room_id' => $rTheory3],
            // Sun: DS403 (Charlie/ts4)
            ['teacher_id' => $t3, 'batch_id' => $dsBatch1, 'section_id' => null, 'day_id' => 2, 'time_slot_id' => 4, 'course_id' => $cDs3, 'room_id' => $rTheory1],
            // Mon: DS401 (Alice/ts1)
            ['teacher_id' => $t1, 'batch_id' => $dsBatch1, 'section_id' => null, 'day_id' => 3, 'time_slot_id' => 1, 'course_id' => $cDs1, 'room_id' => $rTheory2],
            // Tue: DS402 (Bob/ts5), DS404 Lab (Charlie/ts6)
            ['teacher_id' => $t2, 'batch_id' => $dsBatch1, 'section_id' => null, 'day_id' => 4, 'time_slot_id' => 5, 'course_id' => $cDs2, 'room_id' => $rTheory3],
            ['teacher_id' => $t3, 'batch_id' => $dsBatch1, 'section_id' => null, 'day_id' => 4, 'time_slot_id' => 6, 'course_id' => $cDs4, 'room_id' => $rLab2],
            // Wed: DS403 (Charlie/ts2)
            ['teacher_id' => $t3, 'batch_id' => $dsBatch1, 'section_id' => null, 'day_id' => 5, 'time_slot_id' => 2, 'course_id' => $cDs3, 'room_id' => $rTheory1],

            // ── DS-39-M (Morning) ─────────────────────────────────────────────
            // Sat: DS401 (Alice/ts3), DS403 (Charlie/ts5)
            ['teacher_id' => $t1, 'batch_id' => $dsBatch2, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 3, 'course_id' => $cDs1, 'room_id' => $rTheory2],
            ['teacher_id' => $t3, 'batch_id' => $dsBatch2, 'section_id' => null, 'day_id' => 1, 'time_slot_id' => 5, 'course_id' => $cDs3, 'room_id' => $rTheory3],
            // Sun: DS402 (Bob/ts4)
            ['teacher_id' => $t2, 'batch_id' => $dsBatch2, 'section_id' => null, 'day_id' => 2, 'time_slot_id' => 4, 'course_id' => $cDs2, 'room_id' => $rTheory1],
            // Mon: DS404 Lab (Charlie/ts6)
            ['teacher_id' => $t3, 'batch_id' => $dsBatch2, 'section_id' => null, 'day_id' => 3, 'time_slot_id' => 6, 'course_id' => $cDs4, 'room_id' => $rLab2],
            // Tue: DS401 (Alice/ts1), DS402 (Bob/ts2)
            ['teacher_id' => $t1, 'batch_id' => $dsBatch2, 'section_id' => null, 'day_id' => 4, 'time_slot_id' => 1, 'course_id' => $cDs1, 'room_id' => $rTheory2],
            ['teacher_id' => $t2, 'batch_id' => $dsBatch2, 'section_id' => null, 'day_id' => 4, 'time_slot_id' => 2, 'course_id' => $cDs2, 'room_id' => $rTheory3],
            // Wed: DS403 (Charlie/ts3)
            ['teacher_id' => $t3, 'batch_id' => $dsBatch2, 'section_id' => null, 'day_id' => 5, 'time_slot_id' => 3, 'course_id' => $cDs3, 'room_id' => $rTheory1],
        ];

        $entries = [];
        foreach ($routineData as $i => $r) {
            $entries[] = [
                'teacher_id'        => $r['teacher_id'],
                'batch_id'          => $r['batch_id'],
                'section_id'        => $r['section_id'],
                'day_id'            => $r['day_id'],
                'time_slot_id'      => $r['time_slot_id'],
                'course_id'         => $r['course_id'],
                'room_id'           => $r['room_id'],
                'created_by'        => $adminUserId,
                'edited_by'         => null,
                'yearly_session_id' => $activeSession,
                'is_active'         => 'yes',
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }
        DB::table('routine')->insert($entries);

        $activeSessionRecord = DB::table('yearly_sessions')
            ->join('sessions', 'sessions.id', '=', 'yearly_sessions.session_id')
            ->where('yearly_sessions.id', $activeSession)
            ->select('sessions.session_name', 'yearly_sessions.year')
            ->first();
        $sessionStr = $activeSessionRecord ? "{$activeSessionRecord->session_name} {$activeSessionRecord->year} (ID: {$activeSession})" : $activeSession;

        // ─── SUMMARY ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('✅  RoutineData2026Seeder complete');
        $this->command->info("    Active session : {$sessionStr}");
        $this->command->info("    Departments    : SWE (id:{$deptSwe}), DS (id:{$deptDs})");
        $this->command->info("    Batches        : SWE-40-D ({$sweBatch1}), SWE-41-M ({$sweBatch2}), DS-38-D ({$dsBatch1}), DS-39-M ({$dsBatch2})");
        $this->command->info("    Courses        : SWE [{$sweCoursesStr}]  DS [{$dsCoursesStr}]");
        $this->command->info("    Teachers       : t{$t1}=Dr.Alice, t{$t2}=Dr.Bob, t{$t3}=Mr.Charlie, t{$t4}=Ms.Diana");
        $this->command->info("    Workloads      : t{$t1}→SWE401+DS401 | t{$t2}→SWE402+DS402 | t{$t3}→SWE403+SWE404+DS403+DS404 | t{$t4}→backup");
        $this->command->info("    Rooms          : {$rTheory1}(A-101), {$rTheory2}(A-102), {$rTheory3}(A-301), {$rLab1}(B-203), {$rLab2}(C-333), {$rLab3}(A-601)");
        $this->command->info("    Routine entries: " . count($entries));
        $this->command->info('');
    }
}
