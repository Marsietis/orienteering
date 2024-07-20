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

        $eventEndDateTime = Events::where('end_date', '>', now())->first();

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
            'solvedTasksCount' => $solvedTasksCount,
            'user' => $user,
            'eventEndDateTime' => $eventEndDateTime,
        ]);
    }
}
