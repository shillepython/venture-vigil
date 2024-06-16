<div class="bg-white  dark:bg-gray-800 rounded-lg shadow-xl px-3 mx-3 md:mx-auto md:px-8 py-6 md:max-w-lg text-center">
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
        <li class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block {{ $currentStep == 2 ? 'dark:after:border-blue-800' : 'dark:after:border-gray-700' }} ">
        <span
            class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 {{$currentStep == 2 ? 'dark:bg-blue-800' : 'dark:bg-gray-700'}} shrink-0">
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
    <span class="text-gray-400">{{ $messages[$currentStep] }}</span>

    {{-- step one --}}
    @if ($currentStep === 1)
        <form id="orderForm" class="text-left mx-auto p-6 mb-4" wire:submit="createOrder">
            <div class="mb-6 space-y-4">
                <div class="">
                    <div class="flex flex-row space-x-3">
                        <div>
                            <label for="sell-currency"
                                   class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Currency</label>
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
                                   class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Amount
                                $ <strong
                                    class="ml-1 bg-red-100 text-red-800 text-sm font-medium me-2 px-2 py-0.5 rounded dark:bg-red-900 dark:text-red-300">min
                                    100 USD</strong></label>
                            <input wire:model.live.debounce.1000ms="fiatUsd" type="number" min="100" max="10000"
                                   id="sell-amount"
                                   name="sell-amount"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="200" required/>
                        </div>
                    </div>
                    <span class="text-sm py-2 text-red-800">{{ $minFiatUsdMessage }}</span>

                    <div
                        class="mt-3 flex items-center space-x-2 text-gray-800 dark:text-gray-300 text-xs font-medium select-none">
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
                        <label for="buy-currency" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Currency</label>
                        <select wire:model="currency" id="buy-currency" name="buy-currency"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required disabled>
                            <option value="usd">USD</option>
                            <option value="eur">EUR</option>
                            <option selected value="rub">RUB</option>
                        </select>
                    </div>
                    <div class="block grow">
                        <label for="buy-amount" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Amount
                            ₽</label>
                        <input wire:model.live.debounce.1000ms="fiatRub" type="number" min="100" max="1000000"
                               id="buy-amount" name="buy-amount"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="200" required/>
                    </div>

                </div>
                <span
                    class="block mt-4 text-sm text-gray-500 dark:text-gray-300">*Price per dollar is {{ $cashier->price_per_dollar }} RUB</span>
                <span
                    class="block text-sm text-gray-500 dark:text-gray-300">*Minimal amount to purchase is 100 USD</span>
            </div>
            <button type="submit" {{ $enableSumbitStageOne ? '' : 'disabled' }}
            class="text-white {{ $enableSumbitStageOne ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-gray-600' }} bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto text-center transition duration-150 ease-in-out">
                Next
            </button>
        </form>
    @elseif($currentStep === 2)
        <div class="p-6 mb-4 space-y-4">
            <div
                class="p-4 my-3 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800 max-w-1/"
                role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium">Attention!</h3>
                </div>
                <div class="mt-2 text-sm">
                    You have only <strong class="bold"><u class="underline">15 minutes</u></strong> to send direct debit to
                    the cashier. If you do not send the payment within 15 minutes, the order will be canceled.
                </div>
            </div>
            <h3 class="dark:text-white text-md">Order: {{ $order->id }}</h3>
            <h3 class="dark:text-white text-md">Order date: {{ $order->created_at }}</h3>
            <div class="flex flex-col items-center">
                <p class="text-white-text-md text-gray-400">Use the details below</p>


                <svg class="w-6 h-6 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 9-7 7-7-7"/>
                </svg>
            </div>

            <div
                class="w-full rounded-lg border border-gray-200 bg-white px-4 py-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:px-6 lg:max-w-xl lg:px-8">
                <h3 class="text-xl mb-5 font-bold text-white text-left">Cashier details</h3>
                <div class="w-fit space-y-4 mx-auto">
                    <div class="col-span-2 sm:col-span-1">
                        <label for="full_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Full
                            name</label>
                        <input type="text" id="full_name" value="{{ $cashier->full_name }}"
                               class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                               placeholder="Bonnie Green" required/>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="card-number-input" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Card number</label>
                        <input type="text" id="card-number-input" value="{{ $cashier->card_number }}"
                               class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pe-10 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500  dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                               placeholder="xxxx-xxxx-xxxx-xxxx" pattern="^4[0-9]{12}(?:[0-9]{3})?$" disabled/>
                    </div>
                    <span id="countdown"></span>
                </div>
            </div>
            <div class="text-left mt-4">
                <button type="submit" {{ $enableSumbitStageOne ? '' : 'disabled' }}
                class=" text-white {{ $enableSumbitStageOne ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-gray-600' }} bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto text-center transition duration-150 ease-in-out">
                    Next
                </button>
            </div>
        </div>
    @elseif($currentStep === 3)
        finish
    @endif
</div>

@script
    <script>
        $wire.on('start-timer', () => {
            let amountTime = {{ $timer ?? 900 }};

            function calculateTime (){
                const countdown = document.querySelector("#countdown");

                let minutes = Math.floor(amountTime/60);
                let seconds = amountTime%60;

                if (seconds < 10){
                    seconds = "0" + seconds;
                }

                if (minutes < 10){
                    minutes = "0" + minutes;
                }

                countdown.textContent = `${minutes}:${seconds}`;
                amountTime--;

                if (amountTime < 0) {
                    stopTimer();
                    amountTime = 0;
                }

                function stopTimer(){
                    clearInterval();
                }
            }
            setInterval(calculateTime,1000);
        });
    </script>
@endscript
