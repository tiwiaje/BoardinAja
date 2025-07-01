@extends('layouts.app')

@section('content')
<div x-data="{ showLogin: false }" class="max-w-md mx-auto mt-12 bg-white shadow-md rounded px-8 pt-6 pb-8 animate-fade-in">

    <!-- Selamat Datang -->
    <div x-show="!showLogin" class="text-center">
        <img src="{{ asset('images/new.png') }}" alt="Logo Priorify" class="w-20 mx-auto mb-4">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang di Priorify</h1>
        <p class="text-gray-600 mb-6">Aplikasi manajemen tugas harianmu yang cerdas dan terstruktur ✨</p>
        <button @click="showLogin = true"
            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
            Masuk ke Priorify
        </button>
    </div>

    <!-- Form Login -->
    <div x-show="showLogin" x-transition class="mt-4">
        <h2 class="text-2xl font-bold text-center mb-6">Masuk ke Priorify</h2>

        <!-- Tombol Google -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('google.redirect') }}"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21.35 11.1h-9.18v2.92h5.38c-.23 1.2-1.38 3.5-5.38 3.5a6.02 6.02 0 010-12c1.73 0 2.88.73 3.54 1.36l2.42-2.42C16.44 2.89 14.42 2 12 2a10 10 0 100 20c5.47 0 9.87-3.98 9.87-9.87 0-.66-.07-1.28-.17-1.89z" />
                </svg>
                Masuk dengan Google
            </a>
        </div>

        <div class="text-center text-gray-500 text-sm mb-4">atau login dengan email</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="form-input w-full">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required class="form-input w-full">
            </div>

            <button type="submit" class="btn-primary w-full">
                Masuk
            </button>
        </form>
    </div>
</div>
@endsection
