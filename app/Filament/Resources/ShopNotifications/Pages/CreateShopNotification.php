<?php

namespace App\Filament\Resources\ShopNotifications\Pages;

use App\Filament\Resources\ShopNotifications\ShopNotificationResource;
use App\Models\Shop;
use App\Models\ShopNotification;
use App\Models\ShopPlan;
use Filament\Resources\Pages\CreateRecord;

class CreateShopNotification extends CreateRecord
{
    protected static string $resource = ShopNotificationResource::class;

    protected function handleRecordCreation(array $data): ShopNotification
    {
        $sendTo = $data['send_to'];
        $targetStatus = $data['target_status'] ?? null;

        // Remove non-model fields before creating records
        unset($data['send_to'], $data['target_status']);

        $firstNotification = null;

        if ($sendTo === 'specific') {
            $firstNotification = ShopNotification::create($data);
        } elseif ($sendTo === 'status') {
            $shopIds = ShopPlan::where('status', $targetStatus)
                ->pluck('shop_id')
                ->unique()
                ->values();

            foreach ($shopIds as $shopId) {
                $notification = ShopNotification::create(array_merge($data, [
                    'shop_id' => $shopId,
                ]));

                if ($firstNotification === null) {
                    $firstNotification = $notification;
                }
            }
        } elseif ($sendTo === 'all') {
            $shopIds = Shop::pluck('id');

            foreach ($shopIds as $shopId) {
                $notification = ShopNotification::create(array_merge($data, [
                    'shop_id' => $shopId,
                ]));

                if ($firstNotification === null) {
                    $firstNotification = $notification;
                }
            }
        }

        return $firstNotification ?? ShopNotification::create($data);
    }
}
