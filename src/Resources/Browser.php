<?php

namespace Nesk\Puphpeteer\Resources;

/**
 * @method mixed|null process()
 * @method \Nesk\Puphpeteer\Resources\BrowserContext createIncognitoBrowserContext()
 * @method \Nesk\Puphpeteer\Resources\BrowserContext[] browserContexts()
 * @method \Nesk\Puphpeteer\Resources\BrowserContext defaultBrowserContext()
 * @method string wsEndpoint()
 * @method \Nesk\Puphpeteer\Resources\Page newPage()
 * @method \Nesk\Puphpeteer\Resources\Target[] targets()
 * @method \Nesk\Puphpeteer\Resources\Target target()
 * @method \Nesk\Puphpeteer\Resources\Target waitForTarget(callable(\Nesk\Puphpeteer\Resources\Target $x): bool $predicate, array<string, mixed> $options = null)
 * @method \Nesk\Puphpeteer\Resources\Page[] pages()
 * @method string version()
 * @method string userAgent()
 * @method void close()
 * @method void disconnect()
 * @method bool isConnected()
 */
class Browser extends EventEmitter
{
    //
}
