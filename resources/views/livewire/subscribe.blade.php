<div x-data="stripeRegistrationPaymentSetup({
        publicKey: '{{ env('STRIPE_KEY') }}',
        clientSecret: '{{ $intent }}'
    })"
    x-init="init()" class="flex flex-col gap-4">

    <form class="flex flex-col gap-4">
        {{ $this->form }}

        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <label>Card Holder name (Optional) </label>
                <x-filament::input.wrapper>
                    <x-filament::input x-model="cardHolderName" type="text" />
                </x-filament::input.wrapper>
            </div>
            <div wire:ignore>
                <x-filament::input.wrapper>
                    <div id="card-element" class="fi-input p-3 dark:!text-white"></div>
                </x-filament::input.wrapper>
                <div x-show="error" class="text-red-500" x-text="error"></div>
            </div>
            <x-filament::button id="card-button" @click="handleSubmit">
                <x-filament::loading-indicator x-show="loadingIndicator" class="h-5 w-5" />
                Join
                @if(collect($data)->get('plan') == "monthly")
                {{ $monthly_plan . '/Monthly' }}
                @elseif(collect($data)->get('plan') == "yearly")
                {{ $yearly_plan . '/Yearly' }}
                @endif
            </x-filament::button>
        </div>
    </form>
    {{ $this->logoutAction }}
    <x-filament-actions::modals />
</div>