<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Task;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $tasks = Task::all();
        $user = auth()->user();
        $solvedTasksCount = Submission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();
        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
            'solvedTasksCount' => $solvedTasksCount,
            'user' => $user,
        ]);
    }
}
