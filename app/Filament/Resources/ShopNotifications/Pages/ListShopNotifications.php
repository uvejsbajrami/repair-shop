<?php

namespace App\Filament\Resources\ShopNotifications\Pages;

use App\Filament\Resources\ShopNotifications\ShopNotificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShopNotifications extends ListRecords
{
    protected static string $resource = ShopNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
