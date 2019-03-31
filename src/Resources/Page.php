<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @property Accessibility $accessibility
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method void authenticate(array|null $credentials)
 * @method void bringToFront()
 * @method Browser browser()
 * @method BrowserContext browserContext()
 * @method void click(string $selector, array $options)
 * @method void close(array $options = [])
 * @method string content()
 * @method \Nesk\Rialto\Data\BasicResource[] cookies(string ...$urls)
 * @property Coverage $coverage
 * @method void deleteCookie(\Nesk\Rialto\Data\BasicResource ...$cookies)
 * @method void emulate(array $options)
 * @method void emulateMedia(string|null $mediaType)
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method JSHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method void evaluateOnNewDocument(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method void exposeFunction(string $name, \Nesk\Rialto\Data\JsFunction $puppeteerFunction)
 * @method void focus(string $selector)
 * @method Frame[] frames()
 * @method Response goBack(array $options)
 * @method Response goForward(array $options)
 * @method Response goto(string $url, array $options)
 * @method void hover(string $selector)
 * @method bool isClosed()
 * @property Keyboard $keyboard
 * @method Frame mainFrame()
 * @method \Nesk\Rialto\Data\BasicResource metrics()
 * @property Mouse $mouse
 * @method \Nesk\Rialto\Data\BasicResource pdf(\Nesk\Rialto\Data\BasicResource $options = null)
 * @method JSHandle queryObjects(JSHandle $prototypeHandle)
 * @method ElementHandle querySelector(string $selector)
 * @method ElementHandle[] querySelectorAll(string $selector)
 * @method \Nesk\Rialto\Data\BasicResource querySelectorAllEval(string $selector, \Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method \Nesk\Rialto\Data\BasicResource querySelectorEval(string $selector, \Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method ElementHandle[] querySelectorXPath(string $expression)
 * @method Response reload(array $options)
 * @method \Nesk\Rialto\Data\BasicResource screenshot(\Nesk\Rialto\Data\BasicResource $options = null)
 * @method string[] select(string $selector, string ...$values)
 * @method void setBypassCSP(bool $enabled)
 * @method void setCacheEnabled(bool $enabled)
 * @method void setContent(string $html, array $options)
 * @method void setCookie(\Nesk\Rialto\Data\BasicResource ...$cookies)
 * @method void setDefaultNavigationTimeout(int $timeout)
 * @method void setDefaultTimeout(int $timeout)
 * @method void setExtraHTTPHeaders(\Nesk\Rialto\Data\BasicResource $headers)
 * @method void setGeolocation(array $options)
 * @method void setJavaScriptEnabled(bool $enabled)
 * @method void setOfflineMode(bool $enabled)
 * @method void setRequestInterception(bool $value)
 * @method void setUserAgent(string $userAgent)
 * @method void setViewport(\Nesk\Rialto\Data\BasicResource $viewport)
 * @method void tap(string $selector)
 * @method Target target()
 * @method string title()
 * @property Touchscreen $touchscreen
 * @property Tracing $tracing
 * @method void type(string $selector, string $text, array $options = [])
 * @method string url()
 * @method \Nesk\Rialto\Data\BasicResource|null viewport()
 * @method JSHandle waitFor(string $selectorOrFunctionOrTimeout, array $options = [], mixed ...$args)
 * @method JSHandle waitForFunction(\Nesk\Rialto\Data\JsFunction $pageFunction, array $options, mixed ...$args)
 * @method Response waitForNavigation(array $options)
 * @method Request waitForRequest(string $urlOrPredicate, array $options)
 * @method Response waitForResponse(string $urlOrPredicate, array $options)
 * @method ElementHandle waitForSelector(string $selector, array $options)
 * @method ElementHandle waitForXPath(string $xpath, array $options)
 * @method Worker[] workers()
 */
class Page extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
