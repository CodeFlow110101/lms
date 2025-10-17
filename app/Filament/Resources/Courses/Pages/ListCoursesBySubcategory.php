<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Courses\Tables\CoursesTable;
use App\Models\SubCategory;
use Filament\Resources\Pages\Page;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListCoursesBySubcategory extends Page implements HasActions, HasSchemas, HasTable
{

    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = CourseResource::class;

    public ?string $subcategory = null;

    public function getTitle(): string | Htmlable
    {
        return SubCategory::find($this->subcategory)->name;
    }

    public function table(Table $table): Table
    {
        $table = $table->query(self::$resource::getModel()::query())
            ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('subCategory', fn($query) => $query->where('id', $this->subcategory)));

        return CoursesTable::configure($table);
    }

    public function mount(?string $subcategory = null): void
    {
        SubCategory::find($subcategory) || abort(404);
        $this->subcategory = $subcategory;
    }

    protected string $view = 'volt-livewire::filament.resources.courses.pages.list-courses-by-subcategory';
}
