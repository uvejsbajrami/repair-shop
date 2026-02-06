<?php

namespace App\Filament\Resources\ShopSettings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Utilities\Set;

class ShopSettingForm
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
                TextInput::make('logo_path')
                    ->default(null),
                ColorPicker::make('primary_color')
                    ->required()
                    ->default('#2563eb'),
                ColorPicker::make('accent_color')
                    ->required()
                    ->default('#22c55e'),
                Select::make('currency_code')
                    ->options([
                        'EUR' => 'EUR',
                        'MKD' => 'MKD',
                        // 'USD' => 'USD', // Uncomment when needed
                    ])
                    ->live()
                ->afterStateUpdated(function (Set $set, ?string $state) {
                    if (!$state) {
                        $set('currency_symbol', '€');
                        return;
                    }
                    $currencySymbols = [
                        'EUR' => '€',
                        'MKD' => 'ден',
                        // 'USD' => '$', // Uncomment when needed
                    ];
                    $set('currency_symbol', $currencySymbols[$state] ?? '');
                })
                    ->required()
                    ->default('EUR'),
                Select::make('currency_symbol')
                    ->options([
                        '€' => '€',
                        'ден' => 'ден',
                        // '$' => '$', // Uncomment when needed
                    ])
                    ->required(),
                    
                Toggle::make('remove_branding')
                    ->required(),
                Select::make('language_code')
                    ->label('Language')
                    ->options([
                        'en' => 'English',
                        'sq' => 'Shqip (Albanian)',
                    ])
                    ->required()
                    ->default('en'),
            ]);
    }
}
