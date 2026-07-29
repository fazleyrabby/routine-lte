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
        foreach ([$sweBatch1, $sweBatch2, $dsBatch1, $dsBatch2] as $batchId) {
            DB::table('sections')->insert([
                ['section_name' => 'A', 'slug' => 'a', 'type' => 'theory', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
                ['section_name' => 'B', 'slug' => 'b', 'type' => 'theory', 'is_active' => 'yes', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // ─── 9. STUDENTS + SECTION STUDENTS ─────────────────────────────────────
        foreach ([$sweBatch1, $sweBatch2, $dsBatch1, $dsBatch2] as $batchId) {
            $studentId = DB::table('students')->insertGetId([
                'batch_id'          => $batchId,
                'yearly_session_id' => $activeSession,
                'number_of_student' => 35,
                'is_active'         => 'yes',
                'created_at'        => now(), 'updated_at' => now(),
            ]);
            // Link to section A of this batch
            $sectionAId = DB::table('sections')
                ->where('section_name', 'A')
                ->orderByDesc('id')
                ->skip(
                    // find the right section A for this batch by position
                    DB::table('batch')->where('id', '<=', $batchId)->count() * 2 - 2
                )
                ->value('id');
            // Simpler: just get the most recently created section A
            $sectionAId = DB::table('sections')->where('section_name', 'A')->orderByDesc('id')->first()->id ?? null;
            if ($sectionAId) {
                DB::table('section_students')->insert([
                    'student_id'   => $studentId,
                    'section_id'   => $sectionAId,
                    'section_type' => 'theory',
                    'students'     => 35,
                    'is_active'    => 'yes',
                    'created_at'   => now(), 'updated_at' => now(),
                ]);
            }
        }

        // ─── 10. DAY-WISE SLOTS (Sat–Thu) ────────────────────────────────────────
        $workingDays   = DB::table('days')->where('is_active', 'yes')->where('slug', '!=', 'FRI')->pluck('id');
        $theorySlotIds = DB::table('time_slots')->where('type', 1)->pluck('id');
        $labSlotIds    = DB::table('time_slots')->where('type', 2)->pluck('id');

        foreach ($workingDays as $dayId) {
            foreach ($theorySlotIds->merge($labSlotIds) as $slotId) {
                DB::table('day_wise_slots')->insert([
                    'day_id'       => $dayId,
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

        // ─── SUMMARY ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('✅  RoutineData2026Seeder complete');
        $this->command->info("    Active session : {$activeSession}");
        $this->command->info("    Departments    : SWE (id:{$deptSwe}), DS (id:{$deptDs})");
        $this->command->info("    Batches        : SWE-40-D ({$sweBatch1}), SWE-41-M ({$sweBatch2}), DS-38-D ({$dsBatch1}), DS-39-M ({$dsBatch2})");
        $this->command->info("    Courses        : SWE [{$sweCoursesStr}]  DS [{$dsCoursesStr}]");
        $this->command->info("    Teachers       : t{$t1}=Dr.Alice, t{$t2}=Dr.Bob, t{$t3}=Mr.Charlie, t{$t4}=Ms.Diana");
        $this->command->info("    Workloads      : t{$t1}→SWE401+DS401 | t{$t2}→SWE402+DS402 | t{$t3}→SWE403+SWE404+DS403+DS404 | t{$t4}→backup");
        $this->command->info('');
    }
}
