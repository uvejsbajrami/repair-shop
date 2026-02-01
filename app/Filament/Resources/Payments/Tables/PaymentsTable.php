<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('shop.name')
                    ->label('Shop')
                    ->searchable()
                    ->sortable()
                    ->default('N/A'),
                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->sortable(),
                TextColumn::make('paypal_order_id')
                    ->label('PayPal Order ID')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($state, $record) => number_format($state / 100, 2) . ' ' . $record->currency)
                    ->sortable(),
                TextColumn::make('duration_months')
                    ->label('Duration')
                    ->formatStateUsing(fn ($state) => $state . ' month(s)')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'paypal' => 'info',
                        'card' => 'primary',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
                SelectFilter::make('payment_method')
                    ->options([
                        'paypal' => 'PayPal',
                        'card' => 'Card',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
