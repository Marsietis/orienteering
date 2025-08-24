<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Submission;
use App\Models\Task;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $tasks = Task::with(['submissions' => function ($query) use ($user) {
            $query->where('user_id', $user->id)->latest('created_at'); // Latest submission per task
        }])->get();

        $solvedTasksCount = Submission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        $currentEvent = Events::where('end_date', '>', now())->first();

        if ($currentEvent == null || now() < $currentEvent->start_date) {
            $tasks = null;
        }

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
            'solvedTasksCount' => $solvedTasksCount,
            'user' => $user,
            'eventEndDateTime' => $currentEvent ? [
                'start_date' => $currentEvent->start_date->toISOString(),
                'end_date' => $currentEvent->end_date->toISOString(),
            ] : null,
        ]);
    }
}
