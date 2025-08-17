<?php

namespace Modules\BgCompliance\Transformers;

use App\Transformers\InvoiceTransformer as CoreTransformer;
use App\Models\Invoice;
use Modules\BgCompliance\Services\BulgarianNumberToWords;

class InvoiceTransformerWithWords extends CoreTransformer
{
    public function transform(Invoice $invoice): array
    {
        // Debug: Log that our transformer is being called
        \Log::info('BgCompliance: Custom transformer called for invoice ID: ' . $invoice->id);
        
        $data = parent::transform($invoice);

        $amount = (float) ($invoice->amount ?? 0.0);
        $formatted = number_format($amount, 2, '.', '');
        [$leva, $st] = array_pad(explode('.', $formatted), 2, '00');

        // Use our custom Bulgarian number-to-words converter
        $levaWords = BulgarianNumberToWords::convert((int) $leva);
        $stWords = BulgarianNumberToWords::convert((int) $st, true); // feminine for стотинки

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

        // Debug: Log the generated text
        \Log::info('BgCompliance: Generated amount_in_text: ' . $amountInText);

        // Expose it for Twig templates
        $data['amount_in_text'] = $amountInText;
        $data['invoice']['amount_in_text'] = $amountInText;

        return $data;
    }
}
