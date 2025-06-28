@extends('layouts.app')

@section('content')
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        margin: 0 auto;
        max-width: 600px;
        transition: all 0.3s ease;
    }
    
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 35px 60px rgba(0, 0, 0, 0.15);
    }
    
    .form-title {
        color: white;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        color: white;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }
    
    .form-input {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .form-input:focus {
        outline: none;
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .form-textarea {
        min-height: 120px;
        resize: vertical;
        font-family: inherit;
    }
    
    .form-select {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .form-select:focus {
        outline: none;
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: center;
    }
    
    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 180px;
        justify-content: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-primary {
        background: linear-gradient(45deg, #4CAF50, #45a049);
        color: white;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.6);
        background: linear-gradient(45deg, #45a049, #4CAF50);
    }
    
    .btn-secondary {
        background: linear-gradient(45deg, #f44336, #d32f2f);
        color: white;
        box-shadow: 0 4px 15px rgba(244, 67, 54, 0.4);
    }
    
    .btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(244, 67, 54, 0.6);
        background: linear-gradient(45deg, #d32f2f, #f44336);
    }
    
    .priority-select option {
        padding: 0.5rem;
    }
    
    .status-select option {
        padding: 0.5rem;
    }
    
    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
        z-index: 1;
    }
    
    .floating-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-circle:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .floating-circle:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 20%;
        right: 10%;
        animation-delay: 2s;
    }
    
    .floating-circle:nth-child(3) {
        width: 60px;
        height: 60px;
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }
    
    .floating-circle:nth-child(4) {
        width: 100px;
        height: 100px;
        bottom: 10%;
        right: 20%;
        animation-delay: 1s;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }
    
    .form-container {
        position: relative;
        z-index: 2;
    }
    
    @media (max-width: 768px) {
        .glass-card {
            margin: 1rem;
            padding: 1.5rem;
        }
        
        .form-title {
            font-size: 2rem;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .btn {
            min-width: 100%;
        }
    }
</style>

<div class="gradient-bg">
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>
    
    <div class="form-container">
        <div class="glass-card">
            <h1 class="form-title">
                ✏️ Edit Tugas
            </h1>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-6 rounded-lg mb-8 animate-pulse">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <h4 class="font-semibold">Perhatian!</h4>
                    </div>
                    <ul class="space-y-2">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center">
                                <i class="fas fa-dot-circle text-red-400 mr-2 text-xs"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title" class="form-label">📋 Judul Tugas</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ $task->title }}" 
                           class="form-input" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">📝 Deskripsi</label>
                    <textarea name="description" 
                              id="description" 
                              class="form-input form-textarea" 
                              placeholder="Masukkan deskripsi tugas...">{{ $task->description }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="deadline" class="form-label">📅 Deadline</label>
                    <input type="datetime-local" 
                           name="deadline" 
                           id="deadline" 
                           value="{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i') : '' }}" 
                           class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="priority" class="form-label">⚡ Prioritas</label>
                    <select name="priority" id="priority" class="form-select priority-select">
                        <option value="normal" {{ $task->priority === 'normal' ? 'selected' : '' }}>🟢 Normal</option>
                        <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>🟠 High</option>
                        <option value="urgent" {{ $task->priority === 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
                    </select>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Perubahan
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                        ❌ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection