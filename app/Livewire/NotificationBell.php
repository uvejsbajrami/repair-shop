<?php

namespace App\Livewire;

use App\Models\Shop;
use App\Models\ShopNotification;
use Livewire\Component;

class NotificationBell extends Component
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

    public function markAsRead($id)
    {
        $shopId = $this->getShopId();
        if (!$shopId) return;

        ShopNotification::where('id', $id)
            ->where('shop_id', $shopId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function markAllAsRead()
    {
        $shopId = $this->getShopId();
        if (!$shopId) return;

        ShopNotification::where('shop_id', $shopId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    protected function getShopId(): ?int
    {
        return Shop::where('owner_id', auth()->id())->value('id');
    }

    public function render()
    {
        $shopId = $this->getShopId();

        $unreadCount = 0;
        $notifications = collect();

        if ($shopId) {
            $unreadCount = ShopNotification::forShop($shopId)->unread()->count();
            $notifications = ShopNotification::forShop($shopId)
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();
        }

        return view('livewire.notification-bell', [
            'unreadCount' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }
}
