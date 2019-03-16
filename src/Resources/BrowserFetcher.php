<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * Class BrowserFetcher
 * @package Nesk\Puphpeteer\Resources
 *
 * @method bool canDownload(string $revision)
 * @method array download(string $revision, JSHandle $progressCallback)
 * @method array localRevisions()
 * @method string platform()
 * @method void remove(string $revision)
 * @method array revisionInfo(string $revision)
 */
class BrowserFetcher extends BasicResource
{
    //
}
