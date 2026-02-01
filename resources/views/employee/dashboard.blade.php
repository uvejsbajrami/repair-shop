@extends('layouts.employee')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600 mt-1">Here's what's happening at {{ $shop->name }} today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Repairs -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Repairs</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $repairs }}</p>
                </div>
            </div>
        </div>

        <!-- Active Repairs -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Active Repairs</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $activeRepairs }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Repairs -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingRepairs }}</p>
                </div>
            </div>
        </div>

        <!-- Completed This Month -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Completed This Month</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $completedThisMonth }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('employee.repairs') }}"
               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="font-medium text-gray-800">View Repairs</p>
                    <p class="text-sm text-gray-500">See all repair tickets</p>
                </div>
            </a>

            <a href="{{ route('employee.repairs') }}?action=create"
               class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="font-medium text-gray-800">Create Repair</p>
                    <p class="text-sm text-gray-500">Add a new repair ticket</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Shop Info -->
    <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Shop Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Shop Name</p>
                <p class="font-medium text-gray-800">{{ $shop->name }}</p>
            </div>
            @if($shop->phone)
            <div>
                <p class="text-sm text-gray-500">Phone</p>
                <p class="font-medium text-gray-800">{{ $shop->phone }}</p>
            </div>
            @endif
            @if($shop->address)
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Address</p>
                <p class="font-medium text-gray-800">{{ $shop->address }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
