<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry">
    <livewire:enrollment-button :id="$getState()" />
</x-dynamic-component>