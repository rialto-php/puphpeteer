<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * BrowserContext
 * 
 * @method Browser browser()
 * @method bool isIncognito()
 * @method Page newPage()
 * @method void overridePermissions(string $origin, string[] $permissions)
 * @method Page[] pages()
 * @method Target[] targets()
 * @method void waitForTarget(\Nesk\Rialto\Data\JsFunction $predicate, array $options)
 */
class BrowserContext extends BasicResource
{
    //
}
