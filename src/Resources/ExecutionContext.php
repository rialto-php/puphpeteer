<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method mixed evaluate(string|\Nesk\Rialto\Data\JsFunction $pageFunction, ...$args)
 * @method JSHandle evaluateHandle(string|\Nesk\Rialto\Data\JsFunction $pageFunction, ...$args)
 * @method Frame|null frame()
 * @method JSHandle queryObjects(JSHandle $prototypeHandle)
 */
class ExecutionContext extends BasicResource
{
    //
}
