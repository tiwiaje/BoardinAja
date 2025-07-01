@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Task</h1>
            <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <!-- Task Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $task->title }}</h2>
            
            @if($task->description)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Deskripsi:</h3>
                    <p class="text-gray-600">{{ $task->description }}</p>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-700">Status:</span>
                    <span class="ml-2 px-2 py-1 rounded-full text-xs
                        @if($task->status === 'done') bg-green-100 text-green-800
                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                        @elseif($task->status === 'todo') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>

                @if($task->deadline)
                <div>
                    <span class="font-medium text-gray-700">Deadline:</span>
                    <span class="ml-2">{{ $task->deadline->format('d M Y') }}</span>
                </div>
                @endif

                @if($task->priority_score > 0)
                <div>
                    <span class="font-medium text-gray-700">Priority:</span>
                    <span class="ml-2">{{ number_format($task->priority_score, 1) }}</span>
                </div>
                @endif

                @if($task->completed_at)
                <div>
                    <span class="font-medium text-gray-700">Selesai:</span>
                    <span class="ml-2">{{ $task->completed_at->format('d M Y H:i') }}</span>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="mt-6 pt-4 border-t border-gray-100 flex space-x-3">
                <a href="{{ route('tasks.edit', $task) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                
                @if($task->status !== 'done')
                <button onclick="completeTask({{ $task->id }})" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i>Selesai
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection