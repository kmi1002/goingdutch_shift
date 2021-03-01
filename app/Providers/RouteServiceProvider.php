<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapWebApiRoutes();

        $this->mapVendorRoutes();
        $this->mapVendorApiRoutes();

        $this->mapAdminRoutes();
        $this->mapAdminApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapWebApiRoutes()
    {
        Route::prefix('api')
             ->middleware('web')
             ->namespace($this->namespace.'\Api\User')
             ->name('api.')
             ->group(base_path('routes/webApi.php'));
    }

    protected function mapVendorRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/vendor.php'));
    }

    protected function mapVendorApiRoutes()
    {
        Route::prefix('api/vendor')
            ->middleware('web')
            ->namespace($this->namespace.'\Api\Vendor')
            ->name('api.vendor.')
            ->group(base_path('routes/vendorApi.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    protected function mapAdminApiRoutes()
    {
        Route::prefix('api/admin')
            ->middleware('web')
            ->namespace($this->namespace.'\Api\Admin')
            ->name('api.admin.')
            ->group(base_path('routes/adminApi.php'));
    }
}
