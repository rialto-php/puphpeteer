<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method Frame|null frame()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction|string $pageFunction, mixed ...$args)
 * @method JSHandle|ElementHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|JSHandle ...$args)
 * @method JSHandle queryObjects(JSHandle $prototypeHandle)
 */
class ExecutionContext extends BasicResource
{
    //
}
