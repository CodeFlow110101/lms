<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\Component;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;

class CommentSection extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public $post_id;

    public function productInfolist(Schema $schema): Schema
    {
        return $schema
            ->record(Post::find($this->post_id))
            ->components([
                CommentsEntry::make('comments')->mentionables(fn(Model $record) => User::all())->label(fn() => new HtmlString("<div></div>"))->disableSidebar()->disableSidebar()->perPage(2)->poll('10s')->loadMoreIncrementsBy(8),
            ]);
    }

    public function mount($id)
    {
        $this->post_id = $id;
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}
