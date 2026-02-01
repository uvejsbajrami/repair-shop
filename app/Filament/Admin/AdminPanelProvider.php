<?php

namespace App\Filament\Admin;

use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->middleware(['web', 'auth'])
            ->topNavigation()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources');
    }
}