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
            <form wire:submit="saveKYC">
                <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Passport Front
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                <div class="sm:col-span-2">
                                </div></dd><dt class="text-sm font-medium text-gray-500 dark:text-gray-400 hidden">
                                Passport Front
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                <div class="flex items-center justify-center w-full">
                                    <label for="passportFrontInput" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"></path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                        </div>
                                        <input id="passportFrontInput" type="file" wire:model="passportFrontImage" accept="image/*">
                                    </label>
                                </div>

                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Passport Back
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                <div class="sm:col-span-2">
                                </div></dd><dt class="text-sm font-medium text-gray-500 dark:text-gray-400 hidden">
                                Passport Back
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                <div class="flex items-center justify-center w-full">
                                    <label for="passportBackInput" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"></path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                        </div>
                                        <input id="passportBackInput" type="file" wire:model="passportBackImage" accept="image/*">
                                    </label>
                                </div>
                            </dd>
                        </div><div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Proof of Address
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                <div class="sm:col-span-2">
                                </div></dd><dt class="text-sm font-medium text-gray-500 dark:text-gray-400 hidden">
                                Proof of Address
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                <div class="flex items-center justify-center w-full">
                                    <label for="proofOfAddressInput" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"></path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF, PNG or JPG (MAX. 1024x768px)</p>
                                        </div>
                                        <input id="proofOfAddressInput" type="file" wire:model="proofOfAddress" accept="image/*,application/pdf">
                                    </label>
                                </div>
                            </dd>
                        </div>

                    </dl>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150">
                    {{ __('Upload') }}
                </button>
            </form>
           @endif


    </x-slot>
</x-action-section>
