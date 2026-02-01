<?php

namespace App\Filament\Resources\Shops\Schemas;

use Filament\Schemas\Schema;
use App\Models\PlanApplication;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;

class ShopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
              Select::make('owner_id')
                ->label('Shop Owner')
                ->relationship(
                    name: 'owner',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query, $record) =>
                        $query->where(function ($q) use ($record) {
                            $q->whereHas('planApplications', fn ($sub) =>
                                $sub->where('status', 'pending')
                            );
                            // Also include the current owner when editing
                            if ($record?->owner_id) {
                                $q->orWhere('id', $record->owner_id);
                            }
                        })
                )
                ->searchable()
                ->preload()
                ->getOptionLabelFromRecordUsing(fn ($record) =>
                    "{$record->name} ({$record->email})"
                )
                ->live()
                ->afterStateUpdated(function (Set $set, ?string $state) {
                    if (!$state) {
                        $set('name', null);
                        $set('phone', null);
                        return;
                    }

                    $application = PlanApplication::where('user_id', $state)
                        ->where('status', 'pending')
                        ->latest()
                        ->first();

                    if ($application) {
                        $set('name', $application->shop_name);
                        $set('phone', $application->applicant_phone);
                    }
                })
                ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('address')
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
