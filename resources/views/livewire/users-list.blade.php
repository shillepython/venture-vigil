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
                    Sales
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
                        @if(isset($user->sales))
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $user->sales->first_name }} {{ $user->sales->last_name }}
                            </td>
                        @else
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Не закреплён
                            </td>
                        @endif

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

        <div class="m-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Модальное окно для редактирования -->

    <x-dialog-modal wire:model.live="editUserModal">
        <x-slot name="title">
            {{ __('Редактировать пользователя') }}
        </x-slot>

        <x-slot name="content">
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
                <div class="mb-4">
                    <label for="taxCodeResetAmount" class="block text-sm font-medium text-gray-300">Tax code reset amount</label>
                    <input type="number" wire:model.live="taxCodeResetAmount" id="taxCodeResetAmount" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                </div>
            </div>

            @if(Auth::user()->hasRole('admin'))
                <div class="mb-4">
                    <h3 class="text-lg leading-6 font-medium text-white">Assign Sales User</h3>

                    <select wire:model="salesUserId" id="salesUserId" class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                        <option value="">Select Sales User</option>
                        @foreach($salesUsers as $salesUser)
                            <option value="{{ $salesUser->id }}" {{ $salesUser->id == $salesUserId ? 'selected' : '' }}>
                                {{ $salesUser->first_name }} {{ $salesUser->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg leading-6 font-medium text-white">Роли</h3>

                    <div class="mt-2">
                        <label for="salesRole" class="flex items-center text-sm font-medium text-gray-300">
                            <input type="checkbox" wire:model="hasSalesRole" id="salesRole" class="form-checkbox bg-gray-800 border-gray-600 text-blue-600">
                            <span class="ml-2">Sales Role</span>
                        </label>
                    </div>
                </div>
            @endif

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
        </x-slot>

        <x-slot name="footer">
            <button wire:click="sendNotification" class="mr-3 inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700">Отправить уведомление</button>

            <x-button class="mx-2 inline-flex items-center px-3 py-2 text-md font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 dark:focus:bg-red-700 dark:text-white focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" wire:click="closeEditUser" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-button>

            <x-button wire:click="save"
                      wire:loading.attr="disabled"
                      wire:target="paymentReceipt"
                      class="mx-2 inline-flex items-center px-3 py-2 text-md font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
            >
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
