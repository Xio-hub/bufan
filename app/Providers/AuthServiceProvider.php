<?php

namespace App\Providers;

use App\Models\Introduction;
use App\Models\Material;
use App\Models\Panorama;
use App\Models\PanoramaSingleSpace;
use App\Models\PanoramaStyle;
use App\Models\Product;
use App\Models\ProductResource;
use App\Models\Space;
use App\Models\SpaceCategory;
use App\Models\SpaceResource;
use App\Models\Style;
use App\Models\StyleCategory;
use App\Models\StyleResource;
use App\Models\VerticalView;
use App\Policies\IntroductionPolicy;
use App\Policies\MaterialPolicy;
use App\Policies\PanoramaPolicy;
use App\Policies\PanoramaSingleSpacePolicy;
use App\Policies\PanoramaStylePolicy;
use App\Policies\ProductPolicy;
use App\Policies\ProductResourcePolicy;
use App\Policies\SpacePolicy;
use App\Policies\SpaceResourcePolicy;
use App\Policies\StyleCategoryPolicy;
use App\Policies\StylePolicy;
use App\Policies\StyleResourcePolicy;
use App\Policies\VerticalViewPolicy;
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
        Product::class => ProductPolicy::class,
        Space::class => SpacePolicy::class,
        SpaceCategory::class => SpaceCategory::class,
        Style::class => StylePolicy::class,
        StyleCategory::class => StyleCategoryPolicy::class,
        Material::class => MaterialPolicy::class,
        Panorama::class => PanoramaPolicy::class,
        PanoramaStyle::class => PanoramaStylePolicy::class,
        VerticalView::class => VerticalViewPolicy::class,
        Introduction::class => IntroductionPolicy::class,
        PanoramaSingleSpace::class => PanoramaSingleSpacePolicy::class,
        ProductResource::class => ProductResourcePolicy::class,
        SpaceResource::class => SpaceResourcePolicy::class,
        StyleResource::class => StyleResourcePolicy::class,
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
