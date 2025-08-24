<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->limit(20)
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notification && ! $notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->markAsRead();

        return response()->json(['success' => true]);
    }

    public function getSubmissionTask($submissionId)
    {
        $submission = Submission::find($submissionId);

        if (! $submission) {
            return response()->json(['error' => 'Submission not found'], 404);
        }

        return response()->json(['task_id' => $submission->task_id]);
    }

    public function clearAll(Request $request)
    {
        $request->user()->notifications()->delete();

        return response()->json(['success' => true]);
    }
}
