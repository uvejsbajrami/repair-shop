<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Export Repairs</h1>
        <p class="text-gray-600 mt-1">Export your repairs data to Excel/CSV format</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <input type="text" id="search" wire:model.live.debounce.300ms="search"
                           placeholder="Search by tracking code or customer name..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-48">
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="statusFilter" wire:model.live="statusFilter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="working">Working</option>
                    <option value="finished">Finished</option>
                    <option value="pickedup">Picked Up</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex flex-wrap gap-4 items-center">
        <button type="button" wire:click="exportAll"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export All
        </button>

        <button type="button" wire:click="exportSelected"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                @if(count($selectedIds) === 0) disabled @endif>
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Export Selected ({{ count($selectedIds) }})
        </button>

        <label class="inline-flex items-center ml-auto cursor-pointer">
            <input type="checkbox" wire:model.live="selectAll"
                   class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
            <span class="ml-2 text-gray-700">Select All</span>
        </label>
    </div>

    <!-- Repairs Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <span class="sr-only">Select</span>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($repairs as $index => $repair)
                        <tr class="hover:bg-gray-50" wire:key="repair-{{ $repair->id }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" wire:model.live="selectedIds" value="{{ $repair->id }}"
                                       class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-mono text-blue-600">{{ $repair->tracking_code }}</td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-900">{{ $repair->customer_name }}</div>
                                <div class="text-sm text-gray-500">{{ $repair->customer_phone }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $repair->device_type }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'working' => 'bg-blue-100 text-blue-800',
                                        'finished' => 'bg-green-100 text-green-800',
                                        'pickedup' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $color = $statusColors[$repair->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $color }}">
                                    {{ ucfirst($repair->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $repair->price_amount ? number_format($repair->price_amount / 100, 2) : '-' }} {{ getCurrencySymbol($repair->shop_id) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $repair->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                No repairs found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($repairs->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $repairs->links() }}
            </div>
        @endif
    </div>
</div>
