<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Courses;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Courses\Pages\ListCoursesBySubcategory;
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
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->viteTheme(['resources/css/filament/admin/theme.css', "resources/js/app.js"])
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                $groups = Category::get()
                    ->map(function ($category) {
                        return NavigationGroup::make($category->name)
                            ->items(
                                $category->subCategories->map(
                                    fn($subCategory) => NavigationItem::make($subCategory->name)->url(CourseResource::getUrl("list", ["subcategory" => $subCategory->id]))->isActiveWhen(fn(): bool => request()->url() == CourseResource::getUrl("list", ["subcategory" => $subCategory->id]))
                                )->all()
                            )->collapsed();
                    })
                    ->push(
                        NavigationGroup::make('Administration')->items([
                            ...CategoryResource::getNavigationItems(),
                            ...CourseResource::getNavigationItems(),
                        ])->icon('heroicon-o-cog')->collapsed()
                    );

                return $builder
                    ->groups($groups->all())
                    ->items([
                        NavigationItem::make('Dashboard')
                            ->icon('heroicon-o-squares-2x2')
                            ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.dashboard'))
                            ->url(fn(): string => Dashboard::getUrl()),
                        NavigationItem::make('Community')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->isActiveWhen(fn(): bool => $this->getResourcePageUrlPatters([PostResource::class])->contains(fn($pattern) => request()->routeIs($pattern)))
                            ->url(fn(): string => PostResource::getUrl("index")),
                    ]);
            })
            ->sidebarFullyCollapsibleOnDesktop()
            ->spa();
    }

    public function getResourcePageUrlPatters($resources)
    {
        return collect($resources)->map(fn($resource) => collect($resource::getPages())->map(fn($page) => $page->getPage()::getNavigationItemActiveRoutePattern()))->flatten();
    }
}
