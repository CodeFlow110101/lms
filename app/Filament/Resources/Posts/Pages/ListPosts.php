<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Livewire\PostCreateWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    public function getHeading(): Htmlable
    {
        return new HtmlString("<div></div>");
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PostCreateWidget::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make()->label("New Post")->mutateDataUsing(function (array $data) {
            //     $data['user_id'] = Auth::user()->id;
            //     return $data;
            // }),
        ];
    }
}
