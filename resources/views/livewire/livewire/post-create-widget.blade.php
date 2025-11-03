<x-filament-widgets::widget>
    <a class="w-full cursor-pointer" href="{{ $this->url }}" wire:navigate>
        <x-filament::section class="*:*:first:py-3">
            <div class="flex gap-3 items-center font-bold text-lg">
                <x-filament::avatar
                    src="{{ auth()->user()->avatar }}"
                    alt="Dan Harrin"
                    size="lg" />
                <div class="opacity-50">Write Something</div>
            </div>
        </x-filament::section>
        <x-filament-actions::modals />
    </a>
</x-filament-widgets::widget>