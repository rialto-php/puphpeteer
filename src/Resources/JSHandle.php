<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method ExecutionContext executionContext()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, int|float|string|bool|null|array|JSHandle ...$args)
 * @method JSHandle|ElementHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|JSHandle ...$args)
 * @method JSHandle|null getProperty(string $propertyName)
 * @method array|string[]|JSHandle[] getProperties()
 * @method array|string[]|mixed[] jsonValue()
 * @method ElementHandle|null asElement()
 * @method void dispose()
 * @method string toString()
 */
class JSHandle extends BasicResource
{
    //
}
