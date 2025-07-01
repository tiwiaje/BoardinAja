<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'description',
    'priority',
    'deadline',
    'status',
    'category',
    'priority_score',
    'user_id',
    'completed_at',
];

    const STATUSES = ['todo', 'in_progress', 'done'];
    const PRIORITIES = ['urgent', 'high', 'normal'];

    public static function calculatePriorityScore($priority, $deadline = null)
    {
        $score = match ($priority) {
            'urgent' => 100,
            'high' => 70,
            'normal' => 50,
            default => 0,
        };

        if ($deadline) {
            $daysLeft = now()->diffInDays(Carbon::parse($deadline), false);
            if ($daysLeft <= 0) $score += 50;
            elseif ($daysLeft <= 1) $score += 40;
            elseif ($daysLeft <= 3) $score += 30;
            elseif ($daysLeft <= 7) $score += 20;
            else $score += max(0, 15 - ($daysLeft / 7));
        }

        return $score;
    }

    protected $casts = [
        'deadline' => 'date',
        'completed_at' => 'datetime',
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_TODO = 'todo';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';

    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_TODO => 'To Do',
            self::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
            self::STATUS_DONE => 'Selesai'
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

        public function scopeOrderedByPriority($query)
        {
            return $query->orderBy('priority_score', 'desc')
                        ->orderBy('sort_order', 'asc')
                        ->orderBy('created_at', 'desc');
        }

    public function getUrgencyLevelAttribute()
    {
        if (!$this->deadline) {
            return 'normal';
        }

        $daysToDeadline = Carbon::now()->diffInDays($this->deadline, false);

        if ($daysToDeadline <= 0) {
            return 'overdue';
        } elseif ($daysToDeadline <= 1) {
            return 'urgent';
        } elseif ($daysToDeadline <= 3) {
            return 'high';
        } else {
            return 'normal';
        }
    }

    public function markAsCompleted()
    {
        $this->status = self::STATUS_DONE;
        $this->completed_at = Carbon::now();
        $this->save();
    }

    public function isOverdue()
    {
        return $this->deadline && Carbon::now()->isAfter($this->deadline) && $this->status !== self::STATUS_DONE;
    }

    
}