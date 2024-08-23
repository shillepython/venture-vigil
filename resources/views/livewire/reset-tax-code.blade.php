<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="text-center">
                <th scope="col" class="px-6 py-3">
                    Full name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Check
                </th>
            </tr>
            </thead>
            <tbody>
            @if($resetTaxCodes)
                @foreach($resetTaxCodes as $resetTaxCode)
                    <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $resetTaxCode->user->first_name . ' ' . $resetTaxCode->user->last_name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $resetTaxCode->user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $resetTaxCode->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            <a class="flex items-center justify-center" href="{{ $resetTaxCode->receipt_path }}" download>
                                <img src="{{ $resetTaxCode->receipt_path }}" class="w-24">
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
