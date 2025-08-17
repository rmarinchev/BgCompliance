<?php

namespace Modules\BgCompliance\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\BgCompliance\Twig\BgComplianceExtension;

class BgComplianceServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Register Twig extension
        $this->registerTwigExtension();
        
        // Add macro to Invoice model if it exists
        if (class_exists('App\Models\Invoice')) {
            \App\Models\Invoice::macro('getAmountInTextAttribute', function () {
                return 'works';
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the Twig extension
     */
    protected function registerTwigExtension()
    {
        if (class_exists('Twig\Environment')) {
            $this->app->singleton('twig.extension.bgcompliance', function () {
                return new BgComplianceExtension();
            });
        }
    }
}