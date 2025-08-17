<?php

namespace Modules\BgCompliance\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Modules\BgCompliance\Services\BulgarianNumberToWords;

class BulgarianWordsExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('bg_amount_words', [$this, 'formatAmountInWords']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('bg_amount_words', [$this, 'formatAmountInWords']),
        ];
    }

    public function formatAmountInWords($amount, $currency = 'BGN'): string
    {
        $amount = (float) $amount;
        $formatted = number_format($amount, 2, '.', '');
        [$leva, $st] = array_pad(explode('.', $formatted), 2, '00');

        $levaWords = BulgarianNumberToWords::convert((int) $leva);
        $stWords = BulgarianNumberToWords::convert((int) $st, true);

        $unit = ((int)$leva === 1) ? 'лев' : 'лева';
        $cent = ((int)$st === 1) ? 'стотинка' : 'стотинки';

        if ($currency !== 'BGN') {
            $unit = $currency;
            $cent = '';
        }

        $result = 'Словом: ' . $levaWords . ' ' . $unit
                . (((int)$st) ? ' и ' . $stWords . ' ' . $cent : '');

        \Log::info('BgCompliance: Twig extension generated: ' . $result);
        
        return $result;
    }
}