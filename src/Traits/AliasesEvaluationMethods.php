<?php

namespace Nesk\Puphpeteer\Traits;

trait AliasesEvaluationMethods
{
    /**
     * @param string $selector
     * @param \Nesk\Rialto\Data\JsFunction $pageFunction
     * @param mixed ...$args
     * @return mixed
     */
    public function querySelectorEval($selector, $pageFunction, ...$args)
    {
        return $this->__call('$eval', func_get_args());
    }

    /**
     * @param string $selector
     * @param \Nesk\Rialto\Data\JsFunction $pageFunction
     * @param mixed ...$args
     * @return mixed
     */
    public function querySelectorAllEval($selector, $pageFunction, ...$args)
    {
        return $this->__call('$$eval', func_get_args());
    }
}
