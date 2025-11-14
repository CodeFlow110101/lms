<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry">
    <div x-cloak {{ $getExtraAttributeBag() }} class="w-full">
        <div class="flex-1 bg-gray-300 dark:bg-gray-700 rounded-full overflow-hidden relative">
            <div class="relative z-10 px-4 font-semibold">{{ $getState() }}%</div>
            <div class="absolute inset-0 h-full bg-primary-500" :style="{ width: {{ $getState() }} + '%'}"></div>
        </div>
    </div>
</x-dynamic-component>