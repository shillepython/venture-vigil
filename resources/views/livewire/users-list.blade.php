<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="text-center">
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Full name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Balance
                </th>
                <th scope="col" class="px-6 py-3">
                    Success Rate
                </th>
                <th scope="col" class="px-6 py-3">
                    Minimal Deposit
                </th>
                <th scope="col" class="px-6 py-3">
                    Date registration
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            @if($users)
                @foreach($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-center">
                        <td class="px-6 py-4">
                            {{ $user->id }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->email }}
                        </th>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->balance }} USD
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->successRate }}%
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->min_deposit }} USD
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            @if(!$user->hasRole('admin') || Auth::user()->id === $user->id)
                                <button wire:click="editUser({{ $user->id }})" class="text-blue-600 hover:text-blue-900">Редактировать</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <!-- Модальное окно для редактирования -->
    @if($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-gray-800 opacity-75"></div>
            <div class="bg-gray-900 text-white rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
                <div class="mb-4">
                    <h3 class="text-lg leading-6 font-medium text-white">Редактировать пользователя</h3>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="mb-4">
                        <label for="first_name" class="block text-sm font-medium text-gray-300">First name</label>
                        <input type="text" wire:model="first_name" id="first_name" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="last_name" class="block text-sm font-medium text-gray-300">Last name</label>
                        <input type="text" wire:model="last_name" id="last_name" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-300">Phone</label>
                        <input type="text" wire:model="phone" id="phone" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="balance" class="block text-sm font-medium text-gray-300">Balance</label>
                        <input type="number" wire:model="balance" id="balance" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="minDeposit" class="block text-sm font-medium text-gray-300">Min deposit</label>
                        <input type="number" wire:model.live.debounce.1000ms="minDeposit" id="minDeposit" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="successRate" class="block text-sm font-medium text-gray-300">Success Rate</label>
                        <input type="number" wire:model.live="successRate" id="successRate" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                    </div>

                </div>

                <div class="mb-4">
                    <h3 class="text-lg leading-6 font-medium text-white">Настройки</h3>

                    @foreach(App\Enum\UserSettings::cases() as $setting)
                        <div class="mt-2">
                            <label for="setting-{{ $setting->value }}" class="flex items-center text-sm font-medium text-gray-300">
                                <input type="checkbox" id="setting-{{ $setting->value }}" wire:model="settings.{{ $setting->value }}" class="form-checkbox bg-gray-800 border-gray-600 text-blue-600" />
                                <span class="ml-2">{{ $setting->label() }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <label for="notification" class="block text-sm font-medium text-gray-300">Уведомление</label>
                    <textarea wire:model="notification" id="notification" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md" rows="3"></textarea>
                </div>

                <div class="flex justify-end mt-4">
                    <button wire:click="sendNotification" class="mr-3 inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700">Отправить уведомление</button>
                    <button wire:click="save" class="mr-3 inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">Сохранить</button>
                    <button wire:click="closeModal" class="inline-flex justify-center rounded-md border border-gray-500 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600">Отмена</button>
                </div>
            </div>
        </div>
    @endif
</div>
