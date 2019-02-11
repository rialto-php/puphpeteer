<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * Browser
 * 
 * @method BrowserContext[] browserContexts()
 * @method static void create(Connection $connection, string[] $contextIds, bool $ignoreHTTPSErrors, array $defaultViewport, array $process, \Nesk\Rialto\Data\JsFunction $closeCallback = null)
 * @method BrowserContext createIncognitoBrowserContext()
 * @method BrowserContext defaultBrowserContext()
 * @method Page newPage()
 * @method Page[] pages()
 * @method array process()
 * @method Target target()
 * @method Target[] targets()
 * @method string userAgent()
 * @method string version()
 * @method void waitForTarget(\Nesk\Rialto\Data\JsFunction $predicate, mixed $options)
 * @method string wsEndpoint()
 */
class Browser extends BasicResource
{
    //
}
