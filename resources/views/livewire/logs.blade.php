<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
                <th scope="col" class="px-6 py-3">
                    Data
                </th>
                <th scope="col" class="px-6 py-3">
                    Created At
                </th>
            </tr>
            </thead>
            <tbody>
            @if($activityLogs)
                @foreach($activityLogs as $activityLog)
                    <tr class="bg-white dark:border-gray-700 dark:odd:bg-gray-700 dark:even:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $activityLog->id }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $activityLog->user->first_name . ' ' . $activityLog->user->last_name }}
                        </th>
                        <td class="px-6 py-4">
                            <span class="text-lg text-w hite font-bold">{{ $activityLog->action }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            <pre class="pretty-json">{{ json_encode($activityLog->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </td>
                        <td class="px-6 py-4">
                            {{ $activityLog->created_at }}
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

        <div class="mt-4">
            {{ $activityLogs->links() }}
        </div>
    </div>
</div>
