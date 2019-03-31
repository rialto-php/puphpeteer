<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method BrowserContext[] browserContexts()
 * @method void close()
 * @method BrowserContext createIncognitoBrowserContext()
 * @method BrowserContext defaultBrowserContext()
 * @method void disconnect()
 * @method Page newPage()
 * @method Page[] pages()
 * @method \Nesk\Rialto\Data\BasicResource|null process()
 * @method Target target()
 * @method Target[] targets()
 * @method string userAgent()
 * @method string version()
 * @method Target waitForTarget(\Nesk\Rialto\Data\JsFunction $predicate, array $options)
 * @method string wsEndpoint()
 */
class Browser extends BasicResource
{
    //
}
