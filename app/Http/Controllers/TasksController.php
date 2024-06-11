<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TasksController extends Controller
{
    public function show($id)
    {
        $task = Task::findOrFail($id);
        if ($task->image_path) {
            $task->image_path = Storage::url($task->image_path);
        }
        return Inertia::render('Tasks/Show', [
            'task' => $task,
        ]);
    }
}
