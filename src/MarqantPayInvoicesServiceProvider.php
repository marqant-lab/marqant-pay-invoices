<?php

namespace Marqant\MarqantPayInvoices;

use Illuminate\Support\ServiceProvider;
use Marqant\MarqantPayInvoices\Mixins\PaymentInvoicesMixin;
use Marqant\MarqantPayInvoices\Mixins\MarqantPayInvoicesMixin;

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
     * @throws \ReflectionException
     */
    public function boot()
    {
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
}