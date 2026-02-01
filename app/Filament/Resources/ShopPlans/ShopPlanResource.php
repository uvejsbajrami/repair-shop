<?php

namespace App\Filament\Resources\ShopPlans;

use App\Filament\Resources\ShopPlans\Pages\CreateShopPlan;
use App\Filament\Resources\ShopPlans\Pages\EditShopPlan;
use App\Filament\Resources\ShopPlans\Pages\ListShopPlans;
use App\Filament\Resources\ShopPlans\Schemas\ShopPlanForm;
use App\Filament\Resources\ShopPlans\Tables\ShopPlansTable;
use App\Models\ShopPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShopPlanResource extends Resource
{
    protected static ?string $model = ShopPlan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $recordTitleAttribute = 'ShopPlan';

    public static function form(Schema $schema): Schema
    {
        return ShopPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShopPlansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShopPlans::route('/'),
            'create' => CreateShopPlan::route('/create'),
            'edit' => EditShopPlan::route('/{record}/edit'),
        ];
    }
}
