<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method bool canDownload(string $revision)
 * @method array download(string $revision, $progressCallback = null)
 * @method string[] localRevisions()
 * @method string platform()
 * @method void remove(string $revision)
 * @method array revisionInfo(string $revision)
 */
class BrowserFetcher extends BasicResource
{
    //
}
