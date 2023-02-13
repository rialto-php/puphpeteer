<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method string url()
 * @method-extended string url()
 * @method string resourceType()
 * @method-extended string resourceType()
 * @method string method()
 * @method-extended string method()
 * @method string|null postData()
 * @method-extended string|null postData()
 * @method array|string[]|string[] headers()
 * @method-extended array|string[]|string[] headers()
 * @method \Nesk\Puphpeteer\Resources\HTTPResponse|null response()
 * @method-extended \Nesk\Puphpeteer\Resources\HTTPResponse|null response()
 * @method \Nesk\Puphpeteer\Resources\Frame|null frame()
 * @method-extended \Nesk\Puphpeteer\Resources\Frame|null frame()
 * @method bool isNavigationRequest()
 * @method-extended bool isNavigationRequest()
 * @method \Nesk\Puphpeteer\Resources\HTTPRequest[] redirectChain()
 * @method-extended \Nesk\Puphpeteer\Resources\HTTPRequest[] redirectChain()
 * @method array|null failure()
 * @method-extended array{ errorText: string }|null failure()
 * @method void continue(mixed $overrides = null)
 * @method-extended void continue(mixed $overrides = null)
 * @method void respond(mixed $response)
 * @method-extended void respond(mixed $response)
 * @method void abort(mixed $errorCode = null)
 * @method-extended void abort(mixed $errorCode = null)
 */
class HTTPRequest extends BasicResource
{
    //
}
