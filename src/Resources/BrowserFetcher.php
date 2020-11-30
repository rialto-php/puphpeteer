<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method mixed platform()
 * @method mixed product()
 * @method string host()
 * @method bool canDownload(string $revision)
 * @method mixed download(string $revision, callable(float $x, float $y): void $progressCallback = null)
 * @method string[] localRevisions()
 * @method void remove(string $revision)
 * @method mixed revisionInfo(string $revision)
 */
class BrowserFetcher extends BasicResource
{
    //
}
