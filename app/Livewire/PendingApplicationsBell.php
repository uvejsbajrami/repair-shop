<?php

namespace App\Livewire;

use App\Models\PlanApplication;
use Livewire\Component;

class PendingApplicationsBell extends Component
{
    public bool $showDropdown = false;

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function closeDropdown()
    {
        $this->showDropdown = false;
    }

    public function getPendingCount()
    {
        return PlanApplication::where('status', 'pending')->count();
    }

    public function getPendingApplications()
    {
        return PlanApplication::with(['user', 'plan'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.pending-applications-bell', [
            'pendingCount' => $this->getPendingCount(),
            'applications' => $this->getPendingApplications(),
        ]);
    }
}
