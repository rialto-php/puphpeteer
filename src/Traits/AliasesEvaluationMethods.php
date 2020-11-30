<?php

namespace Nesk\Puphpeteer\Traits;

use Nesk\Rialto\Data\JsFunction;

/**
 * @method bool|int|float|string|array|null querySelectorEval(string $selector, JsFunction $pageFunction, bool|int|float|string|array|null|JSHandle ...args)
 * @method bool|int|float|string|array|null querySelectorAllEval(string $selector, JsFunction $pageFunction, bool|int|float|string|array|null|JSHandle ...args)
 */
trait AliasesEvaluationMethods
{
    public function querySelectorEval(...$arguments)
    {
        return $this->__call('$eval', $arguments);
    }

    public function querySelectorAllEval(...$arguments)
    {
        return $this->__call('$$eval', $arguments);
    }
}
