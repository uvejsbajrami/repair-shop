@extends('layouts.owner')

@section('title', 'Repairs')

@section('content')

@if (current_plan() === 'basic')
   @livewire('repairs-table')
@elseif (in_array(current_plan(), ['standard', 'pro']))
   @livewire('repairs-board')
@else
   <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
       <p class="font-medium">No Active Plan</p>
       <p class="text-sm mt-1">Please subscribe to a plan to manage repairs.</p>
   </div>
@endif

@endsection