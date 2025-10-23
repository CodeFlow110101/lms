<?php

namespace App\Filament\Resources\Courses\Resources\Lessons\Widgets;

use App\Filament\Resources\Courses\Resources\Lessons\LessonResource;
use App\Models\Lesson;
use Filament\Actions\BulkActionGroup;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ListLessonWidget extends TableWidget
{

    protected static string $resource = LessonResource::class;

    public $lesson;

    public function getColumnSpan(): int | string | array
    {
        return "full";
    }

    public function table(Table $table): Table
    {
        $table->query(self::$resource::getModel()::query()->whereHas('course', fn($query) => $query->where('id', $this->lesson->course->id)))
            ->columns([
                Split::make([
                    ImageColumn::make('image')->imageSize("100%")->imageWidth("150px")->grow(false)->extraAttributes(["class" => "flex justify-center items-center *:rounded-xl"]),
                    Stack::make([
                        TextColumn::make('name'),
                    ])->grow(false),
                    TextColumn::make('name')->badge()->formatStateUsing(fn($record) => $record->id == $this->lesson->id ? "Playing" : "Play")->grow(false),
                    TextColumn::make('progress.is_completed')->badge()->color(fn($record) => $record->progress()->where("user_id", Auth::id())->exists() ? "success" : "danger")->formatStateUsing(fn($record, $state) => $record->progress()->where("user_id", Auth::id())->exists() ? "Completed" : "Not Completed")
                ])->extraAttributes(["class" => "flex items-center"])->from('md')
            ])->recordUrl(fn($record): string => LessonResource::getUrl('view', ['course' => $record->course->id, 'record' => $record->id,]));
        return $table;
    }

    public function mount($lesson)
    {
        $this->lesson = Lesson::find($lesson);
    }
}
