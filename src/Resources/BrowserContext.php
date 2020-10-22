<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * Class BrowserContext
 *
 * @package Nesk\Puphpeteer\Resources
 *
 * @method Page newPage()
 * @method Browser browser()
 * @method void clearPermissionOverrides()
 * @method void close()
 * @method bool isIncognito()
 * @method void overridePermissions(string $origin, array $permissions)
 * @method Page[] pages()
 * @method Target[] targets()
 * @method Target waitForTarget(JSHandle $predicate, array $options = [])
 */
class BrowserContext extends BasicResource
{
    //
}
