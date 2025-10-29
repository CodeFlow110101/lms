<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry">
    <div {{ $getExtraAttributeBag() }}>
        @if($getRecord()->isLiked)
        <x-filament::button wire:click="updateLikeStatus" size="sm" outlined icon="heroicon-m-hand-thumb-up">{{ $getRecord()->likes()->count() }}</x-filament::button>
        @else
        <x-filament::button wire:click="updateLikeStatus" size="sm" outlined icon="heroicon-o-hand-thumb-up">{{ $getRecord()->likes()->count() }}</x-filament::button>
        @endif
    </div>
</x-dynamic-component>