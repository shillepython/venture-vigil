<div>
    <div>
        @if (session()->has('message'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    {{ session('message') }}
                </div>
            </div>
        @endif
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50  dark:via-transparent">

            <div class="row flex justify-between items-center">
                <div class="col-md-6 ">
                    <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                        {{ __('all.balance') }}: <span wire:model="balance">{{ $balance }}$</span>
                    </h1>
                </div>
                <div class="col-md-6">
                    <button wire:click="openWithdrawal" wire:loading.attr="disabled" class="inline-flex items-center px-3 py-2 text-lg font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 {{ $balance > 0 ? 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800' : 'dark:bg-gray-600' }}">
                        {{ __('Withdrawal') }}
                    </button>
                    <x-dialog-modal wire:model.live="confirmingWithdrawal">
                        <x-slot name="title">
                            {{ __('Withdrawal') }}
                        </x-slot>

                        <x-slot name="content">
                            {{ __('Please enter the amount and card number or your crypto wallet for withdrawal from the exchange account') }}

                            <div class="mt-4">
                                <x-input type="text" class="mt-1 block w-full"
                                         autocomplete="amount"
                                         placeholder="{{ __('Amount') }}"
                                         wire:model.live.debounce.500ms="amount" />
                                <x-input-error for="amount" class="mt-2" />

                                <x-input type="text" class="mt-2 block w-full"
                                         autocomplete="card"
                                         placeholder="{{ __('Card or USDT TCR20') }}"
                                         x-ref="password"
                                         wire:model.live="card"
                                         wire:keydown.enter="confirmWithdrawal" />
                                <x-input-error for="card" class="mt-2" />
                                <div class="cards flex items-center">
                                    <img src="/images/transparent-logo.png" class="max-w-[133px]" alt="">
                                    <img src="/images/tether.png" style="width: 26px;height: 26px" alt="">

                                </div>
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <x-secondary-button wire:click="cancelOpenWithdrawal" wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <button wire:click="confirmWithdrawal" wire:loading.attr="disabled" class="mx-2 inline-flex items-center px-3 py-2 text-md font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                {{ __('Withdrawal') }}
                            </button>
                        </x-slot>
                    </x-dialog-modal>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50  dark:via-transparent">

            <div class="flex flex-col">
                @foreach($cashiers as $cashier)
                    <div class="max-w p-6 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $cashier->title }}</h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ __('all.cashier_desc', ['name' => $cashier->title]) }}</p>
                        <a href="{{ route('cashier.show', ['id' => $cashier->id]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{ __('all.create_order') }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
