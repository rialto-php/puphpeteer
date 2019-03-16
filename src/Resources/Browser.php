<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * Class Browser
 * @package Nesk\Puphpeteer\Resources
 *
 * @method Page newPage()
 * @method BrowserContext[] browserContexts()
 * @method BrowserContext createIncognitoBrowserContext()
 * @method BrowserContext defaultBrowserContext()
 * @method void disconnect()
 * @method void close()
 * @method Page[] pages()
 * @method BasicResource|null process()
 * @method Target target()
 * @method Target[] targets()
 * @method string userAgent()
 * @method string version()
 * @method Target waitForTarget(JSHandle $callback, array $options = [])
 * @method string wsEndpoint()
 */
class Browser extends BasicResource
{
    //
}
