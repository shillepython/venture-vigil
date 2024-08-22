<div>
    <x-form-section submit="submit">
        <x-slot name="title">
            {{ __('Transfer Funds') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Transfer funds to another user via their email address.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Recipient Email') }}" />
                <x-input id="email" type="email" class="mt-1 block w-full" wire:model="email" required />
                <x-input-error for="email" class="mt-2" />
            </div>

            <!-- Amount -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="amount" value="{{ __('Amount') }}" />
                <x-input id="amount" type="number" class="mt-1 block w-full" wire:model="amount" required step="0.01" />
                <x-input-error for="amount" class="mt-2" />

                <!-- Display current balance -->
                <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Your current balance is:') }} {{ Auth::user()->balance }} {{ __('USD') }}
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled">
                {{ __('Transfer') }}
            </x-button>
        </x-slot>
    </x-form-section>

    @if (session()->has('message'))
        <div class="mt-5 text-green-600">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mt-5 text-red-600">
            {{ session('error') }}
        </div>
    @endif
</div>
