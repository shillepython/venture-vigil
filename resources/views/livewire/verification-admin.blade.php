<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Verification ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    front
                </th>
                <th scope="col" class="px-6 py-3">
                    back
                </th>
                <th scope="col" class="px-6 py-3">
                    billing
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Sumbit</span>
                </th>
            </tr>
            </thead>
            <tbody>
            @if($verificationList)
                @foreach($verificationList as $verification)
                    @if($verification->status === 0)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $verification->id }}
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $verification->user->first_name }} {{ $verification->user->last_name }}
                            </th>
                            <td class="px-6 py-4">
                                <a href="{{ $verification->front_passport }}" download>
                                    <img src="{{ $verification->front_passport }}" class="w-24">
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ $verification->back_passport }}" download>
                                    <img src="{{ $verification->back_passport }}" class="w-24">
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ $verification->billing }}" download>
                                    <img src="{{ $verification->billing }}" class="w-24">
                                </a>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="sumbitVerification({{ $verification->id }})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Sumbit</button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="m-4">
            {{ $verificationList->links() }}
        </div>
    </div>
</div>
