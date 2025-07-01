<?php

// app/Console/Commands/SendTaskDueReminders.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDueReminder;
use Carbon\Carbon;

class SendTaskDueReminders extends Command
{
    protected $signature = 'tasks:send-due-reminders';

    protected $description = 'Send email reminders for tasks due soon';

    public function handle()
{
    $tasks = Task::where('due_date', '<=', now()->addDay())
                 ->where('status', '!=', 'completed')
                 ->with('user')
                 ->get();

    foreach ($tasks as $task) {
        if ($task->user && $task->user->email) {
            Mail::to($task->user->email)->send(new TaskDueReminderMail($task));
        }
    }
}

}
