<?php

namespace App\Filament\Resources\ShopPlans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShopPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shop_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('shop.name')
                    ->label('Shop Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('plan.name')
                    ->label('Plan Name')
                    ->searchable(),
                TextColumn::make('billing_cycle')
                    ->badge(),
                TextColumn::make('duration_months')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('grace_ends_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()->colors([
                     'secondary' => fn ($state): bool => $state === 'pending',
                     'warning' => fn ($state): bool => $state === 'grace',
                     'success' => fn ($state): bool => $state === 'active',
                     'danger' => fn ($state): bool => $state === 'expired',
                    ]),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
