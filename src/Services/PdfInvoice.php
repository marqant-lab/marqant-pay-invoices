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
    public function createInvoice(Model $Payment): Model
    {
        // make sure the status of the payment is `succeeded`
        if ($Payment->status !== 'succeeded') {
            return $Payment;
        }

        // set up storage path
        $file_name = uniqid('invoice') . "_" . time() . ".pdf";
        $base_path = config('marqant-pay-invoice.pdf_path');
        $path = "{$base_path}/{$file_name}";

        // create the pdf from invoice and save it under path
        $this->bootstrapInvoice($Payment)
            ->generate($path);

        // update the payment
        $Payment->update([
            'invoice' => $path,
        ]);

        // return the updated payment
        return $Payment;
    }

    /**
     * Create a snappy.pdf instance and return it with the view already filled with data.
     *
     * @param \Illuminate\Database\Eloquent\Model $Payment
     *
     * @return \Barryvdh\Snappy\IlluminateSnappyPdf
     */
    private function bootstrapInvoice(Model $Payment): IlluminateSnappyPdf
    {
    }
}