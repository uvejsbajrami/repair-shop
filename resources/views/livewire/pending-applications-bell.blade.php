<div x-data="{ open: false }">
    <!-- Bell Button -->
    <button
        @click="open = true"
        type="button"
        class="fi-icon-btn relative flex items-center justify-center rounded-lg outline-none transition duration-75 focus-visible:ring-2 w-9 h-9 text-gray-400 hover:text-gray-500 focus-visible:ring-primary-500/50 dark:text-gray-500 dark:hover:text-gray-400"
    >
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>

        @if ($pendingCount > 0)
            <span class="absolute -top-1 -end-1 flex items-center justify-center min-w-[1.25rem] h-5 px-1 text-[11px] font-bold text-white bg-red-500 rounded-full">
                {{ $pendingCount > 99 ? '99+' : $pendingCount }}
            </span>
        @endif
    </button>

    <!-- Slide-over Panel -->
    <template x-teleport="body">
        <div x-show="open" x-cloak class="relative z-50">
            <!-- Backdrop -->
            <div
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="open = false"
                class="fixed inset-0 bg-gray-900/50"
            ></div>

            <!-- Panel -->
            <div class="fixed inset-y-0 end-0 flex max-w-full">
                <div
                    x-show="open"
                    x-transition:enter="transform transition ease-out duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-sm"
                >
                    <div class="flex h-full flex-col bg-white shadow-xl dark:bg-gray-900">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div>
                                <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                                    Pending Applications
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $pendingCount }} awaiting review</p>
                            </div>
                            <button @click="open = false" class="rounded-lg p-1 text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 overflow-y-auto">
                            @forelse ($applications as $application)
                                <a
                                    href="{{ route('filament.admin.resources.plan-applications.edit', $application->id) }}"
                                    class="flex items-start gap-4 px-4 py-4 border-b border-gray-100 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50 transition"
                                >
                                    <div class="flex-shrink-0 w-10 h-10 bg-primary-100 dark:bg-primary-500/20 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $application->shop_name ?? 'Shop Application' }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $application->plan?->name ?? 'Plan' }} &middot; {{ ucfirst($application->billing_cycle ?? 'monthly') }}
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                            {{ $application->created_at?->diffForHumans() ?? 'Recently' }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400">
                                        Pending
                                    </span>
                                </a>
                            @empty
                                <div class="flex flex-col items-center justify-center py-12 px-4">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">All caught up!</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No pending applications</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer -->
                        @if ($pendingCount > 0)
                            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                                <a
                                    href="{{ route('filament.admin.resources.plan-applications.index') }}"
                                    class="flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-white bg-primary-600 rounded-lg hover:bg-primary-500 transition"
                                >
                                    View All Applications
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
