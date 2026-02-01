<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ __('repairs.track_your_repair') }}</h1>
            <p class="text-gray-600">{{ __('repairs.enter_tracking_code') }}</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <form wire:submit.prevent="trackRepair">
                <div class="flex gap-3">
                    <input type="text" wire:model="tracking_code" placeholder="{{ __('repairs.tracking_placeholder') }}"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent uppercase" />
                    <button type="submit"
                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        {{ __('repairs.track') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Not Found Message -->
        @if ($notFound)
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-red-800 font-semibold">{{ __('repairs.repair_not_found') }}</h3>
                        <p class="text-red-600">{{ __('repairs.no_repair_with_code') }}: {{ strtoupper($tracking_code) }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Repair Details -->
        @if ($repair)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Status Header -->
                <div
                    class="px-6 py-4 {{ $repair->status === 'pending'
                        ? 'bg-yellow-500'
                        : ($repair->status === 'working'
                            ? 'bg-blue-500'
                            : ($repair->status === 'finished'
                                ? 'bg-green-500'
                                : 'bg-gray-500')) }} text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold">{{ strtoupper($repair->tracking_code) }}</h2>
                            <p class="text-sm opacity-90">{{ __('repairs.status.' . $repair->status) }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Repair Details -->
                <div class="p-6 space-y-4">
                    <!-- shop name -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">{{ __('repairs.shop_name') }}</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $repair->shop->name }}</p>
                        </div>
                    </div>
                    <!-- Customer Name -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400 mt-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">{{ __('repairs.customer_name') }}</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $repair->customer_name }}</p>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400 mt-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">{{ __('repairs.phone_number') }}</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $repair->customer_phone }}</p>
                        </div>
                    </div>

                    <!-- Device Type -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400 mt-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">{{ __('repairs.device_type') }}</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $repair->device_type }}</p>
                        </div>
                    </div>

                    <!-- Issue Description -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400 mt-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">{{ __('repairs.issue_description') }}</p>
                            <p class="text-gray-800">{{ $repair->issue_description }}</p>
                        </div>
                    </div>

                    <!-- Price (if available) -->
                    @if ($repair->price_amount && $repair->status === 'finished')
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400 mt-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">{{ __('repairs.price') }}</p>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ number_format($repair->price_amount / 100, 2) }}
                                    {{ getCurrencySymbol($repair->shop_id) }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Notes (if available) -->
                    @if ($repair->notes)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400 mt-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">{{ __('repairs.notes') }}</p>
                                <p class="text-gray-800">{{ $repair->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Status Timeline -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-3">{{ __('repairs.status_timeline') }}</p>
                        <div class="flex items-center justify-between">
                            <div
                                class="flex flex-col items-center {{ $repair->status === 'pending' || $repair->status === 'working' || $repair->status === 'finished' || $repair->status === 'pickedup' ? 'text-blue-600' : 'text-gray-300' }}">
                                <div
                                    class="w-8 h-8 rounded-full {{ $repair->status === 'pending' || $repair->status === 'working' || $repair->status === 'finished' || $repair->status === 'pickedup' ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-xs mt-1">{{ __('repairs.status.pending') }}</p>
                            </div>
                            <div
                                class="flex-1 h-1 {{ $repair->status === 'working' || $repair->status === 'finished' || $repair->status === 'pickedup' ? 'bg-blue-600' : 'bg-gray-300' }}">
                            </div>
                            <div
                                class="flex flex-col items-center {{ $repair->status === 'working' || $repair->status === 'finished' || $repair->status === 'pickedup' ? 'text-blue-600' : 'text-gray-300' }}">
                                <div
                                    class="w-8 h-8 rounded-full {{ $repair->status === 'working' || $repair->status === 'finished' || $repair->status === 'pickedup' ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-xs mt-1">{{ __('repairs.status.working') }}</p>
                            </div>
                            <div
                                class="flex-1 h-1 {{ $repair->status === 'finished' || $repair->status === 'pickedup' ? 'bg-blue-600' : 'bg-gray-300' }}">
                            </div>
                            <div
                                class="flex flex-col items-center {{ $repair->status === 'finished' || $repair->status === 'pickedup' ? 'text-blue-600' : 'text-gray-300' }}">
                                <div
                                    class="w-8 h-8 rounded-full {{ $repair->status === 'finished' || $repair->status === 'pickedup' ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-xs mt-1">{{ __('repairs.status.finished') }}</p>
                            </div>
                            <div
                                class="flex-1 h-1 {{ $repair->status === 'pickedup' ? 'bg-green-600' : 'bg-gray-300' }}">
                            </div>
                            <div
                                class="flex flex-col items-center {{ $repair->status === 'pickedup' ? 'text-green-600' : 'text-gray-300' }}">
                                <div
                                    class="w-8 h-8 rounded-full {{ $repair->status === 'pickedup' ? 'bg-green-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-xs mt-1">{{ __('repairs.status.pickedup') }}</p>
                                @if ($repair->status === 'pickedup')
                                    <p class="text-xs text-gray-600 mt-1">{{ App\Models\RepairLog::where('repair_id', $repair->id)->where('new_status', 'pickedup')->first()?->updated_at->format('Y-m-d H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back to Home Button -->
        <div class="text-center mt-8">
            <a href="/" class="text-blue-600 hover:text-blue-700 font-semibold">
                ← {{ __('repairs.back_to_home') }}
            </a>
        </div>
    </div>
</div>
