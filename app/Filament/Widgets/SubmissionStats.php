<?php

namespace App\Filament\Widgets;

use App\Models\Submission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubmissionStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending submissions', Submission::where('status', 'pending')->count()),
            Stat::make('Approved submissions', Submission::where('status', 'approved')->count()),
            Stat::make('Rejected submissions', Submission::where('status', 'rejected')->count()),
        ];
    }
}
