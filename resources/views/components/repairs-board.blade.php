<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Repair;

class RepairsBoard extends Component
{
    public $pending = [];
    public $working = [];
    public $finished = [];

    // Fields for add/edit
    public $shop_id;
    public $assigned_employee_id;
    public $customer_name;
    public $customer_phone;
    public $device_type;
    public $issue_description;
    public $notes;
    public $price_amount;
    public $position;

    public $editRepairId;

    public $showAddModal = false;
    public $showEditModal = false;

    protected $rules = [
        'shop_id' => 'required|integer',
        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'nullable|string|max:50',
        'device_type' => 'required|string|max:255',
        'issue_description' => 'required|string',
        'notes' => 'nullable|string',
        'assigned_employee_id' => 'nullable|integer',
        'price_amount' => 'nullable|integer',
        'position' => 'nullable|integer',
    ];

    protected $listeners = ['updateStatus'];

    public function render()
    {
        $this->pending = Repair::where('status', 'pending')->orderBy('position')->get();
        $this->working = Repair::where('status', 'working')->orderBy('position')->get();
        $this->finished = Repair::where('status', 'finished')->orderBy('position')->get();

        return view('livewire.repairs-board');
    }

    public function openAddModal()
    {
        $this->reset([
            'shop_id', 'assigned_employee_id', 'customer_name', 'customer_phone', 
            'device_type', 'issue_description', 'notes', 'price_amount', 'position'
        ]);
        $this->showAddModal = true;
    }

    public function saveRepair()
    {
        $this->validate();

        Repair::create([
            'shop_id' => $this->shop_id,
            'assigned_employee_id' => $this->assigned_employee_id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'device_type' => $this->device_type,
            'issue_description' => $this->issue_description,
            'notes' => $this->notes,
            'price_amount' => $this->price_amount,
            'position' => $this->position ?? 0,
            'status' => 'pending',
        ]);

        $this->showAddModal = false;
    }

    public function openEditModal($id)
    {
        $repair = Repair::findOrFail($id);
        $this->editRepairId = $id;
        $this->shop_id = $repair->shop_id;
        $this->assigned_employee_id = $repair->assigned_employee_id;
        $this->customer_name = $repair->customer_name;
        $this->customer_phone = $repair->customer_phone;
        $this->device_type = $repair->device_type;
        $this->issue_description = $repair->issue_description;
        $this->notes = $repair->notes;
        $this->price_amount = $repair->price_amount;
        $this->position = $repair->position;
        $this->showEditModal = true;
    }

    public function updateRepair()
    {
        $this->validate();

        $repair = Repair::findOrFail($this->editRepairId);
        $repair->update([
            'shop_id' => $this->shop_id,
            'assigned_employee_id' => $this->assigned_employee_id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'device_type' => $this->device_type,
            'issue_description' => $this->issue_description,
            'notes' => $this->notes,
            'price_amount' => $this->price_amount,
            'position' => $this->position ?? 0,
        ]);

        $this->showEditModal = false;
    }

    public function updateStatus($id, $status)
    {
        $repair = Repair::findOrFail($id);
        $repair->update(['status' => $status]);
    }
}
