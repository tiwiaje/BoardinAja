<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateTaskStatusTransition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $from, $to)
{
    $task = \App\Models\Task::findOrFail($request->route('id'));

    if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    $from = explode(',', $from);
    if (!in_array($task->status, $from)) {
        abort(403, 'Transisi status tidak valid.');
    }

    return $next($request);
}

}
