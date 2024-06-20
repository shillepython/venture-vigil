<div
    class="bg-white border-2 dark:bg-gray-800 rounded-lg shadow-xl px-3 mx-3 md:mx-auto md:px-8 py-6 md:max-w-lg text-center border-condition {{ $currentStep === 3 ? 'current-step-3' : '' }}">
    <h1 class="text-2xl font-bold text-white">RUB to USD</h1>
    <!-- start step indicators -->
    <ol class="flex py-6">
        <li class="flex w-full items-center text-blue-600 dark:text-blue-500 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block dark:after:border-blue-800">
        <span
            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full lg:h-12 lg:w-12 dark:bg-blue-800 shrink-0">
            <svg class="w-3.5 h-3.5 text-blue-600 lg:w-4 lg:h-4 dark:text-blue-300" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M1 5.917 5.724 10.5 15 1.5"/>
            </svg>
        </span>
        </li>
        <li class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block {{ $currentStep == 2  || $currentStep == 3 ? 'dark:after:border-blue-800' : 'dark:after:border-gray-700' }} ">
        <span
            class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 {{$currentStep == 2 || $currentStep == 3 ? 'dark:bg-blue-800' : 'dark:bg-gray-700'}} shrink-0">
            <svg class="w-4 h-4 text-gray-500 lg:w-5 lg:h-5 dark:text-gray-100" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                <path
                    d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
            </svg>
        </span>
        </li>
        <li class="flex items-center w-fit">
        <span
            class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 {{$currentStep == 3 ? 'dark:bg-blue-800' : 'dark:bg-gray-700'}} shrink-0">
            <svg class="w-4 h-4 text-gray-500 lg:w-5 lg:h-5 dark:text-gray-100" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path
                    d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/>
            </svg>
        </span>
        </li>
    </ol>
    <!-- end step indicators -->
    <span class="text-gray-400 block mb-3">{{ __($messages[$currentStep]) }}</span>

    <span id="countdown" class="block text-gray-50 text-3xl"></span>
    {{-- step one--}}
    @if ($currentStep === 1)
        <form id="orderForm" class="text-left mx-auto p-6 mb-4" wire:submit="createOrder">
            <div class="mb-6 space-y-4">
                <div class="">
                    <div class="flex flex-row space-x-3">
                        <div>
                            <label for="sell-currency"
                                   class="block mb-2 text-md font-medium text-gray-900 dark:text-white">{{ __('all.currency') }}</label>
                            <select wire:model="currency" id="sell-currency" name="sell-currency"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required disabled>
                                <option selected value="usd">USD</option>
                                <option value="eur">EUR</option>
                                <option value="rub">RUB</option>
                            </select>
                        </div>
                        <div class="block grow">
                            <label for="sell-amount"
                                   class="block mb-2 text-md font-medium text-gray-900 dark:text-white">{{ __('all.amount') }}
                                $</label>
                            <input wire:model.live.debounce.1000ms="fiatUsd" step="0.01" type="number" min="100" max="10000"
                                   id="sell-amount"
                                   name="sell-amount"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="200" required/>
                        </div>
                    </div>
                    <span class="text-sm py-2 text-red-800">{{ $minFiatUsdMessage }}</span>

                    <div
                        class="mt-3 flex items-center space-x-2 flex-wrap text-gray-800 dark:text-gray-300 text-xs font-medium select-none">
                        <span wire:click="setUsd(100)"
                              class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">100</span>
                        <span wire:click="setUsd(150)"
                              class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">150</span>
                        <span wire:click="setUsd(200)"
                              class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">200</span><span
                            wire:click="setUsd(300)"
                            class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">300</span><span
                            wire:click="setUsd(500)"
                            class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">500</span>
                    </div>
                </div>

                <div class="flex flex-row space-x-3">
                    <div>
                        <label for="buy-currency" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">{{ __('all.currency') }}</label>
                        <select wire:model="currency" id="buy-currency" name="buy-currency"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required disabled>
                            <option value="usd">USD</option>
                            <option value="eur">EUR</option>
                            <option selected value="rub">RUB</option>
                        </select>
                    </div>
                    <div class="block grow">
                        <label for="buy-amount" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">{{ __('all.amount') }}
                            ₽</label>
                        <input wire:model.live.debounce.1000ms="fiatRub" type="number" step="0.01" min="100" max="1000000"
                               id="buy-amount" name="buy-amount"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="200" required/>
                    </div>

                </div>
                <span
                    class="block mt-4 text-sm text-gray-500 dark:text-gray-300">{{ __('all.price_per_dollar', ['price' => $cashier->price_per_dollar]) }}</span>
                <span
                    class="block text-sm text-gray-500 dark:text-gray-300">{{ __('all.min_amount_warning', ['amount' => 100]) }}</span>
            </div>
            <button type="submit" {{ $enableSumbitStageOne ? '' : 'disabled' }}
            class="text-white {{ $enableSumbitStageOne ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-gray-600' }} bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 w-full sm:w-auto text-center transition duration-150 ease-in-out">
                {{ __('all.next') }}
            </button>
        </form>
    @elseif($currentStep === 2)
        <form id="submitPayment" class="text-left mx-auto sm:p-6 mb-4" wire:submit="submitPayment">
            <div class="sm:p-6 sm:space-y-4">
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
                        {{ __('all.you_have_only') }} <strong class="bold"><u class="underline">{{ __('all.15_minutes') }}</u></strong> {{ __('all.to_send_debit_the_cashier') }}
                    </div>
                </div>
                <h3 class="dark:text-white text-md">{{ __('all.order') }}: {{ $order->id }}</h3>
                <h3 class="dark:text-white text-md">{{ __('all.order_date') }}: {{ $order->created_at }}</h3>
                <h3 class="dark:text-white text-center text-lg border border-gray-200 dark:border-green-100 rounded px-4 py-2">{{ __('Amount') }}: {{ $fiatRub }}</h3>
                <div class="flex flex-col items-center">
                    <p class="text-white-text-md text-gray-400">{{ __('all.details_below') }}</p>


                    <svg class="w-6 h-6 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m19 9-7 7-7-7"/>
                    </svg>
                </div>

                <div
                    class="w-full rounded-lg border border-gray-200 bg-white px-4 py-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:px-6 lg:max-w-xl lg:px-8">
                    <h3 class="text-xl mb-5 font-bold text-white text-center">{{ __('all.cashier_details') }}</h3>
                    <div class="w-full space-y-4 mx-auto">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="full_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('all.full_name') }}
                            </label>
                            <input type="text" id="full_name" value="{{ $cashier->full_name }}"
                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-md text-center text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                   placeholder="Bonnie Green" disabled
                            />
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="card-number-input"
                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('all.card_number') }}</label>
                            <input type="text" id="card-number-input" value="{{ $cashier->card_number }}"
                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-md text-center text-gray-900 focus:border-primary-500 focus:ring-primary-500  dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                   placeholder="xxxx-xxxx-xxxx-xxxx" pattern="^4[0-9]{12}(?:[0-9]{3})?$" disabled/>
                            <div class="flex flex-col items-center justify-center">
                                <button type="button" id="card-number-copy"
                                        class="text-white mt-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 w-26 text-center transition duration-150 ease-in-out">
                                    {{ __('Copy card') }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="check">
                        {{ __('Upload payment check') }}
                    </label>
                    <input wire:model="check" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="check" type="file">
                </div>
                <div class="text-left mt-6">
                    <button type="submit" {{ $enableSumbitStageOne ? '' : 'disabled' }}
                    class="text-white {{ $enableSumbitStageOne ? 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800' : 'dark:bg-gray-600' }} bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 w-full text-center transition duration-150 ease-in-out">
                        {{ __('all.submit') }}
                    </button>
                </div>
            </div>
        </form>
        {{--         Step Three--}}
    @elseif($currentStep === 3)
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-center">
                <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl font-medium text-gray-900 dark:text-white text-center">{{ __('all.thank_you') }}</h2>
            <p class="text-gray-500 dark:text-gray-300 text-center">{{ __('all.order_placed') }}</p>

            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('all.order_summary') }}</h3>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-300">
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ __('all.amount_to_sell') }}:</span> {{ $fiatRub }}
                            RUB
                        </p>
                    </div>
                    <div class="flex items-center mx-4">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-300">
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ __('all.amount_to_receive') }}:</span> {{ $fiatUsd }}
                            USD
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <button type="button" wire:click="resetForm()"
                        class="text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    {{ __('all.another_order') }}
                </button>
            </div>
        </div>
    @endif
</div>

@script
<script>

    document.getElementById("card-number-copy").addEventListener("click", function() {
        let copyText = document.getElementById("card-number-input").value;
        navigator.clipboard.writeText(copyText)
    });

    let amountTime = {{ $timer ?? 900 }};
    let intervalId;

    const countdown = document.querySelector("#countdown");

    function calculateTime() {
        const minutes = Math.floor(amountTime / 60).toString().padStart(2, '0');
        const seconds = (amountTime % 60).toString().padStart(2, '0');

        countdown.textContent = `${minutes}:${seconds}`;
        amountTime--;

        if (amountTime < 0) {
            stopTimer();
            amountTime = 0;
        }
    }

    function stopTimer() {
        clearInterval(intervalId);
    }

    $wire.on('start-timer', () => {
        if (amountTime > 0) {
            intervalId = setInterval(calculateTime, 1000);
        }
    });

    $wire.on('delete-timer', () => {
        stopTimer();
        amountTime = 0;
        document.querySelector("#countdown").remove()
    });
</script>
@endscript
