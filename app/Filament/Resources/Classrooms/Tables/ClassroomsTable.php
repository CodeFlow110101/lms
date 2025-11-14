<?php

namespace App\Filament\Resources\Classrooms\Tables;

use App\Filament\Pages\HelpCenter;
use App\Filament\Resources\Classrooms\ClassroomResource;
use App\Filament\Tables\Columns\ProgressBarColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Filament\Tables\Columns\Layout\View;

class ClassroomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                View::make('filament.tables.columns.classroom-custom-layout')
                    ->components([
                        ImageColumn::make('image')->imageSize("14rem")->imageWidth("100%")->grow(false)->extraAttributes(["class" => "flex justify-center items-center *:rounded-xl"]),
                    ]),
                Stack::make([
                    TextColumn::make('name')->extraAttributes(["class" => "gap-4 py-4"])->size(TextSize::Large)->weight(FontWeight::Bold)->searchable(),
                    ProgressBarColumn::make('progress_percentage'),
                ])->grow(true),
            ])
            ->recordUrl(function ($record) {
                $firstLesson = $record->lessons->first();
                if (!auth()->user()->can('access', $record)) {
                    return null;
                }
                return $firstLesson ? ClassroomResource::getUrl('view', ['record' => $record->id, 'lesson' => $record->lessons->first()->id,]) : null;
            })
            ->recordAction('test')
            ->recordActions([
                Action::make('test')
                    ->label('')
                    ->requiresConfirmation()
                    ->modalHeading('Course Locked')
                    ->modalDescription('Please contact admin for a yearly subscription plan to access this course.')
                    ->modalSubmitActionLabel('Chat with Admin')
                    ->color('warning')
                    ->action(fn($livewire) => $livewire->redirect(HelpCenter::getUrl(), navigate: true))
                    ->visible(fn($record) => auth()->user()->can('showModal', $record))
            ])

            ->filters([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ])->contentGrid([
                'md' => 2,
                'xl' => 3,
            ]);
    }
}
