<?php

namespace Modules\BgCompliance\Transformers;

use App\Transformers\InvoiceTransformer as CoreTransformer;
use App\Models\Invoice;

class InvoiceTransformerWithWordsFallback extends CoreTransformer
{
    public function transform(Invoice $invoice): array
    {
        $data = parent::transform($invoice);

        $amount = (float) ($invoice->amount ?? 0.0);
        
        // Simple fallback without external library
        $amountInText = 'Словом: ' . number_format($amount, 2, ',', ' ') . ' лева';

        // Expose it for Twig templates
        $data['amount_in_text'] = $amountInText;
        $data['invoice']['amount_in_text'] = $amountInText;

        return $data;
    }
}