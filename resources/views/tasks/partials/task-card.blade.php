@props(['task'])

<div class="bg-white border border-gray-200 rounded-lg p-4 mb-3 shadow-sm hover:shadow-md transition-shadow cursor-move" 
     data-task-id="{{ $task->id }}">

    <!-- Task Header -->
    <div class="flex items-start justify-between mb-2">
        <h4 class="font-medium text-gray-900 flex-1 mr-2">{{ $task->title }}</h4>

        <!-- Urgency Badge -->
        @if($task->urgency_level !== 'normal' && $task->status !== 'done')
            <span class="urgency-badge flex-shrink-0 px-2 py-1 text-xs rounded-full
                @if($task->urgency_level === 'overdue') bg-red-100 text-red-800
                @elseif($task->urgency_level === 'urgent') bg-orange-100 text-orange-800
                @elseif($task->urgency_level === 'high') bg-yellow-100 text-yellow-800
                @endif">
                @if($task->urgency_level === 'overdue')
                    <i class="fas fa-exclamation-triangle mr-1"></i>Terlambat
                @elseif($task->urgency_level === 'urgent')
                    <i class="fas fa-clock mr-1"></i>Mendesak
                @elseif($task->urgency_level === 'high')
                    <i class="fas fa-flag mr-1"></i>Tinggi
                @endif
            </span>
        @endif
    </div>

    <!-- Description -->
    @if($task->description)
        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
            {{ Str::limit($task->description, 100) }}
        </p>
    @endif

    <!-- Deadline -->
    @if($task->deadline)
        <div class="flex items-center text-sm text-gray-500 mb-3">
            <i class="fas fa-calendar-alt mr-2"></i>
            <span class="{{ $task->isOverdue() ? 'text-red-600 font-medium' : '' }}">
                {{ $task->deadline->format('d M Y') }}
                @if($task->isOverdue()) (Terlambat) @endif
            </span>
        </div>
    @endif

    <!-- Completed At -->
    @if($task->status === 'done' && $task->completed_at)
        <div class="flex items-center text-sm text-green-600 mb-3">
            <i class="fas fa-check-circle mr-2"></i>
            <span>Selesai: {{ $task->completed_at->format('d M Y H:i') }}</span>
        </div>
    @endif

    <!-- Priority Score -->
    @if($task->priority_score > 0)
        <div class="text-xs text-gray-400 mb-3">
            Priority: {{ number_format($task->priority_score, 1) }}
        </div>
    @endif

    <!-- Actions -->
    <div class="flex items-center justify-between pt-2 border-t border-gray-100">
        <div class="flex space-x-2">
            @if($task->status !== 'done')
                <button onclick="window.completeTask({{ $task->id }})"
                        class="text-green-600 hover:text-green-800 text-sm">
                    <i class="fas fa-check"></i> Selesai
                </button>
            @endif

            <a href="{{ route('tasks.edit', $task) }}"
               class="text-blue-600 hover:text-blue-800 text-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>

        <!-- Dropdown Menu -->
        <div class="relative">
            <button onclick="toggleMenu(this)" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-ellipsis-v"></i>
            </button>

            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10 hidden">
                <div class="py-1">
                    <a href="{{ route('tasks.show', $task) }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                    </a>

                    @if($task->status !== 'done')
                        <button onclick="window.moveToStatus({{ $task->id }}, 'draft'); closeMenu(this)"
                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-file-alt mr-2"></i>Pindah ke Draft
                        </button>
                        <button onclick="window.moveToStatus({{ $task->id }}, 'todo'); closeMenu(this)"
                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-list mr-2"></i>Pindah ke To Do
                        </button>
                        <button onclick="window.moveToStatus({{ $task->id }}, 'in_progress'); closeMenu(this)"
                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-play mr-2"></i>Pindah ke In Progress
                        </button>
                    @endif

                    <div class="border-t border-gray-100"></div>

                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleMenu(button) {
    const menu = button.nextElementSibling;
    
    // Close all other menus
    document.querySelectorAll('.dropdown-menu').forEach(m => {
        if (m !== menu) m.classList.add('hidden');
    });
    
    // Toggle current menu
    menu.classList.toggle('hidden');
}

function closeMenu(button) {
    const menu = button.closest('.dropdown-menu');
    menu.classList.add('hidden');
}

// Function to move task to different status
window.moveToStatus = function(taskId, status) {
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memindahkan...';
    button.disabled = true;
    
    // Create form data
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    formData.append('_method', 'PATCH');
    formData.append('status', status);
    
    // Send AJAX request
    fetch(`/tasks/${taskId}/status`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Task berhasil dipindahkan!', 'success');
            
            // Reload page or update UI
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Gagal memindahkan task: ' + error.message, 'error');
        
        // Restore button
        button.innerHTML = originalText;
        button.disabled = false;
    });
};

// Function to complete task
window.completeTask = function(taskId) {
    if (!confirm('Yakin ingin menandai task ini sebagai selesai?')) {
        return;
    }
    
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyelesaikan...';
    button.disabled = true;
    
    // Create form data
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    formData.append('_method', 'PATCH');
    formData.append('status', 'done');
    
    // Send AJAX request
    fetch(`/tasks/${taskId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Task berhasil diselesaikan!', 'success');
            
            // Reload page or update UI
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Gagal menyelesaikan task: ' + error.message, 'error');
        
        // Restore button
        button.innerHTML = originalText;
        button.disabled = false;
    });
};

// Function to show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    
    // Set colors based on type
    if (type === 'success') {
        notification.className += ' bg-green-500 text-white';
    } else if (type === 'error') {
        notification.className += ' bg-red-500 text-white';
    } else {
        notification.className += ' bg-blue-500 text-white';
    }
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Close menu when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>