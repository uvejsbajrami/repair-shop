<?php

namespace App\Filament\Resources\PlanApplications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PlanApplicationsTable
{
 public static function configure(Table $table): Table
 {
  return $table
   ->columns([
    TextColumn::make('id')
     ->numeric()
     ->sortable(),
    TextColumn::make('user_id')
     ->numeric()
     ->sortable(),
    TextColumn::make('user.name')
     ->label('User Name')
     ->searchable()
     ->sortable(),
    TextColumn::make('plan.name')
     ->label('Plan Name')
     ->searchable()
     ->sortable(),
    TextColumn::make('shop_name')
     ->searchable(),
    TextColumn::make('billing_cycle')
     ->badge(),
    TextColumn::make('duration_months')
     ->numeric()
     ->sortable(),
    TextColumn::make('type')
     ->badge()
     ->colors([
       'info' => fn($state): bool => $state === 'new',
       'primary' => fn($state): bool => $state === 'renewal',
      ])
     ->formatStateUsing(fn($state) => ucfirst($state))
     ->sortable(),
    TextColumn::make('status')
     ->badge()->colors([
       'warning' => fn($state): bool => $state === 'pending',
       'success' => fn($state): bool => $state === 'approved',
       'danger' => fn($state): bool => $state === 'rejected',
      ]),
    TextColumn::make('payment_status')
     ->label('Payment')
     ->badge()
     ->colors([
       'warning' => fn($state): bool => $state === 'awaiting_proof',
       'info' => fn($state): bool => $state === 'proof_submitted',
       'success' => fn($state): bool => $state === 'payment_verified',
       'danger' => fn($state): bool => $state === 'payment_rejected',
      ])
     ->formatStateUsing(fn($state) => match($state) {
       'awaiting_proof' => 'Awaiting Proof',
       'proof_submitted' => 'Proof Submitted',
       'payment_verified' => 'Verified',
       'payment_rejected' => 'Rejected',
       default => ucfirst($state ?? 'N/A'),
      }),
    IconColumn::make('payment_proof_path')
     ->label('Proof')
     ->boolean()
     ->trueIcon('heroicon-o-document-check')
     ->falseIcon('heroicon-o-document')
     ->trueColor('success')
     ->falseColor('gray'),
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
    SelectFilter::make('payment_status')
     ->options([
       'awaiting_proof' => 'Awaiting Proof',
       'proof_submitted' => 'Proof Submitted',
       'payment_verified' => 'Payment Verified',
       'payment_rejected' => 'Payment Rejected',
      ]),
    SelectFilter::make('status')
     ->options([
       'pending' => 'Pending',
       'approved' => 'Approved',
       'rejected' => 'Rejected',
      ]),
    Filter::make('has_proof')
     ->query(fn (Builder $query): Builder => $query->whereNotNull('payment_proof_path'))
     ->label('Has Payment Proof'),
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
