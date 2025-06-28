<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Boardin Aja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        .gradient-text {
            background: linear-gradient(to right, #fbb6ce, #c084fc, #67e8f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

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

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px) scale(1.05);
        }

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
    </style>
</head>

<body>
    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-indigo-700 to-blue-800 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full opacity-20 animate-blob filter blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full opacity-20 animate-blob animation-delay-2000 filter blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-full opacity-20 animate-blob animation-delay-4000 filter blur-3xl"></div>
        </div>

        <!-- Header dengan Back Button -->
        <nav class="relative z-10 w-full px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-bold text-white">Boardin Aja</span>
                </div>
                <a href="{{ route('login') }}" class="glass-form hover:bg-white/20 text-white font-semibold px-6 py-2.5 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 flex items-center space-x-2 btn-hover">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali ke Login</span>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-100px)] p-6">
            <div class="w-full max-w-md mx-auto glass-form rounded-3xl shadow-2xl p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Daftar ke <span class="gradient-text">Boardin Aja</span></h2>
                    <p class="text-purple-200 mt-2">Buat akun baru untuk mulai mengorganisir tugas</p>
                </div>

                <!-- Manual Register Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm text-white mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" 
                            class="w-full px-4 py-3 rounded-xl glass-input"
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('name') }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm text-white mb-1">Email</label>
                        <input type="email" name="email" id="email" 
                            class="w-full px-4 py-3 rounded-xl glass-input"
                            placeholder="masukkan email anda"
                            value="{{ old('email') }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm text-white mb-1">Password</label>
                        <input type="password" name="password" id="password" 
                            class="w-full px-4 py-3 rounded-xl glass-input"
                            placeholder="masukkan password"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm text-white mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="w-full px-4 py-3 rounded-xl glass-input"
                            placeholder="ulangi password"
                            required>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl btn-hover">
                        🚀 Daftar Sekarang
                    </button>
                </form>

                <!-- Footer Links -->
                <div class="mt-6 text-center text-sm text-purple-200">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-white font-bold hover:underline">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
