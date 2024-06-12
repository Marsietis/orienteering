<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubmissionResource\Pages;
use App\Models\Submission;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->required(),
                Forms\Components\Select::make('task_id')
                    ->relationship('task', 'title')
                    ->disabled()
                    ->required(),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->disabled()
                    ->required(),
                Forms\Components\ToggleButtons::make('status')
                    ->options([
                        'approved' => 'Approved',
                        'rejected' => 'Rejected'
                    ])
                    ->colors([
                        'approved' => 'success',
                        'rejected' => 'danger',
                    ])
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('comments')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->label('Team name'),
                Tables\Columns\TextColumn::make('task.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Submission Image'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'approved' => 'Approved',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->label('Review'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('Mark as approved')
                        ->action(fn($records) => $records->each->update(['status' => 'approved']))->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('Mark as Rejected')
                        ->action(fn($records) => $records->each->update(['status' => 'rejected']))->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('Mark as Pending')
                        ->action(fn($records) => $records->each->update(['status' => 'pending']))->requiresConfirmation(),
                ]),
            ])
            ->groups([
                Group::make('user.name')
                    ->label('Team name'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubmissions::route('/'),
            'view' => Pages\ViewSubmission::route('/{record}'),
            'edit' => Pages\EditSubmission::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('user.name')->label('Team name'),
                Infolists\Components\TextEntry::make('task.id')->label('Task ID'),
                Infolists\Components\TextEntry::make('task.description')->label('Task Description'),
                Infolists\Components\TextEntry::make('status')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),
                Infolists\Components\TextEntry::make('created_at')->dateTime()->prose(),
                Infolists\Components\ImageEntry::make('image_path')->label('Submission Image')->placeholder('No image'),
            ]);
    }

}
