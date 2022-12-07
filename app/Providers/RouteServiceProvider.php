<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

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
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapSettingsRoutes();
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
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
     /**
     * Define All Admin rotues
     *
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->namespace($this->namespace)
            ->middleware(['web','auth', 'admin'])
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }
     /**
     * Define All Settigs rotues
     *
     *
     * @return void
     */
    protected function mapSettingsRoutes()
    {
        Route::prefix('settings')
            ->namespace($this->namespace)
            ->middleware(['web','auth'])
            ->name('settings.')
            ->group(base_path('routes/settings.php'));
    }
    protected function mapProjectRoutes(){
        Route::prefix('project')
            ->namespace($this->namespace)
            ->middleware(['web','auth','has-permisson'])
            ->name('project.')
            ->group(base_path('routes/project.php'));
    }
}
