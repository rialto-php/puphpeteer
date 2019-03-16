<?php

namespace Nesk\Puphpeteer\Traits;

trait AliasesEvaluationMethods
{
	/**
	 * @param mixed ...$arguments
	 * @return self|null
	 */
    public function querySelectorEval(...$arguments)
    {
        return $this->__call('$eval', $arguments);
    }

	/**
	 * @param mixed ...$arguments
	 * @return self[]
	 */
    public function querySelectorAllEval(...$arguments)
    {
        return $this->__call('$$eval', $arguments);
    }

}
