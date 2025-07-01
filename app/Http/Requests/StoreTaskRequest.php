<?php

// app/Http/Requests/StoreTaskRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    return [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => ['required', Rule::in([
            Task::STATUS_TODO,
            Task::STATUS_IN_PROGRESS,
            Task::STATUS_DONE
        ])],
        'priority' => ['required', Rule::in(Task::PRIORITIES)],
        'deadline' => 'nullable|date|after_or_equal:today',
        'category' => 'nullable|string|max:100',
    ];
}

}
