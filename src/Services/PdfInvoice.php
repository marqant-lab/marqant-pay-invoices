<?php

namespace Marqant\MarqantPayInvoices\Services;

use Barryvdh\Snappy\PdfWrapper;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        $base_path = config('marqant-pay-invoices.pdf_path');
        $path = "{$base_path}/{$file_name}";

        // create the pdf output from invoice
        $output = $this->bootstrapInvoice($Payment)
            ->output();

        // get our disk to store the PDF in.
        $disk = Storage::disk(env('FILESYSTEM_DRIVER', 'public'));

        // ddi('test');

        // save the file with the PDF output.
        if ($disk->put($path, $output)) {
            // update the payment invoice path
            $Payment->update([
                'invoice' => $path,
            ]);
        }

        // return the updated payment
        return $Payment;
    }

    /**
     * Create a snappy.pdf instance and return it with the view already filled with data.
     *
     * @param \Illuminate\Database\Eloquent\Model $Payment
     *
     * @return \Barryvdh\Snappy\PdfWrapper
     */
    private function bootstrapInvoice(Model $Payment): PdfWrapper
    {
        $view = config('marqant-pay-invoices.pdf_view');

        $pdf = SnappyPdf::loadView($view, [
            'payment' => $Payment,
        ]);

        return $pdf;
    }
}
