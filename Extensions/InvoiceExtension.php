<?php

namespace Modules\BgCompliance\Extensions;

class InvoiceExtension
{
    /**
     * Add custom properties to the invoice object
     *
     * @param object $invoice
     * @return object
     */
    public function extendInvoice($invoice)
    {
        // Add our custom property
        $invoice->amount_in_text = 'works';
        
        return $invoice;
    }
    
    /**
     * Get the amount in text for an invoice
     *
     * @param object $invoice
     * @return string
     */
    public function getAmountInText($invoice)
    {
        return 'works';
    }
}