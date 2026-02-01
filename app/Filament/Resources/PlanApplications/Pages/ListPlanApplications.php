<?php

namespace App\Filament\Resources\PlanApplications\Pages;

use App\Filament\Resources\PlanApplications\PlanApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlanApplications extends ListRecords
{
    protected static string $resource = PlanApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
