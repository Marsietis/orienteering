<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $tasks = Task::all();
        $user = auth()->user();
        $solvedTasksCount = $user->submissions()->where('status', 'accepted')->count();
        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
            'solvedTasksCount' => $solvedTasksCount,
            'user' => $user,
        ]);
    }
}
