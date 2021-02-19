<?php

namespace Marqant\MarqantPayInvoices;

use Illuminate\Support\ServiceProvider;
use Marqant\MarqantPay\Services\MarqantPay;
use Marqant\MarqantPayInvoices\Mixins\MarqantPayMixin;

class MarqantPayInvoicesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupConfig();

        $this->setupMixins();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupMigrations();

        $this->setupResources();
    }

    /**
     * Setup configuration in register method.
     *
     * @return void
     */
    private function setupConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/marqant-pay-invoices.php', 'marqant-pay-invoices');
    }

    /**
     * Setup migrations in boot method.
     *
     * @return void
     */
    private function setupMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Setup mixins to extend the baspackage through the Macroable trait in register method.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    private function setupMixins()
    {
        MarqantPay::mixin(app(MarqantPayMixin::class));
    }

    /**
     * Setup resources in boot method.
     *
     * @return void
     */
    private function setupResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'marqant-pay-invoices');
    }
}
