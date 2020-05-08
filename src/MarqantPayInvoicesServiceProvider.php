<?php

namespace Marqant\MarqantPayInvoices;

use Illuminate\Support\ServiceProvider;

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
     * Setup resources in boot method.
     *
     * @return void
     */
    private function setupResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'marqant-pay-invoices');
    }
}