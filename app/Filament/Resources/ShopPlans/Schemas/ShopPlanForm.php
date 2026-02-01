<?php

namespace App\Filament\Resources\ShopPlans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ShopPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                    Select::make('shop_id')
                        ->label('Shop')
                        ->searchable()
                        ->options(fn () => \App\Models\Shop::pluck('name', 'id'))
                        ->required(),

                    Select::make('plan_id')
                        ->label('Plan')
                        ->searchable()
                        ->options(fn () => \App\Models\Plan::pluck('name', 'id'))
                        ->required(),
                    
                Select::make('billing_cycle')
                    ->options(['monthly' => 'Monthly', 'yearly' => 'Yearly'])
                    ->required(),
                TextInput::make('duration_months')
                    ->required()
                    ->numeric(),
                DatePicker::make('starts_at'),
                DatePicker::make('ends_at'),
                DatePicker::make('grace_ends_at'),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'active' => 'Active', 'grace' => 'Grace', 'expired' => 'Expired'])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
