<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method \Nesk\Puphpeteer\Resources\ExecutionContext executionContext()
 * @method-extended \Nesk\Puphpeteer\Resources\ExecutionContext executionContext()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method-extended mixed evaluate(callable|\Nesk\Rialto\Data\JsFunction $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method \Nesk\Puphpeteer\Resources\JSHandle|\Nesk\Puphpeteer\Resources\ElementHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method-extended \Nesk\Puphpeteer\Resources\JSHandle|\Nesk\Puphpeteer\Resources\ElementHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|callable|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method \Nesk\Puphpeteer\Resources\JSHandle|null getProperty(string $propertyName)
 * @method-extended \Nesk\Puphpeteer\Resources\JSHandle|null getProperty(string $propertyName)
 * @method array|string[]|\Nesk\Puphpeteer\Resources\JSHandle[] getProperties()
 * @method-extended array|string[]|\Nesk\Puphpeteer\Resources\JSHandle[] getProperties()
 * @method array|string[]|mixed[] jsonValue()
 * @method-extended array|string[]|mixed[] jsonValue()
 * @method \Nesk\Puphpeteer\Resources\ElementHandle|null asElement()
 * @method-extended \Nesk\Puphpeteer\Resources\ElementHandle|null asElement()
 * @method void dispose()
 * @method-extended void dispose()
 * @method string toString()
 * @method-extended string toString()
 */
class JSHandle extends BasicResource
{
    //
}
