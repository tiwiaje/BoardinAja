<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // ✅ Diperlukan
use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
{
     $userId = auth()->id();

    $countTodo = DB::table('tasks')
        ->where('user_id', $userId)
        ->where('status', 'todo')
        ->whereNull('completed_at') // ✅ Tambahkan ini
        ->count();

    $countInProgress = DB::table('tasks')
        ->where('user_id', $userId)
        ->where('status', 'in_progress')
        ->whereNull('completed_at') // ✅ Tambahkan ini juga
        ->count();

    $countDone = DB::table('tasks')
        ->where('user_id', $userId)
        ->where('status', 'done')
        ->whereNotNull('completed_at')
        ->count();


    // Format label & data agar lengkap 7 hari terakhir
    $chartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i)->toDateString();
        $chartData[] = [
            'date' => Carbon::parse($date)->translatedFormat('D, d M'),
            'count' => $completedTasksPerDay[$date]->count ?? 0,
        ];
    }

    return view('dashboard', compact('countTodo', 'countInProgress', 'countDone', 'chartData'));
}
public function index(Request $request)
{
    $userId = auth()->id(); // ✅

$query = Task::where('user_id', $userId)->where('status', 'done'); // ✅
    $period = $request->input('period', 'week'); // Default ke 'week' jika tidak ada input


    // Filter berdasarkan periode waktu
    if ($period === 'today') {
        $query->whereDate('completed_at', now()->toDateString()); // Hari ini
    } elseif ($period === 'week') {
        $query->whereBetween('completed_at', [
            now()->startOfWeek()->toDateString(),
            now()->endOfWeek()->toDateString(),
        ]); // Minggu ini
    } elseif ($period === 'month') {
        $query->whereMonth('completed_at', now()->month) // Bulan ini
            ->whereYear('completed_at', now()->year);
    }

    // Ambil data tugas yang selesai
    $tasks = $query->get();

    // Hitung jumlah tugas selesai per status
    $countTodo = Task::where('user_id', $userId)
    ->where('status', 'todo')
    ->whereNull('completed_at') // ✅
    ->count();

$countInProgress = Task::where('user_id', $userId)
    ->where('status', 'in_progress')
    ->whereNull('completed_at') // ✅
    ->count();

    $countDone = $tasks->count(); // Menggunakan hasil filter tugas selesai

    // Ambil data untuk grafik berdasarkan periode waktu yang dipilih
    $chartData = Task::selectRaw('DATE(completed_at) as date, count(*) as count')
        ->where('status', 'done')
        ->whereBetween('completed_at', [
            now()->startOfWeek()->toDateString(),
            now()->endOfWeek()->toDateString(),
        ])
        ->groupBy('date')
        ->get();

    // Jika periode adalah hari ini, sesuaikan query untuk menampilkan grafik sesuai dengan tanggal hari ini
    if ($period === 'today') {
        $chartData = Task::selectRaw('HOUR(completed_at) as hour, count(*) as count')
            ->where('status', 'done')
            ->whereDate('completed_at', now()->toDateString())
            ->groupBy('hour')
            ->get();
    }

    // Kirim data ke view
    return view('dashboard', compact('countTodo', 'countInProgress', 'countDone', 'chartData'));
}

public function getChartData(Request $request)
{

    $userId = auth()->id();

$query = Task::where('user_id', $userId)->where('status', 'done');

    $period = $request->input('period', 'week'); // Default ke 'week' jika tidak ada input

    // Filter berdasarkan periode waktu
    if ($period === 'today') {
        $query->whereDate('completed_at', now()->toDateString()); // Hari ini
    } elseif ($period === 'week') {
        $query->whereBetween('completed_at', [
            now()->startOfWeek()->toDateString(),
            now()->endOfWeek()->toDateString(),
        ]); // Minggu ini
    } elseif ($period === 'month') {
        $query->whereMonth('completed_at', now()->month) // Bulan ini
            ->whereYear('completed_at', now()->year);
    }

    // Ambil data untuk grafik berdasarkan periode waktu yang dipilih
    $chartData = $query->selectRaw('DATE(completed_at) as date, count(*) as count')
        ->groupBy('date')
        ->get();

    // Format data untuk dikirim ke frontend
    $data = $chartData->map(function ($item) {
        return [
            'date' => $item->date,
            'count' => $item->count,
        ];
    });

    return response()->json($data); // Mengirim data dalam format JSON
}

