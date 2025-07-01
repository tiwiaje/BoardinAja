@extends('layouts.app')

@section('title', 'Profil Saya - Priorify')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-lg animate-fade-in">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">👤 Profil Saya</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ auth()->user()->name }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ auth()->user()->email }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru <small class="text-gray-400">(Opsional)</small></label>
            <input type="password" name="password" id="password"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali ke Dashboard</a>
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>

    <form action="{{ route('logout') }}" method="POST" class="mt-6 text-center">
        @csrf
        <button type="submit" class="text-red-600 hover:underline">🚪 Logout</button>
    </form>
</div>
@endsection
