<?php

namespace Nesk\Puphpeteer\Resources;

/**
 * @method Target[] targets()
 * @method Target waitForTarget(\Nesk\Rialto\Data\JsFunction $predicate, array $options = [])
 * @method Page[] pages()
 * @method bool isIncognito()
 * @method void overridePermissions(string $origin, string[] $permissions)
 * @method void clearPermissionOverrides()
 * @method Page newPage()
 * @method Browser browser()
 * @method void close()
 */
class BrowserContext extends EventEmitter
{
    //
}
