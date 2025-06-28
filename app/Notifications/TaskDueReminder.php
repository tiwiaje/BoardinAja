<?php

// app/Notifications/TaskDueReminder.php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class TaskDueReminder extends Notification
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pengingat Tugas Mendekati Tenggat')
->line("Tugas '{$this->task->title}' akan segera jatuh tempo pada " . \Carbon\Carbon::parse($this->task->due_date)->format('d M Y') . ".")
            ->action('Lihat Tugas', url('/tasks'))
            ->line('Jangan lupa selesaikan tugas ini tepat waktu!');
    }
}
