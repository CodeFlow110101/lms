<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry">
    <div {{ $getExtraAttributeBag() }}>
        @if($id == $getLivewire()->lesson->id)
        <x-filament::button href="{{ $url }}" tag="a" class="w-full py-3.5 flex justify-start" color="primary">
            {{ $record->name }}
        </x-filament::button>
        @else
        <x-filament::button href="{{ $url }}" tag="a" class="w-full py-3.5 flex justify-start" outlined color="gray">
            {{ $record->name }}
        </x-filament::button>
        @endif
    </div>
</x-dynamic-component>