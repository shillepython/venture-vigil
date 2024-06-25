<x-action-section>
    <x-slot name="title">
        {{ __('Document Verification') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Verify your identity by providing the required documents.') }}
    </x-slot>

    <x-slot name="content">
        <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                    @if ($isVerified && $verifiedStatus)
                        {{ __('Your documents are verified.') }}
                    @else
                        {{ __('Your documents are not verified yet.') }}
                    @endif
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    @if ($isVerified && $verifiedStatus)
                        {{ __('Your credentials have been verified') }}
                    @elseif($isVerified && !$verifiedStatus)
                        {{ __('Wait for confirmation of your documents to start trading.') }}
                    @else
                        {{ __('For regulatory compliance, we require all investors to submit government-issued identification documents to verify their identity before investing.') }}
                    @endif
                </p>
            </div>
            @if (!$isVerified && !$verifiedStatus)
                <form wire:submit.prevent="submit">
                    <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <livewire:custom-dropzone
                                    wire:model="passportFront"
                                    :rules="['mimes:png,jpg,jpeg,svg,gif', 'max:10420']"
                                    :multiple="true"
                                    :label="__('Passport Front')"
                                />
                                @error('passportFront') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            {{--                            Passport Back--}}
                            <div class="sm:col-span-1">
                                <livewire:custom-dropzone
                                    wire:model="passportBack"
                                    :rules="['mimes:png,jpg,jpeg,svg,gif', 'max:10420']"
                                    :multiple="true"
                                    :label="__('Passport Back')"
                                />
                                @error('passportBack') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            {{--                            Proof of Address--}}
                            <div class="sm:col-span-2">
                                <livewire:custom-dropzone
                                    wire:model="proofOfAddress"
                                    :rules="['mimes:png,jpg,jpeg,svg,gif', 'max:10420']"
                                    :multiple="true"
                                    :label="__('Proof of the Address')"
                                />
                                @error('proofOfAddress') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </dl>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150">
                        {{ __('Upload') }}
                    </button>
                </form>
                @if (session()->has('message'))
                    <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('message') }}
                    </div>
                 @endif
        @endif


    </x-slot>
</x-action-section>
