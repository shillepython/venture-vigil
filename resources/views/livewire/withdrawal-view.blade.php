<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th class="py-3 px-6">ID</th>
            <th class="py-3 px-6">Пользователь</th>
            <th class="py-3 px-6">Баланс</th>
            <th class="py-3 px-6">Сумма вывода</th>
            <th class="py-3 px-6">Дата создания</th>
            <th class="py-3 px-6">Действия</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($withdrawals as $withdrawal)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">{{ $withdrawal->id }}</td>
                    <td class="px-6 py-4">{{ $withdrawal->user->first_name }} {{ $withdrawal->user->last_name }}</td>
                    <td class="px-6 py-4">{{ $withdrawal->balance }}</td>
                    <td class="px-6 py-4">{{ $withdrawal->amount }}</td>
                    <td class="px-6 py-4">{{ $withdrawal->created_at }}</td>
                    <td class="px-6 py-4">
                        <button wire:click="confirmAction({{ $withdrawal->id }}, 1)"
                                class="bg-green-500 text-white px-3 py-1 rounded">Подтвердить</button>
                        <button wire:click="confirmAction({{ $withdrawal->id }}, 2)"
                                class="bg-red-500 text-white px-3 py-1 rounded">Отклонить</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $withdrawals->links() }}

    @if ($confirmingAction)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white p-4 rounded shadow-lg w-1/2">
                <h2 class="text-xl font-bold mb-4">{{ $statusUpdate == 1 ? 'Подтверждение вывода' : 'Отклонение запроса' }}</h2>
                @if ($statusUpdate == 2)
                    <textarea wire:model="reason" class="w-full h-32 border border-gray-300 rounded p-2" placeholder="Причина отклонения (опционально)"></textarea>
                @endif
                <div class="flex justify-end mt-4">
                    <button wire:click="$set('confirmingAction', false)" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Отмена</button>
                    <button wire:click="updateWithdrawal" class="bg-blue-500 text-white px-3 py-1 rounded">Сохранить</button>
                </div>
            </div>
        </div>
    @endif
</div>
