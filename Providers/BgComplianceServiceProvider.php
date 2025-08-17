<?php

namespace Modules\BgCompliance\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class BgComplianceServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        // Register the transformer binding after the app has booted
        $this->app->bind(
            \App\Transformers\InvoiceTransformer::class,
            \Modules\BgCompliance\Transformers\InvoiceTransformerWithWords::class
        );
        
        // Register event listeners for invoice events
        $this->app['events']->listen(
            [\App\Events\Invoice\InvoiceWasViewed::class, \App\Events\Invoice\InvoiceWasEmailed::class],
            \Modules\BgCompliance\Listeners\InvoiceEventListener::class
        );
        
        // Log that our service provider is being loaded
        \Log::info('BgCompliance: Service provider booted, transformer bound, and events registered');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bind the custom transformer to replace the default one
        $this->app->bind(
            \App\Transformers\InvoiceTransformer::class,
            \Modules\BgCompliance\Transformers\InvoiceTransformerWithWords::class
        );
        
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('bgcompliance.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'bgcompliance'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/bgcompliance');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/bgcompliance';
        }, \Config::get('view.paths')), [$sourcePath]), 'bgcompliance');
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
