@extends('layouts.employee')

@section('title', 'Repairs')

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
       <p class="font-medium">Unable to Load Repairs</p>
       <p class="text-sm mt-1">There was an issue loading the repairs board.</p>
   </div>
@endif

@endsection
