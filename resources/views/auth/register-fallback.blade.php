<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Boardin Aja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-600 via-indigo-700 to-blue-800">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white">Daftar ke <span class="bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">Boardin Aja</span></h2>
                <p class="text-purple-200 mt-2">Buat akun baru untuk mulai mengorganisir tugas</p>
            </div>

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500/30 text-red-200 p-3 rounded-lg mb-4">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="bg-green-500/20 border border-green-500/30 text-green-200 p-3 rounded-lg mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Google Register -->
            <a href="{{ route('auth.google') }}" 
                class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-xl border border-gray-200 flex items-center justify-center space-x-3 transition-all duration-300 shadow-md hover:shadow-lg mb-4">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span>Daftar dengan Google</span>
            </a>

            <div class="flex items-center mb-6">
                <hr class="flex-grow border-white/30">
                <span class="px-4 text-sm text-purple-200">atau</span>
                <hr class="flex-grow border-white/30">
            </div>

            <!-- Manual Register Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm text-white mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" 
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/30 text-white placeholder-purple-200 focus:outline-none focus:border-pink-500"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}"
                        required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm text-white mb-1">Email</label>
                    <input type="email" name="email" id="email" 
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/30 text-white placeholder-purple-200 focus:outline-none focus:border-pink-500"
                        placeholder="masukkan email anda"
                        value="{{ old('email') }}"
                        required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm text-white mb-1">Password</label>
                    <input type="password" name="password" id="password" 
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/30 text-white placeholder-purple-200 focus:outline-none focus:border-pink-500"
                        placeholder="masukkan password"
                        required>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm text-white mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/30 text-white placeholder-purple-200 focus:outline-none focus:border-pink-500"
                        placeholder="ulangi password"
                        required>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
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
</body>
</html>
