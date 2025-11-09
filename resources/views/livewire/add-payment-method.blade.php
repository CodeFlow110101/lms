<div>
    <div
        x-data="stripePaymentSetup({
        publicKey: '{{ env('STRIPE_KEY') }}',
        clientSecret: '{{ $intent }}'
    })"
        x-init="init()">
        <x-filament::section>
            <x-slot name="heading">
                User details
            </x-slot>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label>Card Holder name (Optional) </label>
                    <x-filament::input.wrapper>
                        <x-filament::input x-model="cardHolderName" type="text" />
                    </x-filament::input.wrapper>
                </div>
                <x-filament::input.wrapper>
                    <div id="card-element" class="fi-input p-3 dark:!text-white"></div>
                </x-filament::input.wrapper>
                <div x-show="error" class="text-red-500" x-text="error"></div>
                <x-filament::button id="card-button" @click="handleSubmit">
                    <x-filament::loading-indicator x-show="loadingIndicator" class="h-5 w-5" />
                    Add Payment Method
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>
</div>