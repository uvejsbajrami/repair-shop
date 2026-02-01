<?php

namespace App\Filament\Resources\PlanApplications;

use App\Filament\Resources\PlanApplications\Pages\CreatePlanApplication;
use App\Filament\Resources\PlanApplications\Pages\EditPlanApplication;
use App\Filament\Resources\PlanApplications\Pages\ListPlanApplications;
use App\Filament\Resources\PlanApplications\Schemas\PlanApplicationForm;
use App\Filament\Resources\PlanApplications\Tables\PlanApplicationsTable;
use App\Models\PlanApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PlanApplicationResource extends Resource
{
    protected static ?string $model = PlanApplication::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'PlanApplication';

    public static function form(Schema $schema): Schema
    {
        return PlanApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlanApplicationsTable::configure($table);
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
            'index' => ListPlanApplications::route('/'),
            'create' => CreatePlanApplication::route('/create'),
            'edit' => EditPlanApplication::route('/{record}/edit'),
        ];
    }
}
