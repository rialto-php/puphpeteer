<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

class ElementHandle extends JSHandle
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
