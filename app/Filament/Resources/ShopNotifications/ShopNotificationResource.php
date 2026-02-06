<?php

namespace App\Filament\Resources\ShopNotifications;

use App\Filament\Resources\ShopNotifications\Pages\CreateShopNotification;
use App\Filament\Resources\ShopNotifications\Pages\ListShopNotifications;
use App\Filament\Resources\ShopNotifications\Schemas\ShopNotificationForm;
use App\Filament\Resources\ShopNotifications\Tables\ShopNotificationsTable;
use App\Models\ShopNotification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ShopNotificationResource extends Resource
{
    protected static ?string $model = ShopNotification::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationLabel = 'Notifications';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ShopNotificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShopNotificationsTable::configure($table);
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
            'index' => ListShopNotifications::route('/'),
            'create' => CreateShopNotification::route('/create'),
        ];
    }
}
