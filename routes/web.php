<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root ke tasks
Route::get('/', fn () => redirect()->route('tasks.index'));

// Login routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Google Auth
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Register routes - SIMPLIFIED
Route::get('/register', function () {
    return view('auth.register-fallback');
})->name('register')->middleware('guest');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', 'min:8'],
    ], [
        'name.required' => 'Nama harus diisi.',
        'email.required' => 'Email harus diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.required' => 'Password harus diisi.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'password.min' => 'Password minimal 8 karakter.',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'email_verified_at' => now(),
    ]);

    Auth::login($user);

    return redirect('/dashboard')->with('success', 'Akun berhasil dibuat!');
})->middleware('guest');

// Dashboard (hanya satu, method index, dengan auth)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Group route yang butuh auth & verified
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData']);
    Route::get('/dashboard/status-chart-data', [DashboardController::class, 'statusChartData'])->name('dashboard.chart-data');
    Route::get('/burndown-chart-data', [DashboardController::class, 'burndownChartData']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Task khusus
    Route::patch('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::post('/tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::get('/tasks/suggested-priorities', [TaskController::class, 'suggestTaskPriorities'])->name('tasks.suggestedPriorities');
    Route::get('/tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');
    Route::get('/notifications', [TaskController::class, 'showNotifications'])->name('notifications.index');
    Route::get('/calendar', [TaskController::class, 'calendar'])->name('calendar.view');
    Route::get('/calendar/events', [TaskController::class, 'calendarEvents'])->name('calendar.events');
    Route::get('/tasks/report/download', [TaskController::class, 'downloadReport'])->name('tasks.downloadReport');

    // Resource: tasks
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';
