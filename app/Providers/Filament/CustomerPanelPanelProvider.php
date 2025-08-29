<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Pages\Auth\EditProfile;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\CustomerPanel\Pages\CustomerPanel\Pages\Dashboard;
use App\Filament\CustomerPanel\Pages\CustomerPanel\Pages\CustomRegister;
use App\Http\Middleware\EnsureCustomerPanelAccess;

class CustomerPanelPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('customer')
            ->default()
            ->path('')
            ->login()
            ->profile(EditProfile::class)
            ->registration(CustomRegister::class)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/CustomerPanel/Resources'), for: 'App\\Filament\\CustomerPanel\\Resources')
            ->discoverPages(in: app_path('Filament/CustomerPanel/Pages'), for: 'App\\Filament\\CustomerPanel\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/CustomerPanel/Widgets'), for: 'App\\Filament\\CustomerPanel\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
                EnsureCustomerPanelAccess::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
