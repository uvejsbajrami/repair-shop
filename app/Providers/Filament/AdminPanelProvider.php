<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use App\Http\Middleware\AdminMiddleware;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationBuilder;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
 public function panel(Panel $panel): Panel
 {
  return $panel
   ->default()
   ->id('admin')
   ->path('admin')
   ->login()
   ->brandName('MobileShop')
   ->favicon(asset('favicon.svg'))
   ->colors([
    'primary' => Color::Blue,
   ])
   ->sidebarCollapsibleOnDesktop()
   ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
   ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
   ->pages([
    Dashboard::class,
   ])
   ->navigation(function (NavigationBuilder $navigation): NavigationBuilder {
    return $navigation
     ->groups([
      NavigationGroup::make()
       ->items([
        NavigationItem::make('Dashboard')
         ->icon('heroicon-o-home')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.pages.dashboard'))
         ->url(fn() => Dashboard::getUrl()),
       NavigationItem::make('Owner Dashboard')
         ->icon('heroicon-o-window')
         ->url(fn() => route('owner.dashboard')),
       ]),
      NavigationGroup::make()
       ->items([
        NavigationItem::make('Users')
         ->icon('heroicon-o-user-group')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.users.*'))
         ->url(fn() => app('App\Filament\Resources\Users\UserResource')->getUrl('index')),
       ]),
      NavigationGroup::make('Shop Management')
       ->items([
        NavigationItem::make('Shops')
         ->icon('heroicon-o-building-storefront')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.shops.*'))
         ->url(fn() => app('App\Filament\Resources\Shops\ShopResource')->getUrl('index')),
        NavigationItem::make('Shop Plans')
         ->icon('heroicon-o-calendar')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.shop-plans.*'))
         ->url(fn() => app('App\Filament\Resources\ShopPlans\ShopPlanResource')->getUrl('index')),
        NavigationItem::make('Shop Settings')
         ->icon('heroicon-o-cog-6-tooth')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.shop-settings.*'))
         ->url(fn() => app('App\Filament\Resources\ShopSettings\ShopSettingResource')->getUrl('index')),
       ]),
      NavigationGroup::make('Plans')
       ->items([
        NavigationItem::make('Plans')
         ->icon('heroicon-o-tag')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.plans.*'))
         ->url(fn() => app('App\Filament\Resources\Plans\PlanResource')->getUrl('index')),
        NavigationItem::make('Plan Applications')
         ->icon('heroicon-o-document-text')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.plan-applications.*'))
         ->url(fn() => app('App\Filament\Resources\PlanApplications\PlanApplicationResource')->getUrl('index')),
       ]),
      NavigationGroup::make('Billing')
       ->items([
        NavigationItem::make('Payments')
         ->icon('heroicon-o-credit-card')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.payments.*'))
         ->url(fn() => app('App\Filament\Resources\Payments\PaymentResource')->getUrl('index')),
       ]),
      NavigationGroup::make('Communication')
       ->items([
        NavigationItem::make('Notifications')
         ->icon('heroicon-o-bell')
         ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.shop-notifications.*'))
         ->url(fn() => app('App\Filament\Resources\ShopNotifications\ShopNotificationResource')->getUrl('index')),
       ]),
     ]);
   })
   ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
   ->widgets([
    AccountWidget::class,
    FilamentInfoWidget::class,
   ])
   ->middleware([
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    AuthenticateSession::class,
    ShareErrorsFromSession::class,
    VerifyCsrfToken::class,
    SubstituteBindings::class,
    DisableBladeIconComponents::class,
    DispatchServingFilamentEvent::class,
    AdminMiddleware::class,
   ])
   ->authMiddleware([
    Authenticate::class,
   ])
   ->renderHook(
    PanelsRenderHook::SIDEBAR_NAV_END,
    fn() => Blade::render('
                    @php
                        $pending = \App\Models\PlanApplication::where("status", "pending")->count();
                        $proofSubmitted = \App\Models\PlanApplication::where("payment_status", "proof_submitted")->count();
                    @endphp
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const navItems = document.querySelectorAll(".fi-sidebar-item");
                            navItems.forEach(item => {
                                const label = item.querySelector(".fi-sidebar-item-label");
                                if (label && label.textContent.trim() === "Plan Applications") {
                                    const badgeContainer = document.createElement("div");
                                    badgeContainer.className = "flex items-center gap-1 ms-auto";
                                    badgeContainer.innerHTML = `
                                        @if($pending > 0)
                                        <span class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-1.5 min-w-[theme(spacing.5)] py-0.5 bg-gray-100 text-gray-600 ring-gray-500/10 dark:bg-gray-500/10 dark:text-gray-400 dark:ring-gray-400/20">{{ $pending }}</span>
                                        @endif
                                        @if($proofSubmitted > 0)
                                        <span class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-1.5 min-w-[theme(spacing.5)] py-0.5 bg-blue-100 text-blue-600 ring-blue-500/10 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-400/20">{{ $proofSubmitted }}</span>
                                        @endif
                                    `;
                                    const button = item.querySelector(".fi-sidebar-item-button");
                                    if (button) {
                                        const existingBadge = button.querySelector(".fi-badge");
                                        if (existingBadge) existingBadge.remove();
                                        button.appendChild(badgeContainer);
                                    }
                                }
                            });
                        });
                    </script>
                ')
   );
 }
}
