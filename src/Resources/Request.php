<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * Request
 * 
 * @method void abort(string $errorCode = 'failed')
 * @method void continue(array $overrides = [])
 * @method array failure()
 * @method Frame frame()
 * @method array headers()
 * @method bool isNavigationRequest()
 * @method string method()
 * @method string postData()
 * @method Request[] redirectChain()
 * @method string resourceType()
 * @method void respond(array $response)
 * @method Response response()
 * @method string url()
 */
class Request extends BasicResource
{
    //
}
