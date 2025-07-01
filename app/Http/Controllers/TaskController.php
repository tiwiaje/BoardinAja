<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Validation\Rule;
use App\Notifications\PriorityAdjusted;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\UpdateTaskRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ✅ Menyesuaikan prioritas otomatis sebelum mengambil tugas
        $this->autoAdjustPriorities();

        $tasks = Task::where('user_id', auth()->id())
            ->orderedByPriority()
            ->orderBy('deadline')
            ->get();

        $todoTasks = $tasks->where('status', Task::STATUS_TODO);
        $inProgressTasks = $tasks->where('status', Task::STATUS_IN_PROGRESS);
        $completedTasks = $tasks->where('status', Task::STATUS_DONE);

        $suggestedTasks = Task::where('user_id', auth()->id())
            ->where('status', '!=', Task::STATUS_DONE)
            ->get();

        // Hitung suggested_priority
        $suggestedTasks->each(function ($task) {
            $task->suggested_priority = $this->calculatePriorityScore($task->priority, $task->deadline);
        });

        // Urutkan dan ambil 3 teratas
        $suggestedTasks = $suggestedTasks->sortByDesc('suggested_priority')->take(3);
        \Log::info('Saran Prioritas:', $suggestedTasks->pluck('title')->toArray());


        return view('tasks.index', compact('todoTasks', 'inProgressTasks', 'completedTasks', 'suggestedTasks'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $status = $request->get('status', 'todo'); // default 'todo' kalau kosong
        return view('tasks.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|string',
            'category' => 'nullable|string',
        ]);

        // Hitung skor prioritas
        $validated['priority_score'] = $this->calculatePriorityScore(
            $validated['priority'],
            $validated['deadline']
        );

        // Tambah user_id
        $validated['user_id'] = auth()->id();

        $task = Task::create($validated);
        //dd($task); // pastikan tersimpan


        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }



    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:normal,high,urgent',
            // 'status' => 'required|in:todo,in_progress,done', // dihapus karena tidak ada di form
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }



    /**
     * Calculate priority score based on priority level and deadline
     */
    private function calculatePriorityScore($priority, $deadline)
    {
        $score = match ($priority) {
            'urgent' => 100,
            'high' => 70,
            'normal' => 50,
            default => 0,
        };

        if ($deadline) {
            $daysLeft = now()->diffInDays(Carbon::parse($deadline), false);

            // Add urgency based on days left
            if ($daysLeft <= 0) {
                $score += 50; // Overdue tasks get highest priority
            } elseif ($daysLeft <= 1) {
                $score += 40; // Due today/tomorrow
            } elseif ($daysLeft <= 3) {
                $score += 30; // Due within 3 days
            } elseif ($daysLeft <= 7) {
                $score += 20; // Due within a week
            } else {
                $score += max(0, 15 - ($daysLeft / 7)); // Gradually decrease
            }
        }

        return $score;
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Ensure user can only view their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // Ensure user can only edit their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Ensure user can only delete their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        try {
            $task->delete();

            return redirect()->route('tasks.index')
                ->with('success', 'Tugas berhasil dihapus!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus tugas. Silakan coba lagi.');
        }
    }

    /**
     * Update task status via AJAX (for drag and drop)
     */
    public function updateStatus(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            \Log::warning('Update status gagal: task bukan milik user', ['task_id' => $task->id, 'user_id' => auth()->id()]);
            return response()->json(['success' => false, 'message' => 'Task tidak ditemukan atau bukan milik Anda.'], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done'
        ]);

        // ⛔ Cegah perubahan dari done ke status lain
        if ($task->status === 'done' && $validated['status'] !== 'done') {
            \Log::info('Cegah perubahan status dari done ke lain', ['task_id' => $task->id]);
            return response()->json([
                'success' => false,
                'message' => 'Tugas yang sudah selesai tidak bisa dikembalikan ke status sebelumnya.'
            ], 422);
        }

        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === 'done') {
            $updateData['completed_at'] = now();
        } else {
            $updateData['completed_at'] = null;
        }

        \Log::info('Update status task', ['task_id' => $task->id, 'from' => $task->status, 'to' => $validated['status']]);
        $task->update($updateData);
        \Log::info('Status task setelah update', ['task_id' => $task->id, 'status' => $task->status, 'completed_at' => $task->completed_at]);

        return response()->json([
            'success' => true,
            'message' => 'Status tugas berhasil diperbarui!',
            'task' => $task->fresh()
        ]);
    }


    /**
     * Get tasks data for dashboard/statistics
     */


    public function dashboard(Request $request)
    {
        $period = $request->input('period', 'weekly');
        $startDate = $period === 'weekly' ? now()->subWeek() : now()->subMonth();

        $completedTasks = Task::where('status', 'done')
            ->where('user_id', auth()->id())
            ->whereNotNull('completed_at')
            ->whereDate('completed_at', '>=', $startDate)
            ->get();

        $tasksPerDay = Task::selectRaw('DATE(completed_at) as date, COUNT(*) as count')
            ->where('status', 'done')
            ->whereNotNull('completed_at')
            ->whereDate('completed_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('dashboard', compact('completedTasks', 'tasksPerDay'));
    }

    public function getDashboardData()
    {
        $userId = auth()->id();

        $tasks = Task::where('user_id', $userId)->get();

        $data = [
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('status', 'done')->count(),
            'pending_tasks' => $tasks->where('status', '!=', 'done')->count(),
            'overdue_tasks' => $tasks->where('deadline', '<', now())->where('status', '!=', 'done')->count(),
            'high_priority_tasks' => $tasks->where('priority', 'urgent')->where('status', '!=', 'done')->count(),
        ];

        return response()->json($data);
    }

    /**
     * Mark task as completed
     */
    public function markAsCompleted(Task $task)
    {
        // Cek otorisasi akses tugas
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        try {
            // Update status tugas
            $task->update([
                'status' => 'done',
                'completed_at' => now(),
            ]);

            // Berhasil
            return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditandai selesai!');
        } catch (\Exception $e) {
            // Gagal
            return back()->with('error', 'Gagal menandai tugas sebagai selesai.');
        }
    }


    /**
     * Get tasks by category
     */
    public function getByCategory(Request $request)
    {
        $category = $request->get('category');

        $tasks = Task::where('user_id', auth()->id())
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->orderByDesc('priority_score')
            ->orderBy('deadline')
            ->get();

        return response()->json($tasks);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_TODO => 'To Do',
            self::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
            self::STATUS_DONE => 'Selesai'
        ];
    }

    public function updatePriority(Task $task)
    {
        // Kalkulasi skor prioritas berdasarkan deadline
        $newScore = $this->calculatePriority($task);

        // Perbarui prioritas tugas dan simpan
        $task->priority_score = $newScore;
        $task->save();

        // Urutkan tugas berdasarkan deadline dan prioritas
        $this->autoSortTasks();

        // Kirim notifikasi jika prioritas berubah
        if ($newScore !== $task->priority_score) {
            $task->user->notify(new PriorityAdjusted($task));
        }

        return redirect()->route('tasks.index');
    }

    public function suggestTaskPriorities()
    {
        $tasks = Task::where('user_id', auth()->id())->whereNull('completed_at')->get();

        // Logika kalkulasi prioritas atau sorting tugas
        $tasks->each(function ($task) {
            $task->suggested_priority = $this->calculatePriority($task);
        });

        $sortedTasks = $tasks->sortByDesc('suggested_priority');

        // Kirim data tugas yang sudah diurutkan ke view
        return view('tasks.suggested_priorities', ['sortedTasks' => $sortedTasks]);
    }

    public function autoAdjustPriorities()
    {
        $tasks = Task::where('status', '!=', 'done')->get();

        foreach ($tasks as $task) {
            if (
                $task->deadline &&
                $task->priority !== 'urgent' && // ✅ jangan ubah jika sudah urgent
                $task->priority !== 'high' &&
                $task->deadline->isToday()
            ) {
                $task->priority = 'high';
                $task->save();

                $task->user->notify(new PriorityAdjusted($task));
            }
        }
    }

    public function calendar()
    {
        return view('tasks.calendar');
    }

    public function calendarEvents(Request $request)
    {
        $tasks = Task::where('user_id', auth()->id())
            ->whereNotNull('deadline')
            ->get(); // pastikan tidak menggunakan cache manual

        $events = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'start' => $task->deadline->toDateString(),
                'end' => $task->deadline->toDateString(),
                'color' => match ($task->priority) {
                    'urgent' => '#ef4444',
                    'high' => '#f97316',
                    'normal' => '#10b981',
                    default => '#6b7280',
                },
                'url' => route('tasks.show', $task->id),
                'allDay' => true,
            ];
        });

        return response()->json($events);
    }



    public function complete($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        $task->update([
            'status' => 'done',
            'completed_at' => now(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diselesaikan!');
    }

    public function downloadPdf()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        $pdf = Pdf::loadView('reports.tasks_pdf', compact('tasks'));
        return $pdf->download('laporan_tugas.pdf');
    }
}
