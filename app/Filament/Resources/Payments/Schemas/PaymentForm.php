<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Payment Details')
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('shop_id')
                            ->label('Shop')
                            ->relationship('shop', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('plan_id')
                            ->label('Plan')
                            ->relationship('plan', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('duration_months')
                            ->label('Duration (Months)')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                    ]),

                Section::make('PayPal Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('paypal_order_id')
                            ->label('PayPal Order ID')
                            ->maxLength(255),
                        TextInput::make('paypal_payer_id')
                            ->label('PayPal Payer ID')
                            ->maxLength(255),
                    ]),

                Section::make('Amount & Status')
                    ->columns(2)
                    ->schema([
                        TextInput::make('amount')
                            ->label('Amount (in cents)')
                            ->numeric()
                            ->required()
                            ->helperText('Enter amount in cents (e.g., 1000 = 10.00 EUR)'),
                        Select::make('currency')
                            ->options([
                                'EUR' => 'EUR',
                                'USD' => 'USD',
                                'GBP' => 'GBP',
                            ])
                            ->default('EUR')
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'failed' => 'Failed',
                                'refunded' => 'Refunded',
                            ])
                            ->default('pending')
                            ->required(),
                        Select::make('payment_method')
                            ->options([
                                'paypal' => 'PayPal',
                                'card' => 'Card',
                            ])
                            ->nullable(),
                    ]),
            ]);
    }
}
