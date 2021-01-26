<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method string url()
 * @method string resourceType()
 * @method string method()
 * @method string|null postData()
 * @method array|string[]|string[] headers()
 * @method HTTPResponse|null response()
 * @method Frame|null frame()
 * @method bool isNavigationRequest()
 * @method HTTPRequest[] redirectChain()
 * @method array|null failure()
 * @method void continue(mixed $overrides = null)
 * @method void respond(mixed $response)
 * @method void abort(mixed $errorCode = null)
 */
class HTTPRequest extends BasicResource
{
    //
}
