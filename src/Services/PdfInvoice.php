<?php

namespace Marqant\MarqantPayInvoices\Services;

use Illuminate\Database\Eloquent\Model;
use Marqant\MarqantPay\Services\BaseInvoiceService;

class PdfInvoice extends BaseInvoiceService
{
    /**
     * Create a PDF invoice from a given payment.
     *
     * @param \Illuminate\Database\Eloquent\Model $Payment
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function createInvoice(Model $Payment): Model
    {
        // TODO: Implement createInvoice() method.
    }
}