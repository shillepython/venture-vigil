<div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50  dark:via-transparent">
            <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                {{ __('all.balance') }}: <span wire:model="balance">{{ $balance }}$</span>
            </h1>
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
