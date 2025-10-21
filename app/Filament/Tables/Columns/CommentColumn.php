<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class CommentColumn extends Column
{
    use InteractsWithSchemas;

    protected string $view = 'filament.tables.columns.comment-column';
}
