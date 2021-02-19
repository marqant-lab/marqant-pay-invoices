<?php

namespace Marqant\MarqantPayInvoices\Mixins;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Marqant\MarqantPay\Services\MarqantPay
 */
class MarqantPayMixin
{
    /**
     * Create a subscription for a billable on a given provider.
     *
     * @return \Closure
     */
    public static function getPaymentByInvoice(): \Closure
    {
        /**
         *
         * @param \Illuminate\Database\Eloquent\Model $Billable
         * @param array                               $invoice_data
         *
         * @return \Illuminate\Database\Eloquent\Model
         */
        return function (string $provider_string, array $invoice_data) {
            $Gateway = self::resolveProviderGatewayFromString($provider_string);

            return $Gateway->getPaymentByInvoice($invoice_data);
        };
    }

    /**
     * Create a subscription for a billable on a given provider.
     *
     * @return \Closure
     */
    public static function createInvoice(): \Closure
    {
        /**
         * Create invoices for a given payment.
         *
         * @param \Illuminate\Database\Eloquent\Model $Payment
         *
         * @return \Illuminate\Database\Eloquent\Model
         */
        return function (Model $Payment) {
            /**
             * @var \Marqant\MarqantPay\Services\ProviderInvoice $InvoiceService
             */
            $InvoiceService = app(config('marqant-pay.invoice_service'));

            return $InvoiceService->createInvoice($Payment);
        };
    }
}
