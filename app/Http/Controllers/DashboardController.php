<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $tasks = Task::all();
        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }
}
