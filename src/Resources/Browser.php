<?php

namespace Nesk\Puphpeteer\Resources;

/**
 * @method mixed|null process()
 * @method-extended mixed|null process()
 * @method \Nesk\Puphpeteer\Resources\BrowserContext createIncognitoBrowserContext()
 * @method-extended \Nesk\Puphpeteer\Resources\BrowserContext createIncognitoBrowserContext()
 * @method \Nesk\Puphpeteer\Resources\BrowserContext[] browserContexts()
 * @method-extended \Nesk\Puphpeteer\Resources\BrowserContext[] browserContexts()
 * @method \Nesk\Puphpeteer\Resources\BrowserContext defaultBrowserContext()
 * @method-extended \Nesk\Puphpeteer\Resources\BrowserContext defaultBrowserContext()
 * @method string wsEndpoint()
 * @method-extended string wsEndpoint()
 * @method \Nesk\Puphpeteer\Resources\Page newPage()
 * @method-extended \Nesk\Puphpeteer\Resources\Page newPage()
 * @method \Nesk\Puphpeteer\Resources\Target[] targets()
 * @method-extended \Nesk\Puphpeteer\Resources\Target[] targets()
 * @method \Nesk\Puphpeteer\Resources\Target target()
 * @method-extended \Nesk\Puphpeteer\Resources\Target target()
 * @method \Nesk\Puphpeteer\Resources\Target waitForTarget(\Nesk\Rialto\Data\JsFunction $predicate, array $options = [])
 * @method-extended \Nesk\Puphpeteer\Resources\Target waitForTarget(callable(\Nesk\Puphpeteer\Resources\Target $x): bool|\Nesk\Rialto\Data\JsFunction $predicate, array<string, mixed> $options = null)
 * @method \Nesk\Puphpeteer\Resources\Page[] pages()
 * @method-extended \Nesk\Puphpeteer\Resources\Page[] pages()
 * @method string version()
 * @method-extended string version()
 * @method string userAgent()
 * @method-extended string userAgent()
 * @method void close()
 * @method-extended void close()
 * @method void disconnect()
 * @method-extended void disconnect()
 * @method bool isConnected()
 * @method-extended bool isConnected()
 */
class Browser extends EventEmitter
{
    //
}
