<?php

namespace App\Filament\Resources\SubmissionResource\Pages;

use App\Filament\Resources\SubmissionResource;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TasksController;
use App\Models\Task;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubmission extends EditRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        if ($this->record->status === 'approved') {
            SubmissionController::addPoints($this->record->user_id, $this->record->task_id);
            TasksController::increaseSolveCount($this->record->task_id);
        }
    }
}
