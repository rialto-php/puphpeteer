<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @property Accessibility $accessibility
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method void authenticate(array $credentials)
 * @method void bringToFront()
 * @method Browser browser()
 * @method BrowserContext browserContext()
 * @method void click(string $selector, array $options = [])
 * @method void close(array $options = [])
 * @method string content()
 * @method array cookies(string ...$urls)
 * @property  Coverage $coverage
 * @method void deleteCookie(array ...$cookies)
 * @method void emulate(array $options)
 * @method void emulateMedia(string $mediaType = null)
 * @method mixed evaluate(string|\Nesk\Rialto\Data\JsFunction $pageFunction, ...$args)
 * @method JSHandle evaluateHandle(string|\Nesk\Rialto\Data\JsFunction $pageFunction, ...$args)
 * @method void evaluateOnNewDocument(string|\Nesk\Rialto\Data\JsFunction $pageFunction, ...$args)
 * @method void exposeFunction(string $name, \Nesk\Rialto\Data\JsFunction $puppeteerFunction)
 * @method void focus(string $selector)
 * @method Frame[] frames()
 * @method Response|null goBack(array $options = [])
 * @method Response|null goForward(array $options = [])
 * @method Response|null goto(string $url, array $options = [])
 * @method void hover(string $selector)
 * @method bool isClosed()
 * @property Keyboard $keyboard
 * @method Frame mainFrame()
 * @method array metrics()
 * @property Mouse $mouse
 * @method mixed pdf(array $options)
 * @method Response reload(array $options = [])
 * @method string|mixed screenshot(array $options = [])
 * @method string[] select(string $selector, string ...$values)
 * @method void setBypassCSP(bool $enabled)
 * @method void setCacheEnabled(bool $enabled = true)
 * @method void setContent(string $html, array $options = [])
 * @method void setCookie(...$cookies)
 * @method void setDefaultNavigationTimeout(int $timeout)
 * @method void setDefaultTimeout(int $timeout)
 * @method void setExtraHTTPHeaders(array $headers)
 * @method void setGeolocation(array $options)
 * @method void setJavaScriptEnabled(bool $enabled)
 * @method void setOfflineMode(bool $enabled)
 * @method void setRequestInterception(bool $enabled)
 * @method void setUserAgent(string $userAgent)
 * @method void setViewport(array $viewport)
 * @method void tap(string $selector)
 * @method Target target()
 * @method string title()
 * @property Touchscreen $touchscreen
 * @property Tracing $tracing
 * @method void type(string $selector, string $text, array $options = [])
 * @method string url()
 * @method array viewport()
 * @method JSHandle waitFor(string|int|\Nesk\Rialto\Data\JsFunction $selectorOrFunctionOrTimeout, array $options = [], ...$args)
 * @method JSHandle waitForFunction(\Nesk\Rialto\Data\JsFunction $pageFunction, array $options = [], ...$args)
 * @method Response|null waitForNavigation(array $options = [])
 * @method Request waitForRequest(string|\Nesk\Rialto\Data\JsFunction $urlOrPredicate, array $options = [])
 * @method Response waitForResponse(string|\Nesk\Rialto\Data\JsFunction $urlOrResponse, array $options = [])
 * @method ElementHandle|null waitForSelector(string $selector, array $options = [])
 * @method ElementHandle|null waitForXPath(string $xpath, array $options = [])
 * @method Worker[] workers()
 */
class Page extends EventEmitter
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
