<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('all.create_order') }}
        </h2>
    </x-slot>

    <div class="flex flex-col justify-center">
        <livewire:cashier-show :id="$id"/>
    </div>
</x-app-layout>
