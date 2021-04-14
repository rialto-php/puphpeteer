<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method \Nesk\Puphpeteer\Resources\Frame|null frame()
 * @method-extended \Nesk\Puphpeteer\Resources\Frame|null frame()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction|string $pageFunction, mixed ...$args)
 * @method-extended mixed evaluate(callable|\Nesk\Rialto\Data\JsFunction|string $pageFunction, mixed ...$args)
 * @method \Nesk\Puphpeteer\Resources\JSHandle|\Nesk\Puphpeteer\Resources\ElementHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method-extended \Nesk\Puphpeteer\Resources\JSHandle|\Nesk\Puphpeteer\Resources\ElementHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|callable|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method \Nesk\Puphpeteer\Resources\JSHandle queryObjects(\Nesk\Puphpeteer\Resources\JSHandle $prototypeHandle)
 * @method-extended \Nesk\Puphpeteer\Resources\JSHandle queryObjects(\Nesk\Puphpeteer\Resources\JSHandle $prototypeHandle)
 */
class ExecutionContext extends BasicResource
{
    //
}
