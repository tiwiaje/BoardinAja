<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Task;

class PriorityAdjusted extends Notification
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail']; // Menyebar ke email
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Prioritas Tugas Diperbarui')
            ->line('Prioritas tugas Anda dengan nama "' . $this->task->name . '" telah diperbarui.')
            ->action('Lihat Tugas', url('/tasks/' . $this->task->id))
            ->line('Terima kasih telah menggunakan aplikasi kami.');
    }
}
