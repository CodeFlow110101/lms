<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\HtmlString;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    public function getHeading(): HtmlString
    {
        return new HtmlString(view('layout.post-heading', [
            'user' => $this->record->user,
            'title' => $this->record->title,
            'avatar' => $this->record->user->avatar,
        ])->render());
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