private function getDateRange($period)
{
    switch ($period) {
        case 'today':
            $start = now()->startOfDay();
            $end = now()->endOfDay();
            break;
        case 'month':
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
            break;
        case 'week':
        default:
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
            break;
    }

    return [$start, $end];
}


public function statusChartData(Request $request)
{
    $period = $request->get('period', 'week');

    [$start, $end] = $this->getDateRange($period);
    $userId = auth()->id();

    $dates = [];
    $todoCounts = [];
    $inProgressCounts = [];
    $doneCounts = [];

    $currentDate = $start->copy();
    $taskCounts = [];

    while ($currentDate->lte($end)) {
        $countTodo = Task::where('user_id', $userId)->whereDate('created_at', '<=', $currentDate)->where(function($q) use ($currentDate) {
            $q->whereNull('completed_at')->orWhereDate('completed_at', '>', $currentDate);
        })->where('status', 'todo')->count();

        $countInProgress = Task::where('user_id', $userId)->whereDate('created_at', '<=', $currentDate)->where(function($q) use ($currentDate) {
            $q->whereNull('completed_at')->orWhereDate('completed_at', '>', $currentDate);
        })->where('status', 'in_progress')->count();

        $countDone = Task::where('user_id', $userId)->where('status', 'done')->whereDate('completed_at', $currentDate)->count();

        $dates[] = $currentDate->format('d M');
        $todoCounts[] = $countTodo;
        $inProgressCounts[] = $countInProgress;
        $doneCounts[] = $countDone;

        $taskCounts[] = $countTodo + $countInProgress + $countDone;

        $currentDate->addDay();
    }

    // Hitung garis ideal burndown (dari jumlah tugas terbanyak)
    $maxTasks = count($taskCounts) > 0 ? max($taskCounts) : 0;

$idealLine = [];
$days = count($dates);
for ($i = 0; $i < $days; $i++) {
    if ($days <= 1 || $maxTasks === 0) {
        $idealLine[] = 0;
    } else {
        $idealLine[] = round($maxTasks - ($i * ($maxTasks / ($days - 1))), 2);
    }
}


    return response()->json([
        'dates' => $dates,
        'todo' => $todoCounts,
        'in_progress' => $inProgressCounts,
        'done' => $doneCounts,
        'ideal' => $idealLine,
    ]);
}


public function burndownChartData(Request $request)
{
    $user = auth()->user();
    $period = $request->input('period', 'week');

    // Tentukan rentang tanggal
    $startDate = match ($period) {
        'today' => now()->startOfDay(),
        'month' => now()->startOfMonth(),
        default => now()->startOfWeek(), // default: minggu ini
    };
    $endDate = now()->endOfDay();

    $dates = collect();
    $remainingTasks = collect();
    $currentDate = $startDate->copy();
    $totalTasks = \App\Models\Task::where('user_id', $user->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

    while ($currentDate->lte($endDate)) {
        $done = \App\Models\Task::where('user_id', $user->id)
                ->where('status', 'done')
                ->whereDate('completed_at', '<=', $currentDate)
                ->count();

        $remaining = max($totalTasks - $done, 0);

        $dates->push($currentDate->format('Y-m-d'));
        $remainingTasks->push($remaining);

        $currentDate->addDay();
    }

    return response()->json([
        'dates' => $dates,
        'remaining' => $remainingTasks,
        'ideal' => $dates->map(fn($date, $index) => max($totalTasks - ($totalTasks / max(count($dates) - 1, 1)) * $index, 0)),
    ]);
}


}
