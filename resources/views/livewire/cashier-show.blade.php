<div>
    <div class="mt-2 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50  dark:via-transparent">
            <form class="max-w-1/3 mx-auto" wire:submit="createOrder">
                <h3 class="dark:text-white text-md">Cashier: {{ $cashier->id }}</h3>
                <h3 class="dark:text-white text-md">Full name: {{ $cashier->full_name }}</h3>
                <h3 class="dark:text-white text-md">Card number: {{ $cashier->card_number }}</h3>

                <div class="mb-2 mt-5">
                    <label for="usd" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">You want to buy $</label>
                    <input wire:model="fiatUsd" type="text" id="usd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="200" required />
                    <span wire:click="setUsd(100)" class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-green-500">100</span>
                    <span wire:click="setUsd(150)" class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-green-500">150</span>
                    <span wire:click="setUsd(300)" class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-green-500">300</span>
                </div>
                <span class="block mb-5 text-sm font-medium text-gray-900 dark:text-white">Price per dollar{{ $cashier->price_per_dollar }}</span>

                <div class="mb-5">
                    <label for="fiat" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">The quantity to be sent</label>
                    <input type="text" id="fiat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Подтвердить</button>
            </form>

        </div>
    </div>
</div>
