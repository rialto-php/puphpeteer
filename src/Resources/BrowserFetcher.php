<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method mixed platform()
 * @method-extended mixed platform()
 * @method mixed product()
 * @method-extended mixed product()
 * @method string host()
 * @method-extended string host()
 * @method bool canDownload(string $revision)
 * @method-extended bool canDownload(string $revision)
 * @method mixed download(string $revision, \Nesk\Rialto\Data\JsFunction $progressCallback = null)
 * @method-extended mixed download(string $revision, callable(float $x, float $y): void|\Nesk\Rialto\Data\JsFunction $progressCallback = null)
 * @method string[] localRevisions()
 * @method-extended string[] localRevisions()
 * @method void remove(string $revision)
 * @method-extended void remove(string $revision)
 * @method mixed revisionInfo(string $revision)
 * @method-extended mixed revisionInfo(string $revision)
 */
class BrowserFetcher extends BasicResource
{
    //
}
