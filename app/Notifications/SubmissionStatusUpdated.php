<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubmissionStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public Submission $submission,
        public string $oldStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'task_title' => $this->submission->task->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->submission->status,
            'comments' => $this->submission->comments,
            'message' => $this->getMessage(),
        ];
    }

    private function getMessage(): string
    {
        return match ($this->submission->status) {
            'approved' => "Jūsų atskyra užduotyje '{$this->submission->task->title}' buvo priimta! / Your submission for '{$this->submission->task->title}' has been approved!",
            'rejected' => "Jūsų atskyra užduotyje '{$this->submission->task->title}' buvo atmesta. / Your submission for '{$this->submission->task->title}' has been rejected.",
            'pending' => "Jūsų atskyra užduotyje '{$this->submission->task->title}' laukia vertinimo. / Your submission for '{$this->submission->task->title}' is pending review.",
            default => 'Jūsų atskyros statusas buvo atnaujintas. / Your submission status has been updated.'
        };
    }
}
