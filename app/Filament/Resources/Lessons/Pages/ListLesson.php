<?php

namespace App\Filament\Resources\Lessons\Pages;

use App\Filament\Resources\Lessons\LessonResource;
use Filament\Resources\Pages\Page;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ListLesson extends Page implements HasActions, HasSchemas, HasTable
{

    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = LessonResource::class;
    public $course = null;

    public function table(Table $table): Table
    {
        $table->query(self::$resource::getModel()::query()->whereHas('course', fn($query) => $query->where('id', $this->course)));
        return self::$resource::table($table);
    }

    public function mount($course)
    {
        $this->$course = self::$resource::getModel()::find($course);
    }

    protected string $view = 'volt-livewire::filament.resources.courses.resources.lessons.pages.list-lesson';
}
