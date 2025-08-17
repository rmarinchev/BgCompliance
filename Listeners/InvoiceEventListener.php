<?php

namespace Modules\BgCompliance\Listeners;

use App\Events\Invoice\InvoiceWasViewed;
use App\Events\Invoice\InvoiceWasEmailed;
use Modules\BgCompliance\Services\BulgarianNumberToWords;

class InvoiceEventListener
{
    /**
     * Handle invoice viewed events.
     */
    public function handle($event)
    {
        if (property_exists($event, 'invoice') && $event->invoice) {
            $invoice = $event->invoice;
            
            // Add our custom property to the invoice model
            $amount = (float) ($invoice->amount ?? 0.0);
            $formatted = number_format($amount, 2, '.', '');
            [$leva, $st] = array_pad(explode('.', $formatted), 2, '00');

            $levaWords = BulgarianNumberToWords::convert((int) $leva);
            $stWords = BulgarianNumberToWords::convert((int) $st, true);

            $unit = ((int)$leva === 1) ? 'лев' : 'лева';
            $cent = ((int)$st === 1) ? 'стотинка' : 'стотинки';

            $code = $invoice->currency()?->code
                  ?? $invoice->client?->currency?->code
                  ?? 'BGN';

            if ($code !== 'BGN') {
                $unit = $code;
                $cent = '';
            }

            $amountInText = 'Словом: ' . $levaWords . ' ' . $unit
                          . (((int)$st) ? ' и ' . $stWords . ' ' . $cent : '');

            // Set as attribute on the model
            $invoice->setAttribute('amount_in_text', $amountInText);
            
            \Log::info('BgCompliance: Event listener added amount_in_text: ' . $amountInText);
        }
    }
}