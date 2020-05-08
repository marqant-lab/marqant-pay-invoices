<?php

namespace Marqant\MarqantPayInvoices\Tests\Services;

use Marqant\MarqantPayInvoices\Tests\MarqantPayInvoicesTestCase;

class PdfInvoiceTest extends MarqantPayInvoicesTestCase
{
    /**
     * Test if we can generate a pdf and save it on the payment.
     *
     * @test
     *
     * @return void
     */
    public function test_create_pdf_and_save_on_payment(): void
    {
        /**
         * @var \App\User                          $User
         * @var \Marqant\MarqantPay\Models\Payment $Payment
         */

        //////////////////////////////////////
        // Setup Test

        // Update config so we have the marqant-pay.invoice_service
        // setting set to the PdfInvoice service
        $PdfInvoiceService = \Marqant\MarqantPayInvoices\Services\PdfInvoice::class;
        config(['marqant-pay.invoice_service' => $PdfInvoiceService]);

        // assert that it is actually set
        $this->assertEquals($PdfInvoiceService, config('marqant-pay.invoice_service'));

        //////////////////////////////////////
        // Create Payment

        $amount = 999; // 9,99 ($|€|...)

        // create fake customer through factory
        $User = $this->createBillableUser();

        // charge the user
        $Payment = $User->charge($amount, 'test_create_pdf_and_save_on_payment');

        // check that we got back an instance of Payment
        $this->assertInstanceOf(config('marqant-pay.payment_model'), $Payment);

        // check the amount
        $this->assertEquals($amount, $Payment->amount);

        // check if we billed the correct user
        $this->assertEquals($User->provider_id, $Payment->customer);

        //////////////////////////////////////
        // Create PDF on Payment

        // create PDF on Payment
        $Payment->createInvoice();

        $this->assertNotEmpty($Payment->invoice);
    }
}