<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use App\Filament\Pages\Auth\Login;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Traits\HasRoles;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Resources\KantorResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use Filament\Support\Facades\FilamentView;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Resources\DanaResource;
use App\Filament\Resources\KunjungannasabahResource;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
    /**
     * Customize the Filament admin panel.
     *
     * @param  \Filament\Panel  $panel
     * @return \Filament\Panel
     */
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\Resources\DataCountResource\Widgets\DataCount;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function boot()
    {
        FilamentView::registerRenderHook(PanelsRenderHook::HEAD_END, fn(): string => Blade::render('@vite(["resources/css/app.css", "resources/js/app.js"])'));
    }
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandLogo(asset('images/logo.png'))
            //->favicon(asset('images/favicon.ico'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                DataCount::class,
                //Widgets\FilamentInfoWidget::class,
            ])
            ->sidebarCollapsibleOnDesktop()
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->plugin(\TomatoPHP\FilamentPWA\FilamentPWAPlugin::make())
            // ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            //     return $builder->groups([
            //         NavigationGroup::make()
            //             ->items([
            //                 NavigationItem::make('Dashboard')
            //                     ->icon('heroicon-o-home')
            //                     ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
            //                     ->url(fn (): string => Dashboard::getUrl()),
            //             ]),
            //         NavigationGroup::make('Monitoring Bisnis')
            //             ->items([
            //                 ...KunjungannasabahResource::getNavigationItems(),
            //                 ...DanaResource::getNavigationItems(),
            //             ]),
            //         NavigationGroup::make('Setting')
            //             ->items([
            //                 ...UserResource::getNavigationItems(),
            //                 ...KantorResource::getNavigationItems(),

            //                 NavigationItem::make('Roles')
            //                     ->icon('heroicon-o-users')
            //                     ->isActiveWhen(fn (): bool => request()->routeIs([
            //                         'filament.admin.resources.roles.index',
            //                         'filament.admin.resources.roles.create',
            //                         'filament.admin.resources.roles.view',
            //                         'filament.admin.resources.roles.edit',
            //                     ]))
            //                     ->url(fn (): string => '/admin/roles'),
            //                 NavigationItem::make('Permission')
            //                     ->icon('heroicon-o-lock-closed')
            //                     ->isActiveWhen(fn (): bool => request()->routeIs([
            //                         'filament.admin.resources.permissions.index',
            //                         'filament.admin.resources.permissions.create',
            //                         'filament.admin.resources.permissions.view',
            //                         'filament.admin.resources.permissions.edit',
            //                     ]))
            //                     ->url(fn (): string => '/admin/permissions'),

            //             ]),
            //     ]);
            // });

            ->spa();
    }
}
