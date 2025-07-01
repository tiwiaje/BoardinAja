<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['Draft', 'To Do', 'In Progress', 'Done'];

        foreach (range(1, 12) as $i) {
            Task::create([
                'title' => "Contoh Tugas #$i",
                'status' => $statuses[array_rand($statuses)],
                'order' => $i,
                'priority_score' => rand(1, 10),
            ]);
        }
    }
}
