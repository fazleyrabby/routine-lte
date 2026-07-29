<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class FreshDataSeeder extends Seeder
{
    public function run()
    {
        // ─── 0. TRUNCATE messy data (preserve days, time_slots, shifts, sessions, rooms, users/admin) ───
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('routine')->truncate();
        DB::table('course_offers')->truncate();
        DB::table('assign_courses_to_teachers')->truncate();
        DB::table('section_students')->truncate();
        DB::table('sections')->truncate();
        DB::table('students')->truncate();
        DB::table('batch')->truncate();
        DB::table('courses')->truncate();
        // Remove duplicate/extra departments, keep only clean ones
        DB::table('departments')->truncate();
        // Remove extra teachers (keep admin user, remove teacher users from 2026 seeder)
        DB::table('teachers')->truncate();
        DB::table('teacher_ranks')->truncate();
        DB::table('day_wise_slots')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ─── 1. DEPARTMENTS (2 clean departments) ───────────────────────────────
        $deptSwe = DB::table('departments')->insertGetId([
            'department_name' => 'SWE',
            'is_active'       => 'yes',
            'created_at'      => now(), 'updated_at' => now(),
        ]);
        $deptDs = DB::table('departments')->insertGetId([
            'department_name' => 'DS',
            'is_active'       => 'yes',
            'created_at'      => now(), 'updated_at' => now(),
        ]);

        // ─── 2. SHIFTS (Day & Morning already exist, just fetch) ─────────────────
        $shiftDay = DB::table('shifts')->where('slug', 'D')->value('id')
            ?? DB::table('shifts')->insertGetId(['shift_name' => 'Day', 'slug' => 'D', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $shiftMorning = DB::table('shifts')->where('slug', 'M')->value('id')
            ?? DB::table('shifts')->insertGetId(['shift_name' => 'Morning', 'slug' => 'M', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);

        // ─── 3. ACTIVE SESSION ───────────────────────────────────────────────────
        // Use the active yearly_session (Fall 2026, id=10)
        $activeSession = DB::table('yearly_sessions')->where('is_active', 'yes')->orderByDesc('id')->value('id');

        // ─── 4. TEACHER RANKS ────────────────────────────────────────────────────
        $rankProf = DB::table('teacher_ranks')->insertGetId(['rank' => 'Professor', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $rankAssoc = DB::table('teacher_ranks')->insertGetId(['rank' => 'Associate Professor', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $rankAsst = DB::table('teacher_ranks')->insertGetId(['rank' => 'Assistant Professor', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $rankLect = DB::table('teacher_ranks')->insertGetId(['rank' => 'Lecturer', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);

        // ─── 5. TEACHERS (4 teachers, shared across both departments) ────────────
        $teachersRaw = [
            ['firstname' => 'Dr. Alice',   'lastname' => 'Rahman',   'email' => 'alice@uni.edu',   'username' => 'alice_rahman',   'rank_id' => $rankProf],
            ['firstname' => 'Dr. Bob',     'lastname' => 'Hossain',  'email' => 'bob@uni.edu',     'username' => 'bob_hossain',    'rank_id' => $rankAssoc],
            ['firstname' => 'Mr. Charlie', 'lastname' => 'Karim',    'email' => 'charlie@uni.edu', 'username' => 'charlie_karim',  'rank_id' => $rankAsst],
            ['firstname' => 'Ms. Diana',   'lastname' => 'Akter',    'email' => 'diana@uni.edu',   'username' => 'diana_akter',    'rank_id' => $rankLect],
        ];

        $teacherIds = [];
        foreach ($teachersRaw as $t) {
            // Check if user already exists
            $userId = DB::table('users')->where('email', $t['email'])->value('id');
            if (!$userId) {
                $userId = DB::table('users')->insertGetId([
                    'firstname'  => $t['firstname'],
                    'lastname'   => $t['lastname'],
                    'email'      => $t['email'],
                    'username'   => $t['username'],
                    'slug'       => str_replace(' ', '-', strtolower($t['firstname'].'-'.$t['lastname'])),
                    'password'   => Hash::make('password'),
                    'role'       => 'teacher',
                    'is_active'  => 'yes',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            $teacherId = DB::table('teachers')->insertGetId([
                'user_id'    => $userId,
                'rank_id'    => $t['rank_id'],
                'is_active'  => 'yes',
                'created_at' => now(), 'updated_at' => now(),
            ]);
            $teacherIds[] = $teacherId;
        }
        [$t1, $t2, $t3, $t4] = $teacherIds;

        // ─── 6. COURSES ──────────────────────────────────────────────────────────
        // 4 Theory + 2 Lab courses (shared across depts, real-looking)
        $coursesRaw = [
            // SWE courses
            ['code' => 'SWE401', 'name' => 'Software Architecture',         'type' => '0', 'credit' => 3],
            ['code' => 'SWE402', 'name' => 'Software Project Management',   'type' => '0', 'credit' => 3],
            ['code' => 'SWE403', 'name' => 'Mobile Application Development','type' => '0', 'credit' => 3],
            ['code' => 'SWE404', 'name' => 'Mobile App Dev Lab',            'type' => '1', 'credit' => 1.5],
            // DS courses
            ['code' => 'DS401',  'name' => 'Machine Learning',              'type' => '0', 'credit' => 3],
            ['code' => 'DS402',  'name' => 'Big Data Analytics',            'type' => '0', 'credit' => 3],
            ['code' => 'DS403',  'name' => 'Data Visualization',            'type' => '0', 'credit' => 3],
            ['code' => 'DS404',  'name' => 'Data Science Lab',              'type' => '1', 'credit' => 1.5],
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
        // SWE courses: courseIds[0..3], DS courses: courseIds[4..7]
        $sweCoursesStr = implode(',', array_slice($courseIds, 0, 4));
        $dsCoursesStr  = implode(',', array_slice($courseIds, 4, 4));

        // ─── 7. BATCHES (2 per dept) ─────────────────────────────────────────────
        $sweBatch1 = DB::table('batch')->insertGetId(['batch_no' => 40, 'department_id' => $deptSwe, 'shift_id' => $shiftDay,     'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $sweBatch2 = DB::table('batch')->insertGetId(['batch_no' => 41, 'department_id' => $deptSwe, 'shift_id' => $shiftMorning, 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $dsBatch1  = DB::table('batch')->insertGetId(['batch_no' => 38, 'department_id' => $deptDs,  'shift_id' => $shiftDay,     'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);
        $dsBatch2  = DB::table('batch')->insertGetId(['batch_no' => 39, 'department_id' => $deptDs,  'shift_id' => $shiftMorning, 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()]);

        $allBatches = [
            'swe' => [$sweBatch1, $sweBatch2],
            'ds'  => [$dsBatch1, $dsBatch2],
        ];

        // ─── 8. SECTIONS (Theory A & B per batch) ────────────────────────────────
        foreach ([$sweBatch1, $sweBatch2, $dsBatch1, $dsBatch2] as $batchId) {
            DB::table('sections')->insert([
                ['batch_id' => $batchId, 'section_name' => 'A', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['batch_id' => $batchId, 'section_name' => 'B', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // ─── 9. STUDENTS (batch counters — 30 per batch for progress display) ────
        // We create one student record per batch as representative (no real student data needed for routing)
        foreach ([$sweBatch1, $sweBatch2] as $batchId) {
            $studentId = DB::table('students')->insertGetId([
                'batch_id'          => $batchId,
                'yearly_session_id' => $activeSession,
                'total_student'     => 35,
                'created_at'        => now(), 'updated_at' => now(),
            ]);
            // Link to section A
            $sectionId = DB::table('sections')->where('batch_id', $batchId)->where('section_name', 'A')->value('id');
            if ($sectionId) {
                DB::table('section_students')->insert([
                    'student_id'  => $studentId,
                    'section_id'  => $sectionId,
                    'created_at'  => now(), 'updated_at' => now(),
                ]);
            }
        }
        foreach ([$dsBatch1, $dsBatch2] as $batchId) {
            $studentId = DB::table('students')->insertGetId([
                'batch_id'          => $batchId,
                'yearly_session_id' => $activeSession,
                'total_student'     => 30,
                'created_at'        => now(), 'updated_at' => now(),
            ]);
            $sectionId = DB::table('sections')->where('batch_id', $batchId)->where('section_name', 'A')->value('id');
            if ($sectionId) {
                DB::table('section_students')->insert([
                    'student_id'  => $studentId,
                    'section_id'  => $sectionId,
                    'created_at'  => now(), 'updated_at' => now(),
                ]);
            }
        }

        // ─── 10. DAY-WISE SLOTS ──────────────────────────────────────────────────
        // Saturday–Thursday (days 1–6), theory slots 1–5 per day
        $days = DB::table('days')->where('is_active', 'yes')->whereNotIn('slug', ['FRI'])->pluck('id');
        $theorySlots = DB::table('time_slots')->where('type', 1)->pluck('id');
        $labSlots    = DB::table('time_slots')->where('type', 2)->pluck('id');

        foreach ($days as $dayId) {
            foreach ($theorySlots as $slotId) {
                DB::table('day_wise_slots')->insert([
                    'day_id'       => $dayId,
                    'time_slot_id' => $slotId,
                    'class_slot'   => 1,
                    'created_at'   => now(), 'updated_at' => now(),
                ]);
            }
            foreach ($labSlots as $slotId) {
                DB::table('day_wise_slots')->insert([
                    'day_id'       => $dayId,
                    'time_slot_id' => $slotId,
                    'class_slot'   => 1,
                    'created_at'   => now(), 'updated_at' => now(),
                ]);
            }
        }

        // ─── 11. COURSE OFFERS (batch → courses, for active session) ─────────────
        foreach ([$sweBatch1, $sweBatch2] as $batchId) {
            DB::table('course_offers')->insert([
                'batch_id'           => $batchId,
                'yearly_session_id'  => $activeSession,
                'courses'            => $sweCoursesStr,
                'is_active'          => 'yes',
                'created_at'         => now(), 'updated_at' => now(),
            ]);
        }
        foreach ([$dsBatch1, $dsBatch2] as $batchId) {
            DB::table('course_offers')->insert([
                'batch_id'           => $batchId,
                'yearly_session_id'  => $activeSession,
                'courses'            => $dsCoursesStr,
                'is_active'          => 'yes',
                'created_at'         => now(), 'updated_at' => now(),
            ]);
        }

        // ─── 12. ASSIGN COURSES TO TEACHERS (workload for active session) ─────────
        // Each teacher gets assigned specific courses for this session
        // SWE: t1→SWE401, t2→SWE402, t3→SWE403+SWE404(lab), t4→SWE401+SWE402
        // DS:  t1→DS401,  t2→DS402,  t3→DS403+DS404(lab),    t4→DS401+DS402
        [$cSwe1, $cSwe2, $cSwe3, $cSwe4, $cDs1, $cDs2, $cDs3, $cDs4] = $courseIds;

        $workloads = [
            // Teacher 1: SWE401 + DS401
            ['teacher_id' => $t1, 'courses' => "{$cSwe1},{$cDs1}"],
            // Teacher 2: SWE402 + DS402
            ['teacher_id' => $t2, 'courses' => "{$cSwe2},{$cDs2}"],
            // Teacher 3: SWE403 + SWE404(lab) + DS403 + DS404(lab)
            ['teacher_id' => $t3, 'courses' => "{$cSwe3},{$cSwe4},{$cDs3},{$cDs4}"],
            // Teacher 4: can cover any — backup for SWE401,SWE402,DS401,DS402
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

        $this->command->info('✅ Fresh clean data seeded successfully.');
        $this->command->info("   Active session ID: {$activeSession}");
        $this->command->info("   Departments: SWE (id:{$deptSwe}), DS (id:{$deptDs})");
        $this->command->info("   Teachers: {$t1}, {$t2}, {$t3}, {$t4}");
        $this->command->info("   Courses: ".implode(', ', $courseIds));
        $this->command->info("   SWE batches: {$sweBatch1}, {$sweBatch2} | DS batches: {$dsBatch1}, {$dsBatch2}");
    }
}
