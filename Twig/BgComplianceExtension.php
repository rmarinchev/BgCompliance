<?php

namespace Modules\BgCompliance\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BgComplianceExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('amount_in_text', [$this, 'getAmountInText']),
        ];
    }

    public function getAmountInText($invoice = null)
    {
        return 'works';
    }
}