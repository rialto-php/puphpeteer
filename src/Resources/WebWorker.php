<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method string url()
 * @method-extended string url()
 * @method \Nesk\Puphpeteer\Resources\ExecutionContext executionContext()
 * @method-extended \Nesk\Puphpeteer\Resources\ExecutionContext executionContext()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction|string $pageFunction, mixed ...$args)
 * @method-extended mixed evaluate(callable|\Nesk\Rialto\Data\JsFunction|string $pageFunction, mixed ...$args)
 * @method \Nesk\Puphpeteer\Resources\JSHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method-extended \Nesk\Puphpeteer\Resources\JSHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|callable|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 */
class WebWorker extends BasicResource
{
    //
}
