<ul id="task-list" class="list-group">
    @foreach($tasks as $task)
        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $task->id }}">
            <span>{{ $task->title }}</span>
            <span class="badge bg-secondary">{{ ucfirst($task->status) }}</span>
        </li>
    @endforeach
</ul>
