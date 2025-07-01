<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function productivity()
    {
        $user = Auth::user();
        $sevenDaysAgo = Carbon::now()->subDays(7)->startOfDay();

        $tasksDone = Task::where('user_id', $user->id)
            ->where('status', Task::STATUS_DONE)
            ->where('updated_at', '>=', $sevenDaysAgo)
            ->get();

        $groupedByDay = $tasksDone->groupBy(function ($task) {
            return $task->updated_at->format('Y-m-d');
        });

        $result = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = $groupedByDay->has($date) ? $groupedByDay[$date]->count() : 0;
            $result[] = [
                'date' => $date,
                'tasks_done' => $count,
            ];
        }

        return response()->json(array_reverse($result));
    }
}
