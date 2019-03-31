<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method \Nesk\Rialto\Data\BasicResource evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method JSHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method Frame|null frame()
 * @method JSHandle queryObjects(JSHandle $prototypeHandle)
 */
class ExecutionContext extends BasicResource
{
    //
}
