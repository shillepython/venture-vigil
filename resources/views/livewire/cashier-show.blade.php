<div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-12 mx-auto max-w-fit text-center">
    <h1 class="text-2xl font-bold text-white">RUB to USD</h1>
    <span class="text-gray-400 ">Convert Russian Rubles to United States Dollar</span>
    <form id="orderForm" class="text-left mx-auto p-6 mb-4" wire:submit="createOrder">
        <!-- start step indicators -->
        <div class="form-header flex gap-3 mb-8 text-xs text-center text-white ">
            <span class="stepIndicator flex-1 pb-8 relative">Order</span>
            <span class="stepIndicator flex-1 pb-8 relative">Payment Details</span>
            <span class="stepIndicator flex-1 pb-8 relative">Summary</span>
        </div>
        <!-- end step indicators -->

        {{--        step one--}}
        <div class="mb-6 space-y-4">
            <div class="">
                <div class="flex flex-row space-x-3">
                    <div>
                        <label for="sell-currency" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Currency</label>
                        <select wire:model="currency" id="sell-currency" name="sell-currency"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required disabled>
                            <option selected value="usd">USD</option>
                            <option value="eur">EUR</option>
                            <option value="rub">RUB</option>
                        </select>
                    </div>
                    <div>
                        <label for="sell-amount" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Amount
                            $ <strong
                                class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">min
                                100 USD</strong></label>
                        <input wire:model="fiatUsd" type="number" min="100" max="10000" id="sell-amount"
                               name="sell-amount"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="200" required/>

                    </div>
                </div>
                <div
                    class="mt-3 flex items-center space-x-2 text-gray-800 dark:text-gray-300 text-xs font-medium select-none">
                        <span wire:click="setUsd(100)"
                              class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">100</span>
                    <span wire:click="setUsd(150)"
                          class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">150</span>
                    <span wire:click="setUsd(300)"
                          class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">200</span><span
                        wire:click="setUsd(300)"
                        class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">300</span><span
                        wire:click="setUsd(300)"
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
                <div>
                    <label for="buy-amount" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Amount
                        ₽</label>
                    <input wire:model="fiatUsd" type="number" min="100" max="100000" id="buy-amount" name="buy-amount"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="200" required/>
                </div>

            </div>
            <span
                class="block mt-4 text-sm text-gray-500 dark:text-gray-300">*Price per dollar{{ $cashier->price_per_dollar }}</span>
            <span class="block text-sm text-gray-500 dark:text-gray-300">*Minimal amount to purchase is 100 USD</span>
        </div>
        {{--        step two--}}

        <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition duration-150 ease-in-out">
            Next
        </button>
    </form>
</div>
