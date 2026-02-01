<div>
    <!-- Header with Add Button -->
    <div class="mb-6">
        <button wire:click="openAddModal"
            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm font-medium">
            <span class="inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('repairs.add_repair') }}
            </span>
        </button>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Pending Column -->
        <div class="bg-slate-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-lg text-slate-700 flex items-center">
                    <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                    {{ __('repairs.to_do') }}
                </h2>
                <span class="text-sm text-slate-500 bg-white px-2 py-1 rounded">{{ count($pending) }}</span>
            </div>
            <div class="repair-list space-y-3 min-h-[200px]" data-status="pending" id="pending-list">
                @forelse($pending as $repair)
                    <details
                        wire:key="repair-{{ $repair['id'] }}-{{ $repair['status'] }}"
                        class="repair-card bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-move border border-slate-200 group"
                        data-id="{{ $repair['id'] }}">
                        <summary class="flex items-center justify-between p-3 cursor-pointer list-none">
                            <div class="flex-1 min-w-0 flex items-center">
                                <svg class="w-4 h-4 text-slate-400 mr-2 transition-transform group-open:rotate-180"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                <p class="font-semibold text-slate-800 text-sm truncate">
                                    {{ $repair['device_type'] ?? 'N/A' }} - {{ $repair['customer_name'] ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center space-x-1 ml-2">
                                <button wire:click.stop="openEditModal({{ $repair['id'] }})"
                                    class="p-1 text-blue-600 hover:bg-blue-50 rounded transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                @if(!($isEmployee ?? false))
                                <button wire:click.stop="deleteRepair({{ $repair['id'] }})"
                                    class="p-1 text-red-600 hover:bg-red-50 rounded transition"
                                    wire:confirm="{{ __('repairs.confirm_delete') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </summary>
                        <div class="border-t border-slate-100 p-3 pt-2">
                            <p class="text-sm text-slate-600 mb-2">{{ $repair['issue_description'] ?? 'N/A' }}</p>
                            <div class="flex items-center justify-between text-xs mb-2">
                                <span class="text-slate-500 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $repair['customer_phone'] ?? 'N/A' }}
                                </span>
                                <span
                                    class="font-semibold text-green-600">{{ number_format(($repair['price_amount'] ?? 0) / 100, 2) }} {{ getCurrencySymbol($repair['shop_id'] ?? null) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                @if (!$isBasicPlan)
                                <span class="text-xs text-slate-500">{{ $repair['tracking_code'] ?? 'N/A' }}</span>
                                @else
                                <span class="text-xs text-slate-500">-</span>
                                @endif
                                <span
                                    class="inline-block px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">{{ __('repairs.high_priority') }}</span>
                            </div>
                        </div>
                    </details>
                @empty
                    <div class="text-center py-8 text-slate-400">
                        <p class="text-sm">{{ __('repairs.no_pending') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Working Column -->
        <div class="bg-green-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-lg text-slate-700 flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                    {{ __('repairs.working') }}
                </h2>
                <span class="text-sm text-slate-500 bg-white px-2 py-1 rounded">{{ count($working) }}</span>
            </div>
            <div class="repair-list space-y-3 min-h-[200px]" data-status="working" id="working-list">
                @forelse($working as $repair)
                    <details
                        wire:key="repair-{{ $repair['id'] }}-{{ $repair['status'] }}"
                        class="repair-card bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-move border-l-4 border-green-500 group"
                        data-id="{{ $repair['id'] }}">
                        <summary class="flex items-center justify-between p-3 cursor-pointer list-none">
                            <div class="flex-1 min-w-0 flex items-center">
                                <svg class="w-4 h-4 text-slate-400 mr-2 transition-transform group-open:rotate-180"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                <p class="font-semibold text-slate-800 text-sm truncate">
                                    {{ $repair['device_type'] ?? 'N/A' }} - {{ $repair['customer_name'] ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-1 ml-2">
                                <button wire:click.stop="openEditModal({{ $repair['id'] }})"
                                    class="p-1 text-blue-600 hover:bg-blue-50 rounded transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                @if(!($isEmployee ?? false))
                                <button wire:click.stop="deleteRepair({{ $repair['id'] }})"
                                    class="p-1 text-red-600 hover:bg-red-50 rounded transition"
                                    wire:confirm="{{ __('repairs.confirm_delete') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </summary>
                        <div class="border-t border-slate-100 p-3 pt-2">
                            <p class="text-sm text-slate-600 mb-2">{{ $repair['issue_description'] ?? 'N/A' }}</p>
                            <div class="flex items-center justify-between text-xs mb-2">
                                <span class="text-slate-500 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $repair['customer_phone'] ?? 'N/A' }}
                                </span>
                                <span
                                    class="font-semibold text-green-600">{{ number_format(($repair['price_amount'] ?? 0) / 100, 2) }} {{ getCurrencySymbol($repair['shop_id'] ?? null) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                @if (!$isBasicPlan)
                                <span class="text-xs text-slate-500">{{ $repair['tracking_code'] ?? 'N/A' }}</span>
                                @else
                                <span class="text-xs text-slate-500">-</span>
                                @endif
                                <span
                                    class="inline-block px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">{{ __('repairs.high_priority') }}</span>
                            </div>
                        </div>
                    </details>
                @empty
                    <div class="text-center py-8 text-slate-400">
                        <p class="text-sm">{{ __('repairs.no_working') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Finished Column -->
        <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-lg text-slate-700 flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                    {{ __('repairs.finished') }}
                </h2>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-slate-500 bg-white px-2 py-1 rounded">{{ count($finished) }}</span>
                    @if (count($finished) > 0)
                        <button wire:click="clearAllFinished"
                            wire:confirm="{{ __('repairs.confirm_clear_all') }}"
                            class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            {{ __('repairs.clear_all') }}
                        </button>
                    @endif
                </div>
            </div>
            <div class="repair-list space-y-3 min-h-[200px]" data-status="finished" id="finished-list">
                @forelse($finished as $repair)
                    <details
                        wire:key="repair-{{ $repair['id'] }}-{{ $repair['status'] }}"
                        class="repair-card bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-move border-l-4 border-blue-500 group"
                        data-id="{{ $repair['id'] }}">
                        <summary class="flex items-center justify-between p-3 cursor-pointer list-none">
                            <div class="flex-1 min-w-0 flex items-center">
                                <svg class="w-4 h-4 text-slate-400 mr-2 transition-transform group-open:rotate-180"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                <p class="font-semibold text-slate-800 text-sm truncate">
                                    {{ $repair['device_type'] ?? 'N/A' }} - {{ $repair['customer_name'] ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-1 ml-2">
                                <button wire:click.stop="archiveRepair({{ $repair['id'] }})"
                                    wire:confirm="{{ __('repairs.confirm_archive') }}"
                                    class="p-1 text-green-600 hover:bg-green-50 rounded transition"
                                    title="{{ __('repairs.status.pickedup') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                @if(!($isEmployee ?? false))
                                <button wire:click.stop="deleteRepair({{ $repair['id'] }})"
                                    class="p-1 text-red-600 hover:bg-red-50 rounded transition"
                                    wire:confirm="{{ __('repairs.confirm_delete') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </summary>
                        <div class="border-t border-slate-100 p-3 pt-2">
                            <p class="text-sm text-slate-600 mb-2">{{ $repair['issue_description'] ?? 'N/A' }}</p>
                            <div class="flex items-center justify-between text-xs mb-2">
                                <span class="text-slate-500 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $repair['customer_phone'] ?? 'N/A' }}
                                </span>
                                <span
                                    class="font-semibold text-green-600">{{ number_format(($repair['price_amount'] ?? 0) / 100, 2) }} {{ getCurrencySymbol($repair['shop_id'] ?? null) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                @if (!$isBasicPlan)
                                <span class="text-xs text-slate-500">{{ $repair['tracking_code'] ?? 'N/A' }}</span>
                                @else
                                <span class="text-xs text-slate-500">-</span>
                                @endif
                                <span
                                    class="inline-block px-2 py-1 text-xs font-medium text-slate-600 bg-slate-100 rounded">{{ __('repairs.completed') }}</span>
                            </div>
                        </div>
                    </details>
                @empty
                    <div class="text-center py-8 text-slate-400">
                        <p class="text-sm">{{ __('repairs.no_finished') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Enhanced Modal -->
    @if ($showAddModal || $showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-y-auto"
            wire:click.self="{{ $editingRepairId ? 'closeEditModal' : 'closeAddModal' }}">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all my-auto max-h-[90vh] flex flex-col">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl flex-shrink-0">
                    <h2 class="text-xl font-bold text-white">{{ $editingRepairId ? __('repairs.edit_repair') : __('repairs.add_new_repair') }}
                    </h2>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('repairs.customer_name') }}</label>
                        <input wire:model="customer_name" type="text" placeholder="{{ __('repairs.enter_customer_name') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('repairs.customer_phone') }}</label>
                        <input wire:model="customer_phone" type="tel" placeholder="{{ __('repairs.enter_phone') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    @if (!$isBasicPlan)
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('repairs.customer_email') }}</label>
                        <input wire:model="customer_email" type="email" placeholder="{{ __('repairs.enter_email') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('repairs.device_type') }}</label>
                        <input wire:model="device_type" type="text" placeholder="{{ __('repairs.enter_device') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('repairs.issue_description') }}</label>
                        <textarea wire:model="issue_description" placeholder="{{ __('repairs.describe_issue') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition"
                            rows="3"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('repairs.price_amount') }}</label>
                        <div class="flex items-center gap-2">
                            <input wire:model="price_amount" placeholder="0.00" type="number" step="0.01"
                                min="0"
                                class="flex-1 px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <span class="text-slate-700 font-semibold text-lg min-w-fit">
                                {{ getCurrencySymbol($shop_id ?? null) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('repairs.notes_optional') }}</label>
                        <textarea wire:model="notes" placeholder="{{ __('repairs.additional_notes') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition"
                            rows="2"></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-slate-50 rounded-b-xl flex gap-3 flex-shrink-0">
                    <button wire:click="{{ $editingRepairId ? 'closeEditModal' : 'closeAddModal' }}" type="button"
                        class="flex-1 px-4 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition font-medium">{{ __('repairs.cancel') }}</button>
                    <button wire:click="saveRepair" type="button"
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">{{ $editingRepairId ? __('repairs.update_repair') : __('repairs.save_repair') }}</button>
                </div>
            </div>
        </div>
    @endif

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        let sortableInstances = [];

        function initializeSortable() {
            // Destroy existing instances
            sortableInstances.forEach(instance => {
                if (instance && instance.destroy) {
                    instance.destroy();
                }
            });
            sortableInstances = [];

            const lists = ['pending-list', 'working-list', 'finished-list'];

            lists.forEach(listId => {
                const element = document.getElementById(listId);
                if (element) {
                    const sortable = new Sortable(element, {
                        group: 'shared-repairs',
                        animation: 200,
                        ghostClass: 'bg-blue-100',
                        dragClass: 'opacity-50',
                        handle: '.repair-card',
                        filter: '.text-center',
                        preventOnFilter: false,
                        onEnd: function(evt) {
                            const itemId = evt.item.getAttribute('data-id');
                            const newStatus = evt.to.getAttribute('data-status');
                            const oldStatus = evt.from.getAttribute('data-status');

                            // Only update if status actually changed
                            if (itemId && newStatus && newStatus !== oldStatus) {
                                @this.call('updateStatus', itemId, newStatus);
                            }
                        }
                    });
                    sortableInstances.push(sortable);
                }
            });
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeSortable);
        } else {
            initializeSortable();
        }

        // Reinitialize after Livewire updates
        document.addEventListener('livewire:navigated', initializeSortable);

        // For Livewire 3
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('morph.updated', ({el, component}) => {
                // Small delay to ensure DOM is fully updated
                setTimeout(initializeSortable, 50);
            });
        }
    </script>
@endpush
</div>
