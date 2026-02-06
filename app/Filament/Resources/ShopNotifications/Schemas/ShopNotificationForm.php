<?php

namespace App\Filament\Resources\ShopNotifications\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShopNotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Notification Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->required()
                            ->rows(4),
                        Select::make('type')
                            ->options([
                                'info' => 'Info',
                                'warning' => 'Warning',
                                'alert' => 'Alert',
                            ])
                            ->default('info')
                            ->required(),
                    ]),

                Section::make('Recipients')
                    ->schema([
                        Radio::make('send_to')
                            ->label('Send To')
                            ->options([
                                'specific' => 'Specific Shop',
                                'status' => 'All shops with status',
                                'all' => 'All Shops',
                            ])
                            ->default('specific')
                            ->required()
                            ->live(),
                        Select::make('shop_id')
                            ->label('Shop')
                            ->searchable()
                            ->options(fn () => \App\Models\Shop::pluck('name', 'id'))
                            ->required()
                            ->visible(fn ($get) => $get('send_to') === 'specific'),
                        Select::make('target_status')
                            ->label('Shop Status')
                            ->options([
                                'active' => 'Active',
                                'grace' => 'Grace',
                                'expired' => 'Expired',
                            ])
                            ->required()
                            ->visible(fn ($get) => $get('send_to') === 'status'),
                    ]),
            ]);
    }
}
