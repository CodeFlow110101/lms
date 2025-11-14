<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry">
    <div {{ $getExtraAttributeBag() }} x-intersect="$wire.markCompleted">
        {{ $getState() }}
    </div>
</x-dynamic-component>