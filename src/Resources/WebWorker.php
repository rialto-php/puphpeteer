<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method string url()
 * @method ExecutionContext executionContext()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction|string $pageFunction, mixed ...$args)
 * @method JSHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|JSHandle ...$args)
 */
class WebWorker extends BasicResource
{
    //
}
