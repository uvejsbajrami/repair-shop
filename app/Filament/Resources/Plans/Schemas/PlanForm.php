<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('price_monthly')
                    ->required()
                    ->numeric(),
                TextInput::make('price_yearly')
                    ->required()
                    ->numeric(),
                TextInput::make('max_employees')
                    ->required()
                    ->numeric(),
                TextInput::make('max_active_repairs')
                    ->required()
                    ->numeric(),
                Toggle::make('drag_and_drop')
                    ->required(),
                Toggle::make('branding')
                    ->required(),
                Toggle::make('exports')
                    ->required(),
            ]);
    }
}
