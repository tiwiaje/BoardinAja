<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Task - Prioritfy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.06) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .header {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 30px;
            margin-bottom: 30px;
            color: white;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            50% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }

            100% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
        }

        @keyframes slideDown {
            0% {
                transform: translateY(-30px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 2;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
            font-weight: 300;
            position: relative;
            z-index: 2;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.8s ease-out 0.2s both;
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.05), transparent);
            animation: cardShine 4s ease-in-out infinite;
        }

        @keyframes cardShine {
            0% {
                left: -100%;
            }

            50% {
                left: 100%;
            }

            100% {
                left: -100%;
            }
        }

        @keyframes slideUp {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-group {
            margin-bottom: 25px;
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            position: relative;
            z-index: 2;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.5s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.6s;
        }

        .form-group:nth-child(5) {
            animation-delay: 0.7s;
        }

        .form-group:nth-child(6) {
            animation-delay: 0.8s;
        }

        @keyframes fadeInUp {
            0% {
                transform: translateY(20px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 10px;
            font-size: 1rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: relative;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15),
                0 8px 25px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
            background: white;
        }

        .form-input:hover {
            border-color: #d1d5db;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .form-input.error {
            border-color: #ef4444;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15),
                0 8px 25px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
            background: white;
        }

        .priority-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 12px;
        }

        .priority-option {
            position: relative;
        }

        .priority-radio {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .priority-label {
            display: block;
            padding: 16px 12px;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-size: 0.95rem;
            color: #6b7280;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .priority-label::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .priority-label:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .priority-label:hover::before {
            left: 100%;
        }

        .priority-label.urgent {
            border-color: #fecaca;
            background: linear-gradient(135deg, #fef2f2, #fef7f7);
            color: #dc2626;
        }

        .priority-label.high {
            border-color: #fed7aa;
            background: linear-gradient(135deg, #fffbeb, #fffcf0);
            color: #d97706;
        }

        .priority-label.normal {
            border-color: #bbf7d0;
            background: linear-gradient(135deg, #f0fdf4, #f7fef8);
            color: #059669;
        }

        .priority-radio:checked+.priority-label.urgent {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border-color: #dc2626;
            color: white;
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
            transform: scale(1.05);
        }

        .priority-radio:checked+.priority-label.high {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            border-color: #d97706;
            color: white;
            box-shadow: 0 8px 25px rgba(217, 119, 6, 0.4);
            transform: scale(1.05);
        }

        .priority-radio:checked+.priority-label.normal {
            background: linear-gradient(135deg, #059669, #10b981);
            border-color: #059669;
            color: white;
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
            transform: scale(1.05);
        }

        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }

            50% {
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            }
        }

        .button-group {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            animation: fadeInUp 0.6s ease-out 0.9s both;
        }

        .btn {
            flex: 1;
            padding: 18px 24px;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            text-align: center;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            color: #374151;
            border: 2px solid #e5e7eb;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 8px;
            display: none;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-5px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            padding: 16px 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            font-weight: 500;
            animation: slideInAlert 0.5s ease-out;
            backdrop-filter: blur(10px);
        }

        @keyframes slideInAlert {
            0% {
                transform: translateX(-20px);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fef7f7);
            border: 1px solid #fecaca;
            color: #dc2626;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4, #f7fef8);
            border: 1px solid #bbf7d0;
            color: #166534;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.1);
        }

        /* Loading animation for form submission */
        .btn-primary:active {
            transform: scale(0.98);
        }

        /* Enhanced focus indicators for accessibility */
        .form-input:focus-visible,
        .form-select:focus-visible,
        .priority-radio:focus-visible+.priority-label,
        .btn:focus-visible {
            outline: 3px solid rgba(102, 126, 234, 0.5);
            outline-offset: 2px;
        }

        @media (max-width: 640px) {
            .container {
                padding: 10px;
            }

            .header {
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 20px;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .form-card {
                padding: 25px;
                border-radius: 25px;
            }

            .button-group {
                flex-direction: column;
                gap: 15px;
            }

            .priority-options {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .btn {
                padding: 16px 20px;
                font-size: 1rem;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-plus-circle"></i>Buat Tugas Baru</h1>
            <p>Tambah tugas di sini kalau kamu suka hidup yang menantang dan deadline yang menjerat.</p>
        </div>

        <div class="form-card">
            {{-- Display validation errors --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Display success message --}}
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf

                <!-- Status Badge -->
                <div class="status-badge">
                    Status: {{ ucfirst(request('status', 'todo')) }}
                </div>

                <!-- Hidden Status Field -->
                <input type="hidden" name="status" value="{{ request('status', 'todo') }}">

                <!-- Task Title -->
                <div class="form-group">
                    <label for="title" class="form-label">
                        <i class="fas fa-heading"></i> Judul *
                    </label>
                    <input type="text"
                        id="title"
                        name="title"
                        class="form-input @error('title') error @enderror"
                        placeholder="Enter task title..."
                        value="{{ old('title') }}"
                        required>
                    @error('title')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Task Description -->
                <div class="form-group">
                    <label for="description" class="form-label">
                        <i class="fas fa-align-left"></i> Deskripsi
                    </label>
                    <textarea id="description"
                        name="description"
                        class="form-input form-textarea @error('description') error @enderror"
                        placeholder="Enter task description..."
                        rows="4">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Priority -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-exclamation-circle"></i> Prioritas *
                    </label>
                    <div class="priority-options">
                        <div class="priority-option">
                            <input type="radio"
                                id="priority-urgent"
                                name="priority"
                                value="urgent"
                                class="priority-radio"
                                {{ old('priority') == 'urgent' ? 'checked' : '' }}>
                            <label for="priority-urgent" class="priority-label urgent">
                                <i class="fas fa-fire"></i> Urgent
                            </label>
                        </div>
                        <div class="priority-option">
                            <input type="radio"
                                id="priority-high"
                                name="priority"
                                value="high"
                                class="priority-radio"
                                {{ old('priority') == 'high' ? 'checked' : '' }}>
                            <label for="priority-high" class="priority-label high">
                                <i class="fas fa-arrow-up"></i> High
                            </label>
                        </div>
                        <div class="priority-option">
                            <input type="radio"
                                id="priority-normal"
                                name="priority"
                                value="normal"
                                class="priority-radio"
                                {{ old('priority', 'normal') == 'normal' ? 'checked' : '' }}>
                            <label for="priority-normal" class="priority-label normal">
                                <i class="fas fa-minus"></i> Normal
                            </label>
                        </div>
                    </div>
                    @error('priority')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deadline -->
                <div class="form-group">
                    <label for="deadline" class="form-label">
                        <i class="fas fa-calendar-alt"></i> Deadline *
                    </label>
                    <input type="date"
                        id="deadline"
                        name="deadline"
                        class="form-input @error('deadline') error @enderror"
                        value="{{ old('deadline') }}"
                        required>
                    @error('deadline')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category (Optional) -->
                <div class="form-group">
                    <label for="category" class="form-label">
                        <i class="fas fa-tag"></i> Kategori
                    </label>
                    <select id="category" name="category" class="form-select @error('category') error @enderror">
                        <option value="">Select category...</option>
                        <option value="work" {{ old('category') == 'work' ? 'selected' : '' }}>Work</option>
                        <option value="personal" {{ old('category') == 'personal' ? 'selected' : '' }}>Personal</option>
                        <option value="study" {{ old('category') == 'study' ? 'selected' : '' }}>Study</option>
                        <option value="project" {{ old('category') == 'project' ? 'selected' : '' }}>Project</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="button-group">
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Board
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Buat Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Set default date to today
        document.addEventListener('DOMContentLoaded', function() {
            const deadlineInput = document.getElementById('deadline');
            if (!deadlineInput.value) {
                deadlineInput.value = new Date().toISOString().split('T')[0];
            }
            deadlineInput.min = new Date().toISOString().split('T')[0];
        });

        // Enhanced visual feedback for priority selection
        document.querySelectorAll('.priority-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove active state from all labels
                document.querySelectorAll('.priority-label').forEach(label => {
                    label.style.transform = 'scale(1)';
                });

                // Add active state to selected label with enhanced animation
                if (this.checked) {
                    const label = document.querySelector(`label[for="${this.id}"]`);
                    label.style.transform = 'scale(1.05)';

                    // Add ripple effect
                    const ripple = document.createElement('div');
                    ripple.style.cssText = `
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        width: 20px;
                        height: 20px;
                        background: rgba(255, 255, 255, 0.5);
                        border-radius: 50%;
                        transform: translate(-50%, -50%) scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                    `;

                    const style = document.createElement('style');
                    style.textContent = `
                        @keyframes ripple {
                            to {
                                transform: translate(-50%, -50%) scale(4);
                                opacity: 0;
                            }
                        }
                    `;
                    document.head.appendChild(style);
                    label.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                        style.remove();
                    }, 600);
                }
            });
        });

        // Add floating animation to form inputs on focus
        document.querySelectorAll('.form-input, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>

</html>
