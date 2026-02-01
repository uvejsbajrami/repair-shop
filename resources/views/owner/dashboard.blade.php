@extends('layouts.owner')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Overview</h2>
            <p class="text-gray-600 mt-1">Welcome back! <b>{{ $shop ? $shop->name : '' }}</b> Here's what's happening today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Repairs</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $repairs }}</p>
                    </div>
                    <div class="p-4 rounded-full" style="background-color: color-mix(in srgb, var(--primary-color) 15%, white);">
                        <svg class="w-8 h-8" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4">All time</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Repairs</p>
                        <p class="text-3xl font-bold text-orange-600 mt-2">{{ $activeRepairs }}</p>
                    </div>
                    <div class="bg-orange-100 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4">In progress</p>
            </div>
            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending Approvals</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingRepairs > 0 ? $pendingRepairs : 0 }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4">Awaiting action</p>
            </div>

            <!-- Card 4 -->
            @if (in_array(current_plan(), ['standard', 'pro']))
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Earnings This Month</p>
                            <p class="text-3xl font-bold mt-2" style="color: var(--accent-color);">
                                {{ number_format($monthlyEarnings / 100, 2) }}
                                {{ getCurrencySymbol($shop ? $shop->id : null) }}
                            </p>
                        </div>
                        <div class="p-4 rounded-full" style="background-color: color-mix(in srgb, var(--accent-color) 15%, white);">
                            <svg class="w-8 h-8" style="color: var(--accent-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs mt-4" style="color: {{ $earningsPercentage >= 0 ? 'var(--accent-color)' : '#dc2626' }};">
                        {{ $earningsPercentage >= 0 ? '+' : '' }}{{ $earningsPercentage }}% from last month
                    </p>
                </div>
            @endif
        </div>

        @if (in_array(current_plan(), ['standard', 'pro']))
            <!-- Additional Stats for Standard/Pro -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Completed This Month -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Completed This Month</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $completedThisMonth }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">Finished & picked up</p>
                </div>

                <!-- Ready for Pickup -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Ready for Pickup</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $readyForPickup }}</p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">Awaiting customer</p>
                </div>

                <!-- Employees -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Employees</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $employeeCount }}</p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">Active team members</p>
                </div>

                <!-- Subscription Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Subscription</p>
                            <p class="text-3xl font-bold mt-2 {{ $daysRemaining <= 7 ? 'text-red-600' : 'text-gray-800' }}">{{ $daysRemaining }}</p>
                        </div>
                        <div class="{{ $daysRemaining <= 7 ? 'bg-red-100' : 'bg-gray-100' }} p-4 rounded-full">
                            <svg class="w-8 h-8 {{ $daysRemaining <= 7 ? 'text-red-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs {{ $daysRemaining <= 7 ? 'text-red-500' : 'text-gray-500' }} mt-4">
                        {{ $daysRemaining <= 7 ? 'Renew soon!' : 'Days remaining' }}
                    </p>
                </div>
            </div>

            <!-- Quick Actions & Recent Repairs -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('owner.repairs') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">
                            <div class="p-2 rounded-full mr-3" style="background-color: color-mix(in srgb, var(--primary-color) 15%, white);">
                                <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Add Repair</span>
                        </a>
                        <a href="{{ route('owner.repairs') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">
                            <div class="bg-blue-100 p-2 rounded-full mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">View All Repairs</span>
                        </a>
                        <a href="{{ route('owner.employees.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">
                            <div class="bg-purple-100 p-2 rounded-full mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Manage Employees</span>
                        </a>
                        <a href="{{ route('owner.settings') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">
                            <div class="bg-gray-100 p-2 rounded-full mr-3">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Shop Settings</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Repairs -->
                <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Repairs</h3>
                        <a href="{{ route('owner.repairs') }}" class="text-sm font-medium hover:underline" style="color: var(--primary-color);">View all</a>
                    </div>
                    @if($recentRepairs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="pb-3">Customer</th>
                                        <th class="pb-3">Device</th>
                                        <th class="pb-3">Status</th>
                                        <th class="pb-3">Assigned To</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($recentRepairs as $repair)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3">
                                                <p class="font-medium text-gray-800">{{ $repair->customer_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $repair->customer_phone }}</p>
                                            </td>
                                            <td class="py-3">
                                                <p class="text-gray-700">{{ $repair->device_type }}</p>
                                                <p class="text-xs text-gray-500">{{ Str::limit($repair->issue_description, 30) }}</p>
                                            </td>
                                            <td class="py-3">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'working' => 'bg-blue-100 text-blue-800',
                                                        'finished' => 'bg-green-100 text-green-800',
                                                        'pickedup' => 'bg-gray-100 text-gray-800',
                                                    ];
                                                    $statusColor = $statusColors[$repair->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                                    {{ ucfirst($repair->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-gray-600">
                                                {{ $repair->assignedEmployee ? $repair->assignedEmployee->name : 'Unassigned' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-gray-500">No repairs yet</p>
                            <a href="{{ route('owner.repairs') }}" class="mt-2 inline-block text-sm font-medium" style="color: var(--primary-color);">Create your first repair</a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
