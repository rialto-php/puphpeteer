<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method \Nesk\Puphpeteer\Resources\ExecutionContext executionContext()
 * @method mixed evaluate(mixed|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method \Nesk\Puphpeteer\Resources\JSHandle|\Nesk\Puphpeteer\Resources\ElementHandle evaluateHandle(callable|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method \Nesk\Puphpeteer\Resources\JSHandle|null getProperty(string $propertyName)
 * @method array<string, \Nesk\Puphpeteer\Resources\JSHandle> getProperties()
 * @method array<string, mixed> jsonValue()
 * @method \Nesk\Puphpeteer\Resources\ElementHandle|null asElement()
 * @method void dispose()
 * @method string toString()
 */
class JSHandle extends BasicResource
{
    //
}
