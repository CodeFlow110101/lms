<?php

namespace App\Livewire;

use App\Filament\Resources\Posts\PostResource;
use Filament\Widgets\Widget;

class PostCreateWidget extends Widget
{
    protected static bool $isLazy = false;

    protected string $view = 'volt-livewire::livewire.post-create-widget';

    public $url;

    public function mount()
    {
        $this->url = PostResource::getUrl("create");
    }
}
