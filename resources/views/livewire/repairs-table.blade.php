<div>
    <!-- Top Action Bar -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <!-- Add Button -->
        <button wire:click="openAddModal"
            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm font-medium">
            <span class="inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Repair
            </span>
        </button>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Status Filter -->
            <select wire:model.live="statusFilter"
                class="px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="working">Working</option>
                <option value="finished">Finished</option>
                <option value="pickedup">Archived</option>
            </select>

            <!-- Search Box -->
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Search repairs..."
                   class="px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($repairs as $repair)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Tracking Code -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-xs font-mono bg-slate-100 px-2 py-1 rounded">{{ $repair->tracking_code }}</span>
                            </td>

                            <!-- Customer -->
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $repair->customer_name }}</div>
                                <div class="text-xs text-gray-500">{{ $repair->customer_phone }}</div>
                            </td>

                            <!-- Device -->
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $repair->device_type }}</td>

                            <!-- Issue -->
                            <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate" title="{{ $repair->issue_description }}">{{ $repair->issue_description }}</td>

                            <!-- Status with Inline Dropdown -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <select wire:change="updateStatus({{ $repair->id }}, $event.target.value)"
                                    class="text-xs px-2 py-1 rounded border-0 focus:ring-2 focus:ring-blue-500 cursor-pointer
                                        {{ $repair->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $repair->status === 'working' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $repair->status === 'finished' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $repair->status === 'pickedup' ? 'bg-purple-100 text-purple-700' : '' }}">
                                    <option value="pending" {{ $repair->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="working" {{ $repair->status === 'working' ? 'selected' : '' }}>Working</option>
                                    <option value="finished" {{ $repair->status === 'finished' ? 'selected' : '' }}>Finished</option>
                                    <option value="pickedup" {{ $repair->status === 'pickedup' ? 'selected' : '' }}>Picked Up</option>
                                </select>
                            </td>

                            <!-- Price -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-green-600">
                                {{ number_format(($repair->price_amount ?? 0) / 100, 2) }} {{ getCurrencySymbol($repair->shop_id) }}
                            </td>

                            <!-- Created -->
                            <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-500" title="{{ $repair->created_at->format('M d, Y h:i A') }}">
                                {{ $repair->created_at->diffForHumans() }}
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="openEditModal({{ $repair->id }})"
                                        class="p-1 text-blue-600 hover:bg-blue-50 rounded transition"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    @if(!($isEmployee ?? false))
                                    <button wire:click="deleteRepair({{ $repair->id }})"
                                        onclick="return confirm('Are you sure you want to delete this repair?')"
                                        class="p-1 text-red-600 hover:bg-red-50 rounded transition"
                                        title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2 text-sm font-medium">No repairs found</p>
                                <p class="text-xs mt-1">Add your first repair to get started</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $repairs->links() }}
        </div>
    </div>

    <!-- Modal (Add/Edit) -->
    @if ($showAddModal || $showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-y-auto"
            wire:click.self="{{ $editingRepairId ? 'closeEditModal' : 'closeAddModal' }}">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all my-4 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl flex-shrink-0">
                    <h2 class="text-xl font-bold text-white">{{ $editingRepairId ? 'Edit Repair' : 'Add New Repair' }}</h2>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Customer Name</label>
                        <input wire:model="customer_name" type="text" placeholder="Enter customer name"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Customer Phone</label>
                        <input wire:model="customer_phone" type="tel" placeholder="Enter phone number"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Device Type</label>
                        <input wire:model="device_type" type="text" placeholder="e.g., iPhone 13, Samsung Galaxy"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Issue Description</label>
                        <textarea wire:model="issue_description" placeholder="Describe the issue..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition"
                            rows="3"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Price Amount</label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-500 font-medium">$</span>
                            <input wire:model="price_amount" placeholder="0.00" type="number" step="0.01"
                                min="0"
                                class="w-full pl-8 pr-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Notes (Optional)</label>
                        <textarea wire:model="notes" placeholder="Additional notes..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition"
                            rows="2"></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-slate-50 rounded-b-xl flex gap-3 flex-shrink-0">
                    <button wire:click="{{ $editingRepairId ? 'closeEditModal' : 'closeAddModal' }}" type="button"
                        class="flex-1 px-4 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition font-medium">Cancel</button>
                    <button wire:click="saveRepair" type="button"
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">{{ $editingRepairId ? 'Update Repair' : 'Save Repair' }}</button>
                </div>
            </div>
        </div>
    @endif
</div>
