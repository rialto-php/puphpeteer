<?php

namespace Nesk\Puphpeteer\Traits;

/**
 * Trait AliasesSelectionMethods
 * @package Nesk\Puphpeteer\Traits
 */
trait AliasesSelectionMethods
{

	/**
	 * @param mixed ...$arguments
	 * @return self|null
	 */
    public function querySelector(...$arguments)
    {
        return $this->__call('$', $arguments);
    }

	/**
	 * @param mixed ...$arguments
	 * @return self[]
	 */
    public function querySelectorAll(...$arguments)
    {
        return $this->__call('$$', $arguments);
    }

	/**
	 * @param mixed ...$arguments
	 * @return self[]
	 */
    public function querySelectorXPath(...$arguments)
    {
        return $this->__call('$x', $arguments);
    }

}
