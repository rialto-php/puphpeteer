<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method Browser browser()
 * @method void clearPermissionOverrides()
 * @method void close()
 * @method bool isIncognito()
 * @method Page newPage()
 * @method void overridePermissions(string $origin, string[] $permissions)
 * @method Page[] pages()
 * @method Target[] targets()
 * @method Target waitForTarget(\Nesk\Rialto\Data\JsFunction $predicate, array $options)
 */
class BrowserContext extends BasicResource
{
    //
}
