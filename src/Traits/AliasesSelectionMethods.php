<?php

namespace Nesk\Puphpeteer\Traits;

use Nesk\Puphpeteer\Resources\ElementHandle;

trait AliasesSelectionMethods
{
    public function querySelector(string $selector): ?ElementHandle
    {
        return $this->__call('$', [$selector]);
    }

    /**
     * @param string $selector
     * @return ElementHandle[]
     */
    public function querySelectorAll(string $selector): array
    {
        return $this->__call('$$', [$selector]);
    }

    public function querySelectorXPath(string $expression): array
    {
        return $this->__call('$x', [$expression]);
    }
}
