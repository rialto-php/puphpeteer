<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method void abort(string $errorCode = 'failed')
 * @method void continue(array $overrides)
 * @method array|null failure()
 * @method Frame|null frame()
 * @method array headers()
 * @method bool isNavigationRequest()
 * @method string method()
 * @method string postData()
 * @method Request[] redirectChain()
 * @method string resourceType()
 * @method void respond(array $response)
 * @method Response|null response()
 * @method string url()
 */
class Request extends BasicResource
{
    //
}
