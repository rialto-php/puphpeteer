<?php

namespace Nesk\Puphpeteer\Resources;

/**
 * @method \Nesk\Puphpeteer\Resources\Target[] targets()
 * @method \Nesk\Puphpeteer\Resources\Target waitForTarget(callable(\Nesk\Puphpeteer\Resources\Target $x): bool $predicate, array{ timeout: float } $options = null)
 * @method \Nesk\Puphpeteer\Resources\Page[] pages()
 * @method bool isIncognito()
 * @method void overridePermissions(string $origin, string[] $permissions)
 * @method void clearPermissionOverrides()
 * @method \Nesk\Puphpeteer\Resources\Page newPage()
 * @method \Nesk\Puphpeteer\Resources\Browser browser()
 * @method void close()
 */
class BrowserContext extends EventEmitter
{
    //
}
