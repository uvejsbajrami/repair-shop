<?php

namespace App\Filament\Resources\ShopPlans\Pages;

use App\Filament\Resources\ShopPlans\ShopPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditShopPlan extends EditRecord
{
    protected static string $resource = ShopPlanResource::class;

    

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
