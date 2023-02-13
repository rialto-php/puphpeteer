<?php

namespace Nesk\Puphpeteer\Resources;

/**
 * @method \Nesk\Puphpeteer\Resources\Target[] targets()
 * @method-extended \Nesk\Puphpeteer\Resources\Target[] targets()
 * @method \Nesk\Puphpeteer\Resources\Target waitForTarget(\Nesk\Rialto\Data\JsFunction $predicate, array $options = [])
 * @method-extended \Nesk\Puphpeteer\Resources\Target waitForTarget(callable(\Nesk\Puphpeteer\Resources\Target $x): bool|\Nesk\Rialto\Data\JsFunction $predicate, array{ timeout: float } $options = null)
 * @method \Nesk\Puphpeteer\Resources\Page[] pages()
 * @method-extended \Nesk\Puphpeteer\Resources\Page[] pages()
 * @method bool isIncognito()
 * @method-extended bool isIncognito()
 * @method void overridePermissions(string $origin, string[] $permissions)
 * @method-extended void overridePermissions(string $origin, string[] $permissions)
 * @method void clearPermissionOverrides()
 * @method-extended void clearPermissionOverrides()
 * @method \Nesk\Puphpeteer\Resources\Page newPage()
 * @method-extended \Nesk\Puphpeteer\Resources\Page newPage()
 * @method \Nesk\Puphpeteer\Resources\Browser browser()
 * @method-extended \Nesk\Puphpeteer\Resources\Browser browser()
 * @method void close()
 * @method-extended void close()
 */
class BrowserContext extends EventEmitter
{
    //
}
