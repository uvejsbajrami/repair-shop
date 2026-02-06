<?php

namespace App\Livewire;

use App\Models\Shop;
use App\Models\Repair;
use App\Models\RepairLog;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class RepairsTable extends Component
{
    use WithPagination;

    public $isEmployee = false;
    public $showAddModal = false;
    public $showEditModal = false;
    public $editingRepairId = null;

    // Form fields
    public $customer_name = '';
    public $customer_phone = '';
    public $device_type = '';
    public $issue_description = '';
    public $price_amount = '';
    public $notes = '';
    public $status = 'pending';

    // Filter
    public $statusFilter = 'all';
    public $search = '';

    public function mount($isEmployee = false)
    {
        $this->isEmployee = $isEmployee;
    }

    protected $rules = [
        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'required|string|max:20',
        'device_type' => 'required|string|max:255',
        'issue_description' => 'required|string',
        'price_amount' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
        'status' => 'required|in:pending,working,finished,pickedup',
    ];

    private function getShop()
    {
        $user = auth()->user();

        if ($this->isEmployee && $user->employee) {
            return $user->employee->shop;
        }

        return Shop::where('owner_id', $user->id)->first();
    }

    private function isPlanExpired()
    {
        $shop = $this->getShop();

        if (!$shop) {
            $shop = Shop::with('shopPlan')->where('owner_id', auth()->id())->first();
        }

        if (!$shop || !$shop->shopPlan) {
            return false;
        }

        $shopPlan = $shop->shopPlan;
        $now = Carbon::now();

        // Real-time check: if grace period has ended, plan is expired
        if ($shopPlan->grace_ends_at && $now->gt(Carbon::parse($shopPlan->grace_ends_at))) {
            return true;
        }

        // Also check status field (for backwards compatibility)
        return $shopPlan->status === 'expired';
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
        $this->resetForm();
    }

    public function openEditModal($repairId)
    {
        $repair = Repair::findOrFail($repairId);

        $this->editingRepairId = $repair->id;
        $this->customer_name = $repair->customer_name;
        $this->customer_phone = $repair->customer_phone;
        $this->device_type = $repair->device_type;
        $this->issue_description = $repair->issue_description;
        $this->price_amount = $repair->price_amount ? $repair->price_amount / 100 : '';
        $this->notes = $repair->notes;
        $this->status = $repair->status;

        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function saveRepair()
    {
        if ($this->isPlanExpired()) {
            session()->flash('error', 'Your plan has expired. Please renew to continue.');
            return;
        }

        $this->validate();

        $shop = $this->getShop();
        $shopid = $shop->id;

        // Check active repairs limit (only for new repairs)
        if (!$this->editingRepairId) {
            $plan = $shop->shopPlan?->plan;
            $maxActiveRepairs = $plan?->max_active_repairs ?? 0;
            $currentActiveCount = $shop->repairs()
                ->whereIn('status', ['pending', 'working', 'finished'])
                ->count();

            if ($currentActiveCount >= $maxActiveRepairs) {
                session()->flash('error', __('repairs.max_active_repairs_reached', ['max' => $maxActiveRepairs]));
                return;
            }
        }

        $data = [
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'device_type' => $this->device_type,
            'issue_description' => $this->issue_description,
            'price_amount' => $this->price_amount ? (int)($this->price_amount * 100) : null,
            'notes' => $this->notes,
            'status' => $this->status,
        ];

        if ($this->editingRepairId) {
            $repair = Repair::find($this->editingRepairId);
            $oldStatus = $repair->status;

            $repair->update($data);

            // Log status change if status changed
            if ($oldStatus !== $this->status) {
                RepairLog::create([
                    'repair_id' => $repair->id,
                    'old_status' => $oldStatus,
                    'new_status' => $this->status,
                    'changed_by' => auth()->id(),
                ]);
            }
        } else {
            $data['shop_id'] = $shopid;

            // Generate short, unique tracking code (REP-123456)
            do {
                $data['tracking_code'] = 'REP-' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (Repair::where('tracking_code', $data['tracking_code'])->exists());

            Repair::create($data);
        }

        $this->closeAddModal();
        $this->closeEditModal();
        $this->resetPage();
    }

    public function deleteRepair($repairId)
    {
        // Employees cannot delete repairs
        if ($this->isEmployee) {
            session()->flash('error', 'You do not have permission to delete repairs.');
            return;
        }

        if ($this->isPlanExpired()) {
            session()->flash('error', 'Your plan has expired. Please renew to continue.');
            return;
        }

        Repair::findOrFail($repairId)->delete();
        $this->resetPage();
    }

    public function updateStatus($repairId, $newStatus)
    {
        if ($this->isPlanExpired()) {
            session()->flash('error', 'Your plan has expired. Please renew to continue.');
            return;
        }

        $repair = Repair::findOrFail($repairId);
        $oldStatus = $repair->status;

        $repair->update(['status' => $newStatus]);

        // Log status change
        if ($oldStatus !== $newStatus) {
            RepairLog::create([
                'repair_id' => $repair->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => auth()->id(),
            ]);
        }
    }

    private function resetForm()
    {
        $this->customer_name = '';
        $this->customer_phone = '';
        $this->device_type = '';
        $this->issue_description = '';
        $this->price_amount = '';
        $this->notes = '';
        $this->status = 'pending';
        $this->editingRepairId = null;
    }

    public function render()
    {
        $shop = $this->getShop();
        $shopid = $shop->id;

        $query = Repair::where('shop_id', $shopid);

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('customer_name', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $this->search . '%')
                  ->orWhere('device_type', 'like', '%' . $this->search . '%')
                  ->orWhere('tracking_code', 'like', '%' . $this->search . '%');
            });
        }

        $repairs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.repairs-table', [
            'repairs' => $repairs,
            'isEmployee' => $this->isEmployee,
        ]);
    }
}
