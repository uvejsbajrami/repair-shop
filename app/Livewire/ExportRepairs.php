<?php

namespace App\Livewire;

use App\Models\Shop;
use App\Models\Repair;
use Livewire\Component;
use Livewire\WithPagination;

class ExportRepairs extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $selectedIds = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
        $this->selectAll = false;
        $this->selectedIds = [];
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
        $this->selectAll = false;
        $this->selectedIds = [];
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedIds = $this->getFilteredRepairIds();
        } else {
            $this->selectedIds = [];
        }
    }

    public function updatedSelectedIds()
    {
        $totalIds = count($this->getFilteredRepairIds());
        $this->selectAll = count($this->selectedIds) === $totalIds && $totalIds > 0;
    }

    private function getFilteredRepairIds()
    {
        $shopid = Shop::where('owner_id', auth()->id())->value('id');

        $query = Repair::where('shop_id', $shopid);

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }
       
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('customer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('tracking_code', 'like', '%' . $this->search . '%');
            });
        }

        return $query->pluck('id')->toArray();
    }

    public function exportAll()
    {
        return redirect()->route('owner.repairs.export');
    }

    public function exportSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $ids = implode(',', $this->selectedIds);
        return redirect()->route('owner.repairs.export', ['ids' => $ids]);
    }

    public function render()
    {
        $shopid = Shop::where('owner_id', auth()->id())->value('id');

        $query = Repair::where('shop_id', $shopid);

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('customer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('tracking_code', 'like', '%' . $this->search . '%');
            });
        }

        $repairs = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.export-repairs', [
            'repairs' => $repairs,
        ]);
    }
}
