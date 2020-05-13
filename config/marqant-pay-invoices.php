<?php

/*
 |--------------------------------------------------------------------------
 | MarqantPayInvoices Configuration
 |--------------------------------------------------------------------------
 |
 | In this configuration file you will find all options to set for this
 | package.
 |
 | See: https://github.com/marqant-lab/marqant-pay-invoices
 |
 */

return [

    /*
     |--------------------------------------------------------------------------
     | PDF View
     |--------------------------------------------------------------------------
     |
     | In this section you can set the template for the pdf invoices.
     |
     */

    'pdf_view' => 'marqant-pay-invoices::pdf.invoice',

    /*
     |--------------------------------------------------------------------------
     | PDF Path
     |--------------------------------------------------------------------------
     |
     | In this section you can set the storage path under which the pdf invoices
     | are stored. Make sure they are reachable for download!
     |
     */

    'pdf_path' => 'downloads/invoices',
];
