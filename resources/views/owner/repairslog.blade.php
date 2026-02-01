@extends('layouts.owner')

@section('title', 'Dashboard')

@section('content')

    <div class="space-y-6">
        <!-- Page Header -->
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Repairs Logs</h2>
            <p class="text-gray-600 mt-1">Here are the recent repair status changes.</p>
        </div>

        <!-- Repairs Logs Table -->
        <div class="bg-white shadow rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Repair ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Previous Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($repairsLogs as $index => $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($log->old_status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($log->new_status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->updated_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection