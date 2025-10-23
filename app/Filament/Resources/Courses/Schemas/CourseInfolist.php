<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Filament\Infolists\Components\EnrollmentButtonEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class CourseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image')->label(fn() => new HtmlString("<div></div>"))->imageSize("50%")->columnSpanFull()->extraAttributes(['class' => "flex justify-center items-center"])->extraImgAttributes(['class' => 'rounded-2xl',]),
                TextEntry::make('description')->columnSpanFull(),
                EnrollmentButtonEntry::make("id")->label(fn() => new HtmlString("<div></div>"))->columnSpanFull()->hidden(fn($record) => $record->enrollments()->where("user_id", Auth::user()->id)->exists()),
            ]);
    }
}
