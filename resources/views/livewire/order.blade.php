<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Order ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Cashier Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Amount on RUB
                </th>
                <th scope="col" class="px-6 py-3">
                    Amount on USD
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Sumbit</span>
                </th>
            </tr>
            </thead>
            <tbody>
            @if($orders)
                @foreach($orders as $order)
                    @if($order->status === 1)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $order->id }}
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $order->user->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $order->cashier->title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $order->amount }}
                            </td>
                            <td class="px-6 py-4">
                                {{ ($order->amount / $order->cashier->price_per_dollar) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="sumbitAmmount({{ ($order->amount / $order->cashier->price_per_dollar) }}, {{ $order->user->id }}, {{ $order->id }})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Sumbit</button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
