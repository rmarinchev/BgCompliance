<?php

namespace Modules\BgCompliance\Providers;

use Illuminate\Support\ServiceProvider;
use App\Transformers\InvoiceTransformer;
use Modules\BgCompliance\Transformers\InvoiceTransformerWithWords;

class BgComplianceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Replace the default invoice transformer with our custom one
        $this->app->bind(InvoiceTransformer::class, InvoiceTransformerWithWords::class);
    }

    public function boot(): void
    {
        // Nothing else required for now
    }
}
