@extends('layouts.owner')

@section('title', 'Employees')

@section('content')
 <div class="max-w-6xl mx-auto">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
   <div>
    <h1 class="text-2xl font-bold text-gray-800">Employees</h1>
    <p class="text-gray-600 mt-1">Manage your shop's employees</p>
   </div>

   @if($currentCount < $maxEmployees)
    <a href="{{ route('owner.employees.create') }}"
     class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
     <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
     </svg>
     Add Employee
    </a>
   @endif
  </div>

  <!-- Plan Limit Info -->
  <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
   <div class="flex items-center justify-between">
    <div class="flex items-center">
     <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
       d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
      </path>
     </svg>
     <span class="text-blue-800 font-medium">
      {{ $currentCount }} / {{ $maxEmployees == -1 ? 'Unlimited' : $maxEmployees }} employees
     </span>
    </div>
    @if($maxEmployees != -1 && $currentCount >= $maxEmployees)
     <a href="/#plansSection" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
      Upgrade plan for more
     </a>
    @endif
   </div>
  </div>

  <!-- Employees List -->
  @if($employees->count() > 0)
   <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
     <thead class="bg-gray-50">
      <tr>
       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Employee
       </th>
       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Status
       </th>
       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Invitation
       </th>
       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Joined
       </th>
       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Money Income
       </th>
       <th scope="col" class="relative px-6 py-3">
        <span class="sr-only">Actions</span>
       </th>
      </tr>
     </thead>
     <tbody class="bg-white divide-y divide-gray-200">
      @foreach($employees as $employee)
       @php
        $countMoneyIncome = \App\Models\Repair::where('assigned_employee_id', $employee->user_id)->whereIn('status', ['finished', 'pickedup'])->sum('price_amount');
       @endphp
       <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap">
         <div class="flex items-center">
          <div class="flex-shrink-0 h-10 w-10">
           <img class="h-10 w-10 rounded-full"
            src="https://ui-avatars.com/api/?name={{ urlencode($employee->user->name) }}&background=3B82F6&color=fff"
            alt="{{ $employee->user->name }}">
          </div>
          <div class="ml-4">
           <div class="text-sm font-medium text-gray-900">
            {{ $employee->user->name }}
           </div>
           <div class="text-sm text-gray-500">
            {{ $employee->user->email }}
           </div>
          </div>
         </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
         @if($employee->user->is_active)
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
           <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="3" />
           </svg>
           Active
          </span>
         @else
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
           <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="3" />
           </svg>
           Inactive
          </span>
         @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm">
         @if($employee->user->invitation_accepted_at)
          <span class="text-green-600 flex items-center">
           <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
           </svg>
           Accepted
          </span>
         @else
          <span class="text-yellow-600 flex items-center">
           <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
           </svg>
           Pending
          </span>
         @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
         @if($employee->user->invitation_accepted_at)
          {{ $employee->user->invitation_accepted_at->format('M d, Y') }}
         @else
          <span class="text-gray-400">-</span>
         @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
         <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          {{ number_format($countMoneyIncome / 100, 2) }} {{ getCurrencySymbol($employee->shop_id) }}
         </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
         <div class="flex items-center justify-end space-x-2">
          @if(!$employee->user->invitation_accepted_at)
           <form action="{{ route('owner.employees.resend', $employee) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-blue-600 hover:text-blue-900 p-1" title="Resend Invitation">
             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
              </path>
             </svg>
            </button>
           </form>
          @endif

          <form action="{{ route('owner.employees.toggle', $employee) }}" method="POST" class="inline">
           @csrf
           @method('PATCH')
           <button type="submit"
            class="{{ $employee->user->is_active ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }} p-1"
            title="{{ $employee->user->is_active ? 'Deactivate' : 'Activate' }}">
            @if($employee->user->is_active)
             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
             </svg>
            @else
             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
             </svg>
            @endif
           </button>
          </form>

          <form action="{{ route('owner.employees.destroy', $employee) }}" method="POST" class="inline"
           onsubmit="return confirm('Are you sure you want to remove this employee? This action cannot be undone.')">
           @csrf
           @method('DELETE')
           <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Remove Employee">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
             </path>
            </svg>
           </button>
          </form>
         </div>
        </td>
       </tr>
      @endforeach
     </tbody>
    </table>
   </div>
  @else
   <!-- Empty State -->
   <div class="bg-white rounded-xl shadow-sm p-12 text-center">
    <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-6">
     <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
       d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
      </path>
     </svg>
    </div>
    <h3 class="text-lg font-semibold text-gray-800 mb-2">No employees yet</h3>
    <p class="text-gray-600 mb-6">Add employees to help you manage repairs in your shop.</p>
    @if($maxEmployees > 0)
     <a href="{{ route('owner.employees.create') }}"
      class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
      </svg>
      Add Your First Employee
     </a>
    @else
     <p class="text-yellow-600 font-medium">Your current plan doesn't include employee management.</p>
     <a href="/#plansSection" class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-medium">
      Upgrade your plan
     </a>
    @endif
   </div>
  @endif
 </div>
@endsection