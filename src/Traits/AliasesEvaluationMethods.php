<?php

namespace Nesk\Puphpeteer\Traits;

use Nesk\Puphpeteer\Resources\JSHandle;
use Nesk\Rialto\Data\JsFunction;

trait AliasesEvaluationMethods
{
	/**
	 * @param bool|int|float|string|array|null|JSHandle ...$args
	 * @return bool|int|float|string|array|null
	 */
	public function querySelectorEval(string $selector, JsFunction $pageFunction, ...$args)
	{
		return $this->__call('$eval', array_merge([$selector, $pageFunction], $args));
	}

	public function querySelectorAllEval(string $selector, JsFunction $pageFunction, ...$args)
	{
		return $this->__call('$$eval', array_merge([$selector, $pageFunction], $args));
	}
}
