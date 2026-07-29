<?php

namespace App\Services;

use App\Models\FullRoutine;
use App\Models\TeachersOffday;
use App\Models\Course;
use App\Models\Room;
use App\Models\DayWiseSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutineSchedulerService
{
    /**
     * Check all conflicts and constraints.
     *
     * @param Request $request
     * @return array|null Error array with type and text, or null if passed.
     */
    public function checkSchedulingConstraints(Request $request)
    {
        $course = Course::where('id', $request->course_id)->select('course_type')->first();

        if ($course && $course->course_type == 0) {
            $consecutiveError = $this->checkConsecutiveTheoryClasses($request);
            if ($consecutiveError) {
                return $consecutiveError;
            }
        }

        // Validate main slot
        $conflictError = $this->checkConflicts($request, $request->time_slot_id);
        if ($conflictError) {
            return $conflictError;
        }

        // Validate additional slot if present (double-slot classes)
        if ($request->additional_time_slot) {
            $conflictErrorAdditional = $this->checkConflicts($request, $request->additional_time_slot);
            if ($conflictErrorAdditional) {
                $conflictErrorAdditional['text'] = '[Additional Slot] ' . $conflictErrorAdditional['text'];
                return $conflictErrorAdditional;
            }
        }

        return null;
    }

    private function checkConsecutiveTheoryClasses(Request $request)
    {
        $time_slot_id = $request->time_slot_id;
        $currentTimeSlot = DB::table('time_slots')->where('id', $time_slot_id)->first();
        if (!$currentTimeSlot) {
            return null;
        }

        // Fetch all time slots of the same type ordered by 'from' in a single query
        $allTimeSlots = DB::table('time_slots')
            ->where('type', $currentTimeSlot->type)
            ->orderBy('from')
            ->get();

        $currentIndex = $allTimeSlots->search(function($item) use ($time_slot_id) {
            return $item->id == $time_slot_id;
        });

        if ($currentIndex === false) {
            return null;
        }

        $nextSlotIds = $allTimeSlots->slice($currentIndex + 1, 2)->pluck('id')->toArray();
        $prevSlotIds = [];
        if ($currentIndex >= 1) {
            $prevSlotIds[] = $allTimeSlots[$currentIndex - 1]->id;
        }
        if ($currentIndex >= 2) {
            $prevSlotIds[] = $allTimeSlots[$currentIndex - 2]->id;
        }

        $exclude_ids = [];
        if ($request->routine_id != '') {
            $cell = FullRoutine::find($request->routine_id);
            if ($cell) {
                $exclude_ids = FullRoutine::where([
                    ['batch_id', $cell->batch_id],
                    ['section_id', $cell->section_id],
                    ['day_id', $cell->day_id],
                    ['teacher_id', $cell->teacher_id],
                    ['course_id', $cell->course_id],
                    ['room_id', $cell->room_id],
                    ['yearly_session_id', $cell->yearly_session_id],
                ])->pluck('id')->toArray();
            }
        }

        // Load all routines on same day for teacher or batch in a single query
        $routinesOnDay = DB::table('routine')
            ->where('day_id', $request->day_id)
            ->where(function($query) use ($request) {
                $query->where('teacher_id', $request->teacher_id)
                      ->orWhere('batch_id', $request->batch_id);
            })
            ->when(!empty($exclude_ids), function($query) use ($exclude_ids) {
                $query->whereNotIn('id', $exclude_ids);
            })
            ->get();

        $next_with_batch = 0;
        if (!empty($nextSlotIds)) {
            $next_with_batch = $routinesOnDay->where('time_slot_id', $nextSlotIds[0])
                ->where('batch_id', $request->batch_id)
                ->where('teacher_id', $request->teacher_id)
                ->count();
        }

        $next_without_batch = 0;
        if (!empty($nextSlotIds)) {
            $next_without_batch = $routinesOnDay->whereIn('time_slot_id', $nextSlotIds)
                ->where('teacher_id', $request->teacher_id)
                ->count();
        }

        $prev_with_batch = 0;
        if (!empty($prevSlotIds)) {
            $prev_with_batch = $routinesOnDay->where('time_slot_id', $prevSlotIds[0])
                ->where('batch_id', $request->batch_id)
                ->where('teacher_id', $request->teacher_id)
                ->count();
        }

        $prev_without_batch = 0;
        if (!empty($prevSlotIds)) {
            $prev_without_batch = $routinesOnDay->whereIn('time_slot_id', $prevSlotIds)
                ->where('teacher_id', $request->teacher_id)
                ->count();
        }

        $total_consecutive_theory_class = $prev_without_batch + $next_without_batch;
        $total_consecutive_theory_class_batch_wise = $prev_with_batch + $next_with_batch;

        if ($total_consecutive_theory_class_batch_wise >= 1) {
            return ['type' => 'error', 'text' => 'Can not take 2 consecutive theory classes of same batch!'];
        }
        if ($total_consecutive_theory_class > 1) {
            return ['type' => 'error', 'text' => 'Can not take 3 consecutive theory classes in one day!'];
        }

        return null;
    }

    private function checkConflicts(Request $request, $time_slot_id)
    {
        $exclude_ids = [];
        if ($request->routine_id != '') {
            $cell = FullRoutine::find($request->routine_id);
            if ($cell) {
                $exclude_ids = FullRoutine::where([
                    ['batch_id', $cell->batch_id],
                    ['section_id', $cell->section_id],
                    ['day_id', $cell->day_id],
                    ['teacher_id', $cell->teacher_id],
                    ['course_id', $cell->course_id],
                    ['room_id', $cell->room_id],
                    ['yearly_session_id', $cell->yearly_session_id],
                ])->pluck('id')->toArray();
            }
        }

        // Fetch all matching routines for same day and time slot in ONE query
        $routinesAtSlot = FullRoutine::where([
            ['day_id', $request->day_id],
            ['time_slot_id', $time_slot_id],
            ['yearly_session_id', $request->yearly_session_id],
        ])
        ->when(!empty($exclude_ids), function($query) use ($exclude_ids) {
            $query->whereNotIn('id', $exclude_ids);
        })
        ->get();

        // 1. Identical schedule check
        $exists = $routinesAtSlot->where('batch_id', $request->batch_id)
            ->where('section_id', $request->section_id)
            ->where('teacher_id', $request->teacher_id)
            ->where('course_id', $request->course_id)
            ->where('room_id', $request->room_id)
            ->isNotEmpty();
        if ($exists) {
            return ['type' => 'error', 'text' => 'Data already exists!!!'];
        }

        // 2. Room occupied check
        $exist_room = $routinesAtSlot->firstWhere('room_id', $request->room_id);
        if ($exist_room) {
            return ['type' => 'error', 'text' => 'Can not assign class on same room at same time slot'];
        }

        // 3. Teacher occupied check
        $exist_teacher = $routinesAtSlot->firstWhere('teacher_id', $request->teacher_id);
        if ($exist_teacher) {
            return ['type' => 'error', 'text' => 'This Time slot already assigned for this teacher'];
        }

        // 4. Teacher offday check
        $teacher_offday = TeachersOffday::where([
            ['teacher_id', $request->teacher_id],
            ['day_id', $request->day_id],
        ])->exists();
        if ($teacher_offday) {
            return ['type' => 'error', 'text' => 'Cannot assign class on offday'];
        }

        return null;
    }
}
