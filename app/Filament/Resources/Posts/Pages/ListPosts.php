<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    public function getHeading(): Htmlable
    {
        return new HtmlString("<div></div>");
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label("New Post"),
        ];
    }
}
