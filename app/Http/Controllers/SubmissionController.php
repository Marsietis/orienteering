<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;

class SubmissionController extends Controller
{
    public static function addPoints($userId, $taskId)
    {
        // Add points to the user
        $user = User::find($userId);
        $task = Task::find($taskId);

        $user->points += $task->points;

        $user->save();
    }
}
