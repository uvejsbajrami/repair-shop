<?php

namespace App\Livewire;

use App\Models\Shop;
use App\Models\Repair;
use App\Models\RepairLog;
use Carbon\Carbon;
use Livewire\Component;

class RepairsBoard extends Component
{
 public $pending = [];
 public $working = [];
 public $finished = [];
 public $shop_id = null;
 public $isEmployee = false;

 public $showAddModal = false;
 public $showEditModal = false;

 public $customer_name = '';
 public $customer_phone = '';
 public $customer_email = '';
 public $device_type = '';
 public $issue_description = '';
 public $price_amount = '';
 public $notes = '';
 public $editingRepairId = null;

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

 private function isBasicPlan()
 {
  $shop = $this->getShop();

  if (!$shop) {
   $shop = Shop::with('shopPlan.plan')->where('owner_id', auth()->id())->first();
  }

  if (!$shop || !$shop->shopPlan || !$shop->shopPlan->plan) {
   return false;
  }

  return $shop->shopPlan->plan->slug === 'basic';
 }

 public function mount($isEmployee = false)
 {
  $this->isEmployee = $isEmployee;
  $this->loadRepairs();
 }

 public function loadRepairs()
 {
  $shop = $this->getShop();
  $shopid = $shop?->id;
  $this->shop_id = $shopid;

  if (!$shopid) {
   $this->pending = [];
   $this->working = [];
   $this->finished = [];
   return;
  }

  $this->pending = Repair::where('shop_id', $shopid)
   ->where('status', 'pending')
   ->get()
   ->toArray();

  $this->working = Repair::where('shop_id', $shopid)
   ->where('status', 'working')
   ->get()
   ->toArray();

  $this->finished = Repair::where('shop_id', $shopid)
   ->where('status', 'finished')
   ->get()
   ->toArray();
 }

 public function openAddModal()
 {
  $this->showAddModal = true;
 }

 public function closeAddModal()
 {
  $this->showAddModal = false;
  $this->resetForm();
 }

 public function openEditModal($repairId)
 {
  $this->editingRepairId = $repairId;
  $repair = Repair::find($repairId);

  if ($repair) {
   $this->customer_name = $repair->customer_name;
   $this->customer_phone = $repair->customer_phone;
   $this->customer_email = $repair->customer_email ?? '';
   $this->device_type = $repair->device_type;
   $this->issue_description = $repair->issue_description;
   $this->price_amount = $repair->price_amount ? $repair->price_amount / 100 : '';
   $this->notes = $repair->notes;
  }

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

  $isEmployeeId = auth()->user()?->isEmployee() ? auth()->id() : null;

  $data = [
   'assigned_employee_id' => $isEmployeeId,
   'customer_name' => $this->customer_name,
   'customer_phone' => $this->customer_phone,
   'customer_email' => $this->customer_email ?: null,
   'device_type' => $this->device_type,
   'issue_description' => $this->issue_description,
   'price_amount' => $this->price_amount ? (int)($this->price_amount * 100) : null,
   'notes' => $this->notes,
  ];

  
  if ($this->editingRepairId) {
   $repair = Repair::find($this->editingRepairId);
   $repair->update($data);
  } else {
   // Generate a unique tracking code
   $data['shop_id'] = $shopid;
   $data['status'] = 'pending';

   // Generate short, unique tracking code (REP-123456)
   do {
    $data['tracking_code'] = 'REP-' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
   } while (Repair::where('tracking_code', $data['tracking_code'])->exists());

   $repair = Repair::create($data);

   // Queue tracking code email if customer email is provided (Standard/Pro plans only)
   if ($this->customer_email && !$this->isBasicPlan()) {
    \Mail::to($this->customer_email)->queue(new \App\Mail\SendRepairTrackCode($repair));
   }
  }

  $this->loadRepairs();
  $this->closeAddModal();
  $this->closeEditModal();
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

  Repair::find($repairId)?->delete();
  $this->loadRepairs();
 }

 public function updateStatus($repairId, $newStatus)
 {
  if ($this->isPlanExpired()) {
   session()->flash('error', 'Your plan has expired. Please renew to continue.');
   return;
  }

  Repair::find($repairId)?->update(['status' => $newStatus]);
  $this->loadRepairs();
 }

 public function resetForm()
 {
  $this->customer_name = '';
  $this->customer_phone = '';
  $this->customer_email = '';
  $this->device_type = '';
  $this->issue_description = '';
  $this->price_amount = '';
  $this->notes = '';
  $this->editingRepairId = null;
 }
 public function archiveRepair($repairId)
 {
  if ($this->isPlanExpired()) {
   session()->flash('error', 'Your plan has expired. Please renew to continue.');
   return;
  }

  $repair = Repair::find($repairId);

  if ($repair) {
   $oldStatus = $repair->status;

   // Update repair status to pickedup
   $repair->update(['status' => 'pickedup']);

   // Log the status change
   RepairLog::create([
    'repair_id' => $repair->id,
    'old_status' => $oldStatus,
    'new_status' => 'pickedup',
    'changed_by' => auth()->id(),
   ]);
  }

  $this->loadRepairs();
 }

 public function clearAllFinished()
 {
  if ($this->isPlanExpired()) {
   session()->flash('error', 'Your plan has expired. Please renew to continue.');
   return;
  }

  foreach($this->finished as $repair) {
   $repairModel = Repair::find($repair['id']);

   if ($repairModel) {
    $oldStatus = $repairModel->status;

    // Update repair status to pickedup
    $repairModel->update(['status' => 'pickedup']);

    // Log the status change
    RepairLog::create([
     'repair_id' => $repairModel->id,
     'old_status' => $oldStatus,
     'new_status' => 'pickedup',
     'changed_by' => auth()->id(),
    ]);
   }
  }

  $this->loadRepairs();
 }

 public function render()
 {
  return view('livewire.repairs-board', [
   'isBasicPlan' => $this->isBasicPlan(),
   'isEmployee' => $this->isEmployee,
  ]);
 }
}
