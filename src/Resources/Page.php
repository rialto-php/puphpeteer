<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

class Page extends EventEmitter
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
