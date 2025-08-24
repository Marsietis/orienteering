<?php

namespace App\Observers;

use App\Models\Submission;
use App\Notifications\SubmissionStatusUpdated;

class SubmissionObserver
{
    /**
     * Handle the Submission "created" event.
     */
    public function created(Submission $submission): void
    {
        //
    }

    /**
     * Handle the Submission "updated" event.
     */
    public function updated(Submission $submission): void
    {
        if ($submission->isDirty('status')) {
            $oldStatus = $submission->getOriginal('status');
            $submission->user->notify(new SubmissionStatusUpdated($submission, $oldStatus));
        }
    }

    /**
     * Handle the Submission "deleted" event.
     */
    public function deleted(Submission $submission): void
    {
        //
    }

    /**
     * Handle the Submission "restored" event.
     */
    public function restored(Submission $submission): void
    {
        //
    }

    /**
     * Handle the Submission "force deleted" event.
     */
    public function forceDeleted(Submission $submission): void
    {
        //
    }
}
