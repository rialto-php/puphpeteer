<?php

namespace Nesk\Puphpeteer\Traits;

use Nesk\Puphpeteer\Resources\ElementHandle;

/**
 * @method ElementHandle|null querySelector(string $selector)
 * @method ElementHandle[] querySelectorAll(string $selector)
 * @method ElementHandle[] querySelectorXPath(string $expression)
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
