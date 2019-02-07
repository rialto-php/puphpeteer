<?php

namespace Nesk\Puphpeteer\Traits;

trait AliasesSelectionMethods
{
    /**
     * @param string $selector
     * @return \Nesk\Puphpeteer\Resources\ElementHandle[]
     */
    public function querySelector($selector)
    {
        return $this->__call('$', func_get_args());
    }

    /**
     * @param string $selector
     * @return \Nesk\Puphpeteer\Resources\ElementHandle[]
     */
    public function querySelectorAll($selector)
    {
        return $this->__call('$$', func_get_args());
    }

    /**
     * @param string $expression
     * @return \Nesk\Puphpeteer\Resources\ElementHandle[]
     */
    public function querySelectorXPath($expression)
    {
        return $this->__call('$x', func_get_args());
    }
}
