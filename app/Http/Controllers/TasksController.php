<?php

namespace App\Http\Controllers;

use App\Models\Events;
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
        $userSubmissions = Submission::where('user_id', auth()->id())
            ->where('task_id', $task->id)->orderBy('created_at', 'desc')
            ->get();
        foreach ($userSubmissions as $submission) {
            $submission->image_path = Storage::url($submission->image_path);
        }

        $eventEndDateTime = Events::where('end_date', '>', now())->first();
        $eventStartDateTime = Events::where('start_date', '<', now())->first();

        if ($eventStartDateTime == null || $eventEndDateTime == null) {
            return redirect()->to('dashboard')->with('error', 'Competition is not active');
        }

        return Inertia::render('Tasks/Show', [
            'task' => $task,
            'userSubmissions' => $userSubmissions,
        ]);
    }

    public function storeSubmission(Request $request, Task $task)
    {
        $eventEndDateTime = Events::where('end_date', '>', now())->first();
        $eventStartDateTime = Events::where('start_date', '<', now())->first();

        if ($eventStartDateTime == null || $eventEndDateTime == null) {
            return redirect()->to('dashboard')->with('error', 'Competition is not active');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $imagePath = $request->file('image')->store('submissions', 'public');

        Submission::create([
            'user_id' => auth()->id(),
            'task_id' => $task->id,
            'image_path' => $imagePath,
        ]);
    }

    public static function increaseSolveCount($id)
    {
        $task = Task::findOrFail($id);
        $task->solve_count++;
        $task->save();
    }
}
