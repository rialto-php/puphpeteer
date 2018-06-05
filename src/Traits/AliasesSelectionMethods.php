<?php

namespace Nesk\Puphpeteer\Traits;

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
