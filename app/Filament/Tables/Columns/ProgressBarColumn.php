<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Support\Facades\Gate;

class ProgressBarColumn extends Column
{
    protected string $view = 'filament.tables.columns.progress-bar-column';
}
