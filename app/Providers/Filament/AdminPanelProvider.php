<?php

namespace App\Providers\Filament;

use App\Filament\Customs\CustomLoginResponse;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Register;
use App\Filament\Pages\Courses;
use App\Filament\Pages\HelpCenter;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Courses\Pages\ListCoursesBySubcategory;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\PostResource;
use App\Models\Category;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Assets\Js;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        FilamentAsset::register([
            Js::make('custom-script', asset("js/alpine.js")),
        ]);

        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->pages([])
            ->login()
            ->registration(Register::class)
            ->profile(EditProfile::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->userMenuItems([
                Action::make('Help Center')
                    ->url(fn(): string => HelpCenter::getUrl())
                    ->icon('heroicon-o-question-mark-circle')
                    ->hidden(fn(): bool =>  !Gate::check("is-member"))
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->viteTheme(['resources/css/filament/admin/theme.css', "resources/js/app.js"])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->topNavigation()
            ->breadcrumbs(false)
            ->spa();
    }

    public static function getResourcePageUrlPatters($resources)
    {
        return collect($resources)->map(fn($resource) => collect($resource::getPages())->map(fn($page) => $page->getPage()::getNavigationItemActiveRoutePattern()))->flatten();
    }
}
