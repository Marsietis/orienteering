<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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

    public function storeSubmission(Request $request, Task $task)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $imagePath = $request->file('image')->store('submissions', 'public');

        Submission::create([
            'user_id' => auth()->id(),
            'task_id' => $task->id,
            'image_path' => $imagePath,
        ]);
    }
}
