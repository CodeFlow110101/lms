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
                <div>
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

@assets
<script src="https://js.stripe.com/v3/"></script>
@endassets

@push('scripts')
<script>
    function stripePaymentSetup({
        publicKey,
        clientSecret
    }) {
        return {
            stripe: null,
            cardElement: null,
            error: null,
            cardHolderName: null,
            loadingIndicator: null,
            init() {
                this.stripe = Stripe(publicKey);
                const elements = this.stripe.elements();

                this.cardElement = elements.create('card');
                this.cardElement.mount('#card-element');
            },

            async handleSubmit() {
                this.loadingIndicator = true;
                const {
                    setupIntent,
                    error
                } = await this.stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: this.cardElement,
                            billing_details: {
                                name: this.cardHolderName
                            }
                        }
                    }
                );

                this.loadingIndicator = false;
                if (error) {
                    this.error = error.message;
                } else {
                    this.$wire.back();
                }
            }
        }
    }
</script>
@endpush