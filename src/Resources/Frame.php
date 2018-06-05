<?php

namespace ExtractrIo\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use ExtractrIo\Puphpeteer\Traits\AliasesSelectionMethods;
use ExtractrIo\Puphpeteer\Traits\AliasesEvaluationMethods;

class Frame extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
