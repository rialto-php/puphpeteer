<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * BrowserFetcher
 * 
 * @method bool canDownload(string $revision)
 * @method array download(string $revision, \Nesk\Rialto\Data\JsFunction $progressCallback)
 * @method string[] localRevisions()
 * @method string platform()
 * @method void remove(string $revision)
 * @method array revisionInfo(string $revision)
 */
class BrowserFetcher extends BasicResource
{
    //
}
