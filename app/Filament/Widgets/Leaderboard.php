<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Leaderboard extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->orderBy('points', 'desc')
            )
            ->columns([
                    TextColumn::make('Rank')
                        ->rowIndex(),
                    Tables\Columns\TextColumn::make('name')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('points')->sortable(),
                ]
            )->striped();
    }
}
