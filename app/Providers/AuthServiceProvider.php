<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Product::class => \App\Policies\ProductPolicy::class,
        \App\Models\Space::class => \App\Policies\SpacePolicy::class,
        \App\Models\SpaceCategory::class => \App\Policies\SpaceCategoryPolicy::class,
        \App\Models\Style::class => \App\Policies\StylePolicy::class,
        \App\Models\StyleCategory::class => \App\Policies\StyleCategoryPolicy::class,
        \App\Models\Material::class => \App\Policies\MaterialPolicy::class,
        \App\Models\Panorama::class => \App\Policies\PanoramaPolicy::class,
        \App\Models\PanoramaStyle::class => \App\Policies\PanoramaStylePolicy::class,
        \App\Models\VerticalView::class => \App\Policies\VerticalViewPolicy::class,
        \App\Models\Introduction::class => \App\Policies\IntroductionPolicy::class,
        \App\Models\PanoramaSingleSpace::class => \App\Policies\PanoramaSingleSpacePolicy::class,
        \App\Models\ProductResource::class => \App\Policies\ProductResourcePolicy::class,
        \App\Models\SpaceResource::class => \App\Policies\SpaceResourcePolicy::class,
        \App\Models\StyleResource::class => \App\Policies\StyleResourcePolicy::class,
        \App\Models\IndexResource::class => \App\Policies\IndexResourcePolicy::class,
        \App\Models\Article::class => \App\Policies\ArticlePolicy::class,
        \App\Models\PanoramaSingleSpaceResource::class => \App\Policies\PanoramaSingleSpaceResourcePolicy::class, 
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
