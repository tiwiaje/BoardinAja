<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas - Priorify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.3);
        }
        
        .priority-card {
            animation: slideInUp 0.5s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .floating-label {
            transform: translateY(-50%) scale(0.85);
            transform-origin: left top;
            color: #667eea;
            font-weight: 500;
        }
        
        .form-group {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-input:focus {
            border-color: #667eea;
            outline: none;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s ease;
        }
        
        .form-input:focus + .input-icon {
            color: #667eea;
        }
        
        .status-option {
            transition: all 0.3s ease;
        }
        
        .status-option:hover {
            background: #f3f4f6;
            transform: translateX(5px);
        }
        
        .tips-card {
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .nav-tab {
            transition: all 0.2s ease;
            position: relative;
        }
        
        .nav-tab:hover {
            color: #374151;
        }
        
        .nav-tab.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center py-4">
                <!-- Left side - Logo and Navigation -->
                <div class="flex items-center space-x-12">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cube text-white text-sm"></i>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <nav class="flex space-x-8">
                        <a href="{{ route('dashboard') }}" class="nav-tab text-gray-600 hover:text-gray-900 font-medium pb-4 border-b-2 border-transparent hover:border-gray-300 transition-all duration-200">Dashboard</a>
                        <a href="{{ route('tasks.index') }}" class="nav-tab text-blue-600 hover:text-blue-700 font-medium pb-4 border-b-2 border-blue-600 transition-all duration-200">Tasks</a>
                        <a href="#" class="nav-tab text-gray-600 hover:text-gray-900 font-medium pb-4 border-b-2 border-transparent hover:border-gray-300 transition-all duration-200">Calendar</a>
                    </nav>
                </div>
                
                <!-- Right side - User Profile -->
                <div class="flex items-center space-x-4">
                    <!-- Back to Tasks Button -->
                    <a href="{{ route('tasks.index') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class="fas fa-arrow-left text-sm"></i>
                        <span class="text-sm font-medium">Kembali ke Tasks</span>
                    </a>
                    
                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-all duration-200">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-semibold">S</span>
                            </div>
                            <span class="text-gray-700 font-medium text-sm">Septiani Dwi Pratiwi</span>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="min-h-screen" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="glass-effect rounded-2xl shadow-2xl p-8 mb-8">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-plus text-white text-2xl"></i>
                </div>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Tambah Tugas Baru</h2>
                <p class="text-gray-600 text-lg">Buat tugas baru dan atur prioritasnya dengan mudah</p>
            </div>

            <!-- Error Messages -->
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

            <!-- Form -->
            <form action="{{ route('tasks.store') }}" method="POST" id="task-form" class="space-y-8">
                @csrf
                
                <!-- Title -->
                <div class="form-group">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-heading text-purple-500 mr-2"></i>
                        Judul Tugas <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               class="form-input input-focus"
                               placeholder="Masukkan judul tugas yang menarik..."
                               required>
                        <i class="fas fa-edit input-icon"></i>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-align-left text-purple-500 mr-2"></i>
                        Deskripsi
                    </label>
                    <div class="relative">
                        <textarea id="description" 
                                  name="description" 
                                  rows="5"
                                  class="form-input input-focus resize-none"
                                  style="padding-left: 3rem; padding-top: 1rem;"
                                  placeholder="Jelaskan detail tugas dengan lengkap (opsional)...">{{ old('description') }}</textarea>
                        <i class="fas fa-file-alt input-icon"></i>
                    </div>
                </div>

                <!-- Deadline -->
                <div class="form-group">
                    <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>
                        Tenggat Waktu
                    </label>
                    <div class="relative">
                        <input type="date" 
                               id="deadline" 
                               name="deadline" 
                               value="{{ old('deadline') }}"
                               min="{{ date('Y-m-d') }}"
                               class="form-input input-focus">
                        <i class="fas fa-clock input-icon"></i>
                    </div>
                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                        Atur tenggat waktu untuk prioritas otomatis
                    </p>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-flag text-purple-500 mr-2"></i>
                        Status Awal
                    </label>
                    <div class="relative">
                        <select id="status" 
                                name="status"
                                class="form-input input-focus appearance-none">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>📝 Draft</option>
                            <option value="todo" {{ old('status') === 'todo' ? 'selected' : '' }}>📋 To Do</option>
                            <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>⚡ Sedang Dikerjakan</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        <i class="fas fa-tasks input-icon"></i>
                    </div>
                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-lightbulb mr-2 text-yellow-400"></i>
                        Pilih status awal untuk tugas ini
                    </p>
                </div>

                <!-- Priority Preview -->
                <div id="priority-preview" class="priority-card p-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl border-2 border-blue-200 hidden">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-star text-white"></i>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-800 mb-1">Preview Prioritas</p>
                            <p id="priority-text" class="text-base"></p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between pt-8 border-t-2 border-gray-100 space-y-4 sm:space-y-0">
                    <a href="{{ route('tasks.index') }}" 
                       class="flex items-center space-x-2 px-6 py-3 text-gray-600 hover:text-gray-800 font-medium rounded-xl transition-all duration-300 hover:bg-gray-100">
                        <i class="fas fa-times"></i>
                        <span>Batal</span>
                    </a>
                    
                    <div class="flex space-x-4">
                        <button type="button" 
                                onclick="saveDraft()"
                                class="btn-secondary px-8 py-4 text-white rounded-xl font-semibold flex items-center space-x-2 shadow-lg">
                            <i class="fas fa-save"></i>
                            <span>Simpan Draft</span>
                        </button>
                        
                        <button type="submit" 
                                class="btn-primary px-8 py-4 text-white rounded-xl font-semibold flex items-center space-x-2 shadow-lg">
                            <i class="fas fa-plus"></i>
                            <span>Buat Tugas</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tips Card -->
        <div class="tips-card rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb text-white text-lg"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-800 mb-4">💡 Tips & Trik</h4>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <p class="text-gray-700">Tugas dengan tenggat waktu akan diprioritaskan secara otomatis</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <p class="text-gray-700">Gunakan status "Draft" untuk ide atau rencana tugas</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <p class="text-gray-700">Deskripsi yang jelas membantu saat mengerjakan tugas</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <p class="text-gray-700">Anda bisa mengubah status tugas kapan saja dengan drag & drop</p>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-white bg-opacity-50 rounded-xl">
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-keyboard mr-2 text-blue-500"></i>
                            <strong>Shortcut:</strong> Ctrl+S untuk simpan draft, Ctrl+Enter untuk submit
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script>
        // Priority calculation preview
        function calculatePriorityPreview() {
            const deadlineInput = document.getElementById('deadline');
            const previewDiv = document.getElementById('priority-preview');
            const previewText = document.getElementById('priority-text');
            
            if (!deadlineInput.value) {
                previewDiv.classList.add('hidden');
                return;
            }

            const deadline = new Date(deadlineInput.value);
            const today = new Date();
            const diffTime = deadline - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            let priorityLevel = '';
            let priorityClass = '';
            let priorityIcon = '';

            if (diffDays <= 0) {
                priorityLevel = '🔥 Sangat Mendesak - Hari ini atau terlambat!';
                priorityClass = 'text-red-600 font-bold';
                priorityIcon = 'fas fa-exclamation-triangle';
            } else if (diffDays <= 1) {
                priorityLevel = '⚡ Mendesak - Besok tenggat waktu';
                priorityClass = 'text-orange-600 font-semibold';
                priorityIcon = 'fas fa-clock';
            } else if (diffDays <= 3) {
                priorityLevel = '⭐ Prioritas Tinggi - 3 hari lagi';
                priorityClass = 'text-yellow-600 font-semibold';
                priorityIcon = 'fas fa-star';
            } else if (diffDays <= 7) {
                priorityLevel = '📅 Prioritas Sedang - Seminggu lagi';
                priorityClass = 'text-blue-600 font-medium';
                priorityIcon = 'fas fa-calendar';
            } else {
                priorityLevel = '😌 Prioritas Normal - Masih ada waktu';
                priorityClass = 'text-green-600 font-medium';
                priorityIcon = 'fas fa-leaf';
            }

            previewText.innerHTML = `<span class="${priorityClass}">${priorityLevel}</span>`;
            previewDiv.classList.remove('hidden');
        }

        // Save as draft function
        function saveDraft() {
            const statusSelect = document.getElementById('status');
            statusSelect.value = 'draft';
            document.getElementById('task-form').submit();
        }

        // Form validation
        function validateForm() {
            const title = document.getElementById('title').value.trim();
            
            if (!title) {
                // Create custom alert
                showCustomAlert('⚠️ Judul tugas harus diisi!', 'error');
                return false;
            }

            return true;
        }

        // Custom alert function
        function showCustomAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full`;
            
            if (type === 'error') {
                alertDiv.classList.add('bg-red-500', 'text-white');
            } else {
                alertDiv.classList.add('bg-blue-500', 'text-white');
            }
            
            alertDiv.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(alertDiv);
            
            // Animate in
            setTimeout(() => {
                alertDiv.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                alertDiv.classList.add('translate-x-full');
                setTimeout(() => alertDiv.remove(), 300);
            }, 5000);
        }

        // Loading state for buttons
        function setButtonLoading(button, loading = true) {
            if (loading) {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            } else {
                button.disabled = false;
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const deadlineInput = document.getElementById('deadline');
            const form = document.getElementById('task-form');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Calculate priority preview when deadline changes
            deadlineInput.addEventListener('change', calculatePriorityPreview);

            // Form submit validation
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                } else {
                    setButtonLoading(submitBtn, true);
                }
            });

            // Auto-focus on title input with slight delay for better UX
            setTimeout(() => {
                document.getElementById('title').focus();
            }, 500);

            // Add floating labels effect
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save as draft
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                showCustomAlert('💾 Menyimpan sebagai draft...', 'info');
                saveDraft();
            }
            
            // Ctrl/Cmd + Enter to submit form
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                if (validateForm()) {
                    showCustomAlert('🚀 Membuat tugas...', 'info');
                    document.getElementById('task-form').submit();
                }
            }
        });

        // Add smooth scrolling to form validation errors
        function scrollToError() {
            const errorElement = document.querySelector('.bg-red-50');
            if (errorElement) {
                errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there are errors and scroll to them
            if (document.querySelector('.bg-red-50')) {
                setTimeout(scrollToError, 500);
            }
        });
    </script>
</body>
</html>