<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method bool canDownload(string $revision)
 * @method \Nesk\Rialto\Data\BasicResource download(string $revision, \Nesk\Rialto\Data\JsFunction|null $progressCallback)
 * @method string[] localRevisions()
 * @method string platform()
 * @method void remove(string $revision)
 * @method \Nesk\Rialto\Data\BasicResource revisionInfo(string $revision)
 */
class BrowserFetcher extends BasicResource
{
    //
}
