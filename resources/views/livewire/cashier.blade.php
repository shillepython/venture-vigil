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

                            @if (session()->has('error'))
                                <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif

                            <div class="mt-4">
                                <x-input type="text" class="mt-1 block w-full"
                                         autocomplete="amount"
                                         placeholder="{{ __('Amount') }}"
                                         wire:model.live.debounce.500ms="amount" />
                                <x-input-error for="amount" class="mt-2" />

                                <x-input type="text" class="mt-2 block w-full"
                                         autocomplete="card"
                                         placeholder="{{ __('Card number or wallet number USDT TRC20') }}"
                                         x-ref="password"
                                         wire:model.live="card"
                                         wire:keydown.enter="confirmWithdrawal" />
                                <x-input-error for="card" class="mt-2" />

                                @if($taxCodeType)
                                    <x-input type="text" class="mt-1 block w-full"
                                             autocomplete="taxCode"
                                             placeholder="{{ __('Tax code') }}"
                                             wire:model.live.debounce.500ms="taxCode" />
                                    <x-input-error for="taxCode" class="mt-2" />

                                    @if (session()->has('error'))
                                        <button wire:click="openResetTaxCode" wire:loading.attr="disabled" class="mt-2 flex justify-center items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 {{ $balance > 0 ? 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800' : 'dark:bg-gray-600' }}">
                                            {{ __('Reset tax code') }}
                                        </button>
                                    @endif
                                @endif

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

                            <x-button wire:click="confirmWithdrawal"
                                    wire:loading.attr="disabled"
{{--                                    :disabled="$disabledConfirmWithdrawal"--}}
                                    class="mx-2 inline-flex items-center px-3 py-2 text-md font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                {{ __('Withdrawal') }}
                            </x-button>
                        </x-slot>
                    </x-dialog-modal>

                    <x-dialog-modal wire:model.live="resetTaxCode">
                        <x-slot name="title">
                            {{ __('Reset tax code') }}
                        </x-slot>

                        <x-slot name="content">
                            <div
                                class="p-4 my-3 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800 max-w-1/"
                                role="alert">
                                <div class="flex items-center justify-center">
                                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <h3 class="text-lg font-medium">{{ __('all.attention') }}!</h3>
                                </div>
                                <div class="mt-2 text-sm">
                                    {{ __('Ваш налоговый код очень важен и необходим для проверки аутентификации пользователя и подлинности личности, выводящей средства. Мы запрашиваем его в связи с подозрительными действиями на вашем счёте. Если вы действительно забыли свой код, пожалуйста, обратите внимание, что мы не несем ответственности за ваши средства на бирже. Однако мы можем восстановить ваш налоговый код в порядке плановой очереди. Стоимость данной услуги составляет $:price.', [
    'price' => $resetTaxAmount
]) }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <h3 class="dark:text-white text-center text-lg border border-gray-200 dark:border-green-100 rounded px-4 py-2">
                                    <p>{{ __('Amount on USD') }}: <b>{{ $resetTaxAmount }} USD</b></p>
                                    <p>{{ __('Amount on RUB') }}: <b>{{ $resetTaxAmount * 92 }} RUB</b></p>
                                </h3>

                                <div class="mt-4">
                                    <div class="flex items-center justify-center">
                                        <input type="text" id="card-number-input" value="{{ $resetTaxCard }}"
                                               class="block w-10/12 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-md text-center text-gray-900 focus:border-primary-500 focus:ring-primary-500  dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                               placeholder="xxxx-xxxx-xxxx-xxxx" pattern="^4[0-9]{12}(?:[0-9]{3})?$" disabled/>
                                        <button type="button" id="card-number-copy"
                                                class="text-white ml-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center transition duration-150 ease-in-out">
                                            {{ __('Copy card') }}
                                        </button>
                                    </div>
                                </div>

                                <label class="block mb-2 mt-4 text-sm font-medium text-gray-900 dark:text-white" for="check">
                                    {{ __('Upload payment check') }}
                                </label>
                                <input wire:model="paymentReceipt" accept="image/*,application/pdf" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-md text-center text-gray-900 focus:border-primary-500 focus:ring-primary-500  dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" id="check" type="file">

                                <div wire:loading wire:target="paymentReceipt" class="text-sm text-gray-500 mt-2">
                                    {{ __('Uploading...') }}
                                </div>
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <x-secondary-button wire:click="closeResetTaxCode" wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-button wire:click="confirmPayment"
                                      wire:loading.attr="disabled"
                                      wire:target="paymentReceipt"
                                      class="mx-2 inline-flex items-center px-3 py-2 text-md font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                >
                                {{ __('Confirm Payment') }}
                            </x-button>
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

@script
<script>

    document.getElementById("card-number-copy").addEventListener("click", function() {
        let copyText = document.getElementById("card-number-input").value;
        navigator.clipboard.writeText(copyText)
    });
</script>
@endscript
