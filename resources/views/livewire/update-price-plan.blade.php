<?php

use Livewire\Volt\Component;

new class extends Component {
    public $slug;
    public $pricePerMonth = 0;
    public $priceCalculate = 0;
    public $selectedDuration = 1;

    public $durations = [
        1 => '1 Month',
        3 => '3 Months',
        6 => '6 Months',
        12 => '12 Months',
    ];

    public function mount($slug, $pricePerMonth)
    {
        $this->slug = strtolower($slug);
        $this->pricePerMonth = $pricePerMonth;
        $this->calculatePrice();
    }

    public function updatedSelectedDuration()
    {
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        // Fixed yearly prices with discount
        $yearlyPrices = [
            'basic' => 90,
            'standard' => 190,
            'pro' => 290,
        ];

        if ($this->selectedDuration == 12 && isset($yearlyPrices[$this->slug])) {
            $this->priceCalculate = $yearlyPrices[$this->slug];
        } else {
            $this->priceCalculate = $this->pricePerMonth * $this->selectedDuration;
        }
    }
};
?>

<div>
    <label for="duration_months" class="block text-sm font-medium text-gray-700 mb-1">
        Subscription Duration <span class="text-red-500">*</span>
    </label>
    <select id="duration_months" name="duration_months" required
        wire:model.live="selectedDuration"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @foreach ($durations as $months => $label)
            <option value="{{ $months }}">{{ $label }}</option>
        @endforeach
    </select>

    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Total Price:</span>
            <span class="text-xl font-bold text-blue-600">
                € {{ number_format($priceCalculate, 2) }} 
            </span>
        </div>
        @if ($selectedDuration == 12)
            <div class="mt-1 text-right">
                <span class="text-xs text-green-600 font-medium">15% discount applied!</span>
            </div>
        @endif
    </div>
</div>
