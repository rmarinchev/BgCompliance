<?php

namespace Modules\BgCompliance\Transformers;

use App\Models\Invoice;
use App\Http\Requests\Request;
use League\Fractal\TransformerAbstract;

class InvoiceTransformer extends TransformerAbstract
{
    /**
     * Transform the invoice object to include our custom property
     *
     * @param Invoice $invoice
     * @return array
     */
    public function transform(Invoice $invoice)
    {
        return [
            'amount_in_text' => 'works'
        ];
    }
}