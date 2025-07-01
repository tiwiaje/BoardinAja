<div class="task-card {{ $task->priority }}">
    <strong>{{ $task->title }}</strong>
    <p>{{ $task->description }}</p>
</div>


    <div class="task-title">
        {{ $task->title }}
    </div>

    <div class="task-description">
        {{ $task->description }}
    </div>

    <div class="task-meta">
        <span class="task-deadline {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'overdue' : '' }}">
            Deadline: {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
        </span>
        @if ($task->category)
            <span class="task-category">
                {{ $task->category }}
            </span>
        @endif
    </div>
</div>
