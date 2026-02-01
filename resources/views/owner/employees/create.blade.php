@extends('layouts.owner')

@section('title', 'Add Employee')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Back Link -->
    <a href="{{ route('owner.employees.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-6">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Employees
    </a>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add Employee</h1>
        <p class="text-gray-600 mt-1">Invite a new employee to join your shop</p>
    </div>

    <!-- Plan Limit Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-blue-800">
                You have <strong>{{ $maxEmployees - $currentCount }}</strong> employee slot{{ ($maxEmployees - $currentCount) != 1 ? 's' : '' }} remaining
            </span>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('owner.employees.store') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="Enter employee's full name"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                       placeholder="employee@example.com"
                       required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    An invitation email will be sent to this address.
                </p>
            </div>

            <!-- Info Box -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-medium text-gray-800 mb-2">What happens next?</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        The employee will receive an invitation email
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        They'll set their own password via the invitation link
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Once accepted, they can start managing repairs
                    </li>
                </ul>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('owner.employees.index') }}"
                   class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Send Invitation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
