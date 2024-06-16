<div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-12">
    <h1 class="text-2xl font-bold text-white">RUB to USD</h1>
    <span class="text-gray-400">Convert Russian Rubles to United States Dollar</span>
    <form class="mx-auto p-6 mb-4" wire:submit="createOrder">
        <div class="mb-6">
            <div class="flex flex-row space-x-4 mb-8">
                <div>
                    <label for="sell-currency" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Currency</label>
                    <select id="sell-currency" name="sell-currency"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required disabled>
                        <option selected value="usd">USD</option>
                        <option value="eur">EUR</option>
                        <option value="rub">RUB</option>
                    </select>
                </div>
                <div>
                    <label for="sell-amount" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">You
                        want to buy
                        $</label>
                    <input wire:model.live.debounce.1000ms="fiatUsd" type="text" id="sell-amount" name="sell-amount"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="200" required/>
                    <div
                        class="mt-2 flex items-center space-x-2 text-gray-800 dark:text-gray-300 text-xs font-medium select-none">
                            <span wire:click="setUsd(100)"
                                  class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">100</span>
                        <span wire:click="setUsd(150)"
                              class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">150</span>
                        <span wire:click="setUsd(300)"
                              class="bg-gray-100 px-3 py-1 rounded dark:bg-gray-700 dark:hover:bg-green-500 transition-colors cursor-pointer">300</span>
                    </div>
                    <span class="text-sm text-red-800">{{ $minFiatUsdMessage }}</span>
                </div>

            </div>
            <div class="flex flex-row space-x-4">
                <div>
                    <label for="sell-currency" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Currency</label>
                    <select id="sell-currency" name="sell-currency"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required disabled>
                        <option value="usd">USD</option>
                        <option value="eur">EUR</option>
                        <option selected value="rub">RUB</option>
                    </select>
                </div>
                <div>
                    <label for="sell-amount" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Will cost</label>
                    <input wire:model.live="fiatRub" type="text" id="sell-amount" name="sell-amount"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="200" required/>
                </div>

            </div>
            <span
                class="block mt-4 text-sm text-gray-500 dark:text-gray-300">*Price per dollar{{ $cashier->price_per_dollar }}</span>
        </div>
        <button type="submit" {{ $enableSumbitStageOne ? '' : 'disabled' }}
                class="text-white {{ $enableSumbitStageOne ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-gray-600' }} bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto text-center transition duration-150 ease-in-out">
            Submit
        </button>
    </form>
</div>
