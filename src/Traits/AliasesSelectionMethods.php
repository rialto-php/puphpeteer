<?php

namespace Nesk\Puphpeteer\Traits;

/**
 * @method ElementHandle|null querySelector(string $selector)
 * @method array<int, ElementHandle> querySelectorAll(string $selector)
 * @method array<int, ElementHandle> querySelectorXPath(string $expression)
 */
trait AliasesSelectionMethods
{
    public function querySelector(...$arguments)
    {
        return $this->__call('$', $arguments);
    }

    public function querySelectorAll(...$arguments)
    {
        return $this->__call('$$', $arguments);
    }

    public function querySelectorXPath(...$arguments)
    {
        return $this->__call('$x', $arguments);
    }
}
