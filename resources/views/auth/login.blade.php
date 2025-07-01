<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Boardin Aja - Kelola Tugas, Capai Lebih Banyak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .animate-blob { animation: blob 7s infinite; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        .animation-delay-1000 { animation-delay: 1s; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-3000 { animation-delay: 3s; }
        .animation-delay-4000 { animation-delay: 4s; }

        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { 
            background: rgba(255, 255, 255, 0.1); 
            border-radius: 10px; 
        }
        ::-webkit-scrollbar-thumb { 
            background: rgba(255, 255, 255, 0.3); 
            border-radius: 10px; 
        }
        ::-webkit-scrollbar-thumb:hover { 
            background: rgba(255, 255, 255, 0.5); 
        }

        /* Custom gradient text */
        .gradient-text {
            background: linear-gradient(to right, #fbb6ce, #c084fc, #67e8f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Input styling */
        .glass-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
        }

        .glass-input::placeholder {
            color: rgba(196, 181, 253, 0.7);
        }

        .glass-input:focus {
            outline: none;
            border-color: rgba(236, 72, 153, 0.6);
            box-shadow: 0 0 0 2px rgba(236, 72, 153, 0.2);
        }

        /* Button hover effects */
        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px) scale(1.05);
        }

        /* Alert styling */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        /* Loading spinner */
        .spinner {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 2px solid #ffffff;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <div id="main-container" class="min-h-screen bg-gradient-to-br from-purple-600 via-indigo-700 to-blue-800 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full opacity-20 animate-blob filter blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full opacity-20 animate-blob animation-delay-2000 filter blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-full opacity-20 animate-blob animation-delay-4000 filter blur-3xl"></div>
            <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-r from-pink-300 to-red-300 rounded-full opacity-15 animate-float filter blur-2xl"></div>
            <div class="absolute bottom-20 right-20 w-48 h-48 bg-gradient-to-r from-cyan-300 to-blue-300 rounded-full opacity-15 animate-float animation-delay-3000 filter blur-2xl"></div>
        </div>

        <!-- Animated particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white rounded-full opacity-40 animate-pulse"></div>
            <div class="absolute top-3/4 left-3/4 w-1 h-1 bg-pink-300 rounded-full opacity-60 animate-pulse animation-delay-1000"></div>
            <div class="absolute top-1/3 right-1/4 w-1.5 h-1.5 bg-cyan-300 rounded-full opacity-50 animate-pulse animation-delay-2000"></div>
        </div>

        <!-- Header dengan Login Button -->
        <nav class="relative z-10 w-full px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/new.png') }}" alt="Boardin Aja Logo" class="h-9 w-auto">
                    <span class="text-2xl font-bold text-white">Boardin Aja</span>
                </div>
                <button id="login-btn" class="z-50 glass hover:bg-white/20 text-white font-semibold px-6 py-2.5 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 flex items-center space-x-2 btn-hover">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Masuk</span>
                </button>
            </div>
        </nav>

        <!-- Main Content Container -->
        <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-100px)] p-6">
            <!-- Landing Page Content -->
            <div id="landing-content" class="text-center max-w-4xl mx-auto space-y-8 {{ $errors->any() || session('error') ? 'hidden' : '' }}">
                <!-- Hero Logo -->
                <div class="relative">
                    <div class="w-32 h-32 mx-auto bg-gradient-to-br from-purple-600 to-indigo-600 rounded-3xl shadow-2xl flex items-center justify-center mb-8 transform hover:scale-105 transition-all duration-300">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <!-- Floating elements -->
                    <div class="absolute -top-4 -right-4 w-6 h-6 bg-yellow-400 rounded-full animate-bounce animation-delay-1000"></div>
                    <div class="absolute -bottom-2 -left-6 w-4 h-4 bg-pink-400 rounded-full animate-bounce animation-delay-2000"></div>
                </div>

                <!-- Hero Text -->
                <div class="space-y-6">
                    <h1 class="text-5xl md:text-6xl font-black text-white leading-tight">
                        Kelola Tugas,<br>
                        <span class="gradient-text">Capai Lebih Banyak</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-purple-100 max-w-2xl mx-auto leading-relaxed">
                        Boardin Aja membantu Anda mengorganisir tugas, meningkatkan produktivitas, dan mencapai tujuan tanpa stres.
                    </p>
                </div>

                <!-- Feature Cards -->
                <div class="grid md:grid-cols-3 gap-6 mt-12 max-w-3xl mx-auto">
                    <div class="glass rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:bg-white/15">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Organisasi Mudah</h3>
                        <p class="text-sm text-purple-200">Atur tugas dengan sistem prioritas yang intuitif</p>
                    </div>

                    <div class="glass rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:bg-white/15">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Produktivitas Tinggi</h3>
                        <p class="text-sm text-purple-200">Fokus pada yang penting, capai lebih banyak</p>
                    </div>

                    <div class="glass rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 hover:bg-white/15">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Bebas Stres</h3>
                        <p class="text-sm text-purple-200">Nikmati keseimbangan hidup yang lebih baik</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="pt-8">
                    <button id="cta-btn" class="bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-bold px-12 py-4 rounded-full text-lg transition-all duration-300 shadow-2xl hover:shadow-purple-500/25 btn-hover flex items-center space-x-3 mx-auto">
                        <span>🚀 Mulai Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Login Modal/Form -->
            <div id="login-form" class="w-full max-w-md mx-auto glass-form rounded-3xl shadow-2xl p-8 transition-all duration-300 {{ $errors->any() || session('error') ? '' : 'hidden' }}">
                <!-- Close Button -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Masuk ke <span class="gradient-text">Boardin Aja</span></h2>
                    <button id="close-btn" class="text-gray-300 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Alert Messages -->
                <div id="alert-container">
                    @if ($errors->any())
                        <div class="alert alert-error">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <!-- Google Login -->
                <a href="{{ route('auth.google') ?? '/auth/google/redirect' }}" 
                    class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-xl border border-gray-200 flex items-center justify-center space-x-3 transition-all duration-300 shadow-md hover:shadow-lg btn-hover mb-4">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Masuk dengan Google</span>
                </a>

                <!-- Footer Links -->
                <div class="mt-6 text-center text-sm text-purple-200">
                    <a href="{{ route('register') }}" class="hover:text-white transition-colors font-bold underline">Daftar akun baru</a>
                    <div class="mt-2 text-xs text-purple-100">Belum punya akun? Daftar dengan email baru atau Google baru.</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Utility functions
        function showAlert(message, type = 'error') {
            const alertContainer = document.getElementById('alert-container');
            if (!alertContainer) return;
            
            const alertClass = type === 'error' ? 'alert-error' : 'alert-success';
            const alertHTML = `<div class="alert ${alertClass}">${message}</div>`;
            
            alertContainer.innerHTML = alertHTML;
            
            // Auto remove alert after 5 seconds
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }

        function showLogin() {
            const landingContent = document.getElementById('landing-content');
            const loginForm = document.getElementById('login-form');
            
            if (landingContent && loginForm) {
                landingContent.classList.add('hidden');
                loginForm.classList.remove('hidden');
                
                // Focus on email input
                setTimeout(() => {
                    const emailInput = document.getElementById('email');
                    if (emailInput) emailInput.focus();
                }, 100);
            }
        }

        function hideLogin() {
            const landingContent = document.getElementById('landing-content');
            const loginForm = document.getElementById('login-form');
            
            if (landingContent && loginForm) {
                loginForm.classList.add('hidden');
                landingContent.classList.remove('hidden');
                
                // Clear any dynamic alerts
                const alertContainer = document.getElementById('alert-container');
                if (alertContainer) {
                    const dynamicAlerts = alertContainer.querySelectorAll('.alert:not([data-server])');
                    dynamicAlerts.forEach(alert => alert.remove());
                }
            }
        }

        function setLoading(isLoading) {
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitSpinner = document.getElementById('submit-spinner');
            
            if (submitBtn && submitText && submitSpinner) {
                if (isLoading) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    submitText.textContent = 'Sedang masuk...';
                    submitSpinner.classList.remove('hidden');
                } else {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitText.textContent = 'Masuk ke Boardin Aja';
                    submitSpinner.classList.add('hidden');
                }
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const loginBtn = document.getElementById('login-btn');
            const ctaBtn = document.getElementById('cta-btn');
            const closeBtn = document.getElementById('close-btn');
            const manualLoginForm = document.getElementById('manual-login-form');

            // Show login form
            if (loginBtn) {
                loginBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showLogin();
                });
            }

            if (ctaBtn) {
                ctaBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showLogin();
                });
            }

            // Hide login form
            if (closeBtn) {
                closeBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    hideLogin();
                });
            }

            // Handle form submission
            if (manualLoginForm) {
                manualLoginForm.addEventListener('submit', function(e) {
                    setLoading(true);
                    
                    // Basic client-side validation
                    const email = document.getElementById('email').value.trim();
                    const password = document.getElementById('password').value;
                    
                    if (!email || !password) {
                        e.preventDefault();
                        setLoading(false);
                        showAlert('Email dan password harus diisi!', 'error');
                        return;
                    }
                    
                    if (!email.includes('@') || !email.includes('.')) {
                        e.preventDefault();
                        setLoading(false);
                        showAlert('Format email tidak valid!', 'error');
                        return;
                    }
                    
                    // Form will submit normally to Laravel
                    // Loading state will be reset by page reload or redirect
                });
            }

            // Handle keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const loginForm = document.getElementById('login-form');
                    if (loginForm && !loginForm.classList.contains('hidden')) {
                        hideLogin();
                    }
                }
            });

            // Mark server-side alerts
            const serverAlerts = document.querySelectorAll('#alert-container .alert');
            serverAlerts.forEach(alert => {
                alert.setAttribute('data-server', 'true');
            });
        });
    </script>
</body>
</html>
