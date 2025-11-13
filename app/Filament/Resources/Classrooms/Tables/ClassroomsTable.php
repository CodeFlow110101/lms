<?php

namespace App\Filament\Resources\Classrooms\Tables;

use App\Filament\Pages\HelpCenter;
use App\Filament\Resources\Classrooms\ClassroomResource;
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

class ClassroomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->imageSize("100%")->imageWidth("100%")->grow(false)->extraAttributes(["class" => "flex justify-center items-center *:rounded-xl"]),
                Stack::make([
                    TextColumn::make('name')->description(fn($record) => Str::limit($record->description, 80))->extraAttributes(["class" => "gap-4 py-4"])->size(TextSize::Large)->weight(FontWeight::Bold)->searchable(),

                    // ProgressBarColumn::make('progress_percentage'),
                ])->grow(true),
            ])
            ->recordUrl(function ($record) {
                // Admins always go directly
                if (Gate::check('is-administrator')) {
                    return $record->lessons->first()
                        ? ClassroomResource::getUrl('view', [
                            'record' => $record->id,
                            'lesson' => $record->lessons->first()->id,
                        ])
                        : null;
                }
                // Members logic
                if (Gate::check('is-member')) {
                    // If course is available in monthly plan
                    if ($record->available_in_monthly_plan) {
                        // Monthly users see modal (handled via recordAction)
                        if (Auth::user()->current_plan === 'monthly') {
                            return null;
                        }

                        // Yearly users go directly
                        if (Auth::user()->current_plan === 'yearly') {
                            return $record->lessons->first()
                                ? ClassroomResource::getUrl('view', [
                                    'record' => $record->id,
                                    'lesson' => $record->lessons->first()->id,
                                ])
                                : null;
                        }
                    }
                    // If not part of monthly plan, yearly users can still go
                    return $record->lessons->first()
                        ? ClassroomResource::getUrl('view', [
                            'record' => $record->id,
                            'lesson' => $record->lessons->first()->id,
                        ])
                        : null;
                }
                return null;
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
                    ->visible(function ($record) {
                        // Admins should never see modal
                        if (Gate::check('is-administrator')) {
                            return false;
                        }
                        // Show modal for monthly members only
                        if ($record->available_in_monthly_plan && Gate::check('is-member')) {
                            return Auth::user()->current_plan === 'monthly';
                        }

                        return false;
                    }),
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
