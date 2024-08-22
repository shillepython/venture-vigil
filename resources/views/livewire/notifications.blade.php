<div>
    <div class="relative">
        <button wire:click="toggleNotifications" class="relative z-10 block text-sm text-gray-300 rounded-md p-2 focus:outline-none">
            {{__('Notification')}} <i class="fa fa-bell"></i>
            @if (auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
            @endif
        </button>

        @if ($showNotifications)
            <div class="absolute right-0 w-full mt-2 lg:w-80 dark:bg-gray-700 rounded-md shadow-lg z-20">
                <div class="py-2">
                    @forelse ($notifications as $notification)
                        <div class="px-4 py-2 border-b border-gray-300 flex justify-between items-center">
                            <div>
                                <p class="text-gray-300">{{ $notification->data['reason'] ?? 'Уведомление' }}</p>
                                @if(isset($notification->data['withdrawal_id']))
                                    <br>
                                    <p class="text-gray-400 text-sm">Вывод средств, сумма: {{ \App\Models\OrdersWithdrawal::find($notification->data['withdrawal_id'])->amount }}$</p>
                                @endif
                                <p class="text-sm text-gray-300">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <button wire:click="deleteNotification('{{ $notification->id }}')" class="text-red-600 hover:text-red-800">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    @empty
                        <p class="text-center text-gray-300">Нет новых уведомлений</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
