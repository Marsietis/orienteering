<?php

namespace App\Filament\Resources\SubmissionResource\Pages;

use App\Filament\Resources\SubmissionResource;
use App\Http\Controllers\SubmissionController;
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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        dd($data);
        if ($data['status'] === 'approved') {
            SubmissionController::addPoints($userId, $taskId);
        }
        return $data;
    }
}
