@extends('layouts.employee')

@section('title', __('common.repairs'))

@section('content')

@php
    $planSlug = $plan?->slug ?? 'basic';
@endphp

@if ($planSlug === 'basic')
   @livewire('repairs-table', ['isEmployee' => true])
@elseif (in_array($planSlug, ['standard', 'pro']))
   @livewire('repairs-board', ['isEmployee' => true])
@else
   <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
       <p class="font-medium">{{ __('dashboard.unable_to_load_repairs') }}</p>
       <p class="text-sm mt-1">{{ __('dashboard.issue_loading_repairs') }}</p>
   </div>
@endif

@endsection
