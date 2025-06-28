<?php

use App\Models\Task;
use Carbon\Carbon;

if (!function_exists('autoAdjustPriorities')) {
    function autoAdjustPriorities($userId)
    {
        $tasks = Task::where('user_id', $userId)
            ->whereIn('status', [Task::STATUS_DRAFT, Task::STATUS_PENDING])
            ->orderByRaw('due_date IS NULL, due_date ASC')
            ->get();

        foreach ($tasks as $index => $task) {
            $task->priority = $index + 1;
            $task->save();
        }
    }
}

if (!function_exists('deadlineGroup')) {
    function deadlineGroup($dueDate)
    {
        if (!$dueDate) return 'tanpa deadline';

        $today = Carbon::today();
        $due = Carbon::parse($dueDate);

        if ($due->isSameDay($today)) return 'hari ini';
        if ($due->isSameDay($today->copy()->addDay())) return 'besok';
        if ($due->between($today, $today->copy()->endOfWeek())) return 'minggu ini';
        return 'lainnya';
    }
}
