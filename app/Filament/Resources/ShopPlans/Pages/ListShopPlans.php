<?php

namespace App\Filament\Resources\ShopPlans\Pages;

use App\Filament\Resources\ShopPlans\ShopPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShopPlans extends ListRecords
{
    protected static string $resource = ShopPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
