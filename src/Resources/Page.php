<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @property-read Keyboard keyboard
 * @property-read Touchscreen touchscreen
 * @property-read Coverage coverage
 * @property-read Tracing tracing
 * @property-read Accessibility accessibility
 * @property-read Mouse mouse
 * @method bool isJavaScriptEnabled()
 * @method FileChooser waitForFileChooser(array $options = [])
 * @method void setGeolocation(array $options)
 * @method Target target()
 * @method Browser browser()
 * @method BrowserContext browserContext()
 * @method Frame mainFrame()
 * @method Frame[] frames()
 * @method WebWorker[] workers()
 * @method void setRequestInterception(bool $value)
 * @method void setOfflineMode(bool $enabled)
 * @method void setDefaultNavigationTimeout(float $timeout)
 * @method void setDefaultTimeout(float $timeout)
 * @method mixed evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|JSHandle ...$args)
 * @method JSHandle queryObjects(JSHandle $prototypeHandle)
 * @method mixed[] cookies(string ...$urls)
 * @method void deleteCookie(mixed ...$cookies)
 * @method void setCookie(mixed ...$cookies)
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method void exposeFunction(string $name, \Nesk\Rialto\Data\JsFunction $puppeteerFunction)
 * @method void authenticate(mixed $credentials)
 * @method void setExtraHTTPHeaders(array|string[]|string[] $headers)
 * @method void setUserAgent(string $userAgent)
 * @method mixed metrics()
 * @method string url()
 * @method string content()
 * @method void setContent(string $html, array $options = [])
 * @method HTTPResponse goto(string $url, array $options = [])
 * @method HTTPResponse|null reload(array $options = [])
 * @method HTTPResponse|null waitForNavigation(array $options = [])
 * @method HTTPRequest waitForRequest(string|\Nesk\Rialto\Data\JsFunction $urlOrPredicate, array $options = [])
 * @method HTTPResponse waitForResponse(string|\Nesk\Rialto\Data\JsFunction $urlOrPredicate, array $options = [])
 * @method HTTPResponse|null goBack(array $options = [])
 * @method HTTPResponse|null goForward(array $options = [])
 * @method void bringToFront()
 * @method void emulate(array $options)
 * @method void setJavaScriptEnabled(bool $enabled)
 * @method void setBypassCSP(bool $enabled)
 * @method void emulateMediaType(string $type = null)
 * @method void emulateMediaFeatures(mixed[] $features = null)
 * @method void emulateTimezone(string $timezoneId = null)
 * @method void emulateIdleState(array $overrides = [])
 * @method void emulateVisionDeficiency(mixed $type = null)
 * @method void setViewport(mixed $viewport)
 * @method mixed|null viewport()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, int|float|string|bool|null|array|JSHandle ...$args)
 * @method void evaluateOnNewDocument(\Nesk\Rialto\Data\JsFunction|string $pageFunction, mixed ...$args)
 * @method void setCacheEnabled(bool $enabled = null)
 * @method mixed|string|null screenshot(array $options = [])
 * @method mixed pdf(array $options = [])
 * @method string title()
 * @method void close(array $options = [])
 * @method bool isClosed()
 * @method void click(string $selector, array $options = [])
 * @method void focus(string $selector)
 * @method void hover(string $selector)
 * @method string[] select(string $selector, string ...$values)
 * @method void tap(string $selector)
 * @method void type(string $selector, string $text, array $options = [])
 * @method JSHandle waitFor(string|float|\Nesk\Rialto\Data\JsFunction $selectorOrFunctionOrTimeout, array $options = [], int|float|string|bool|null|array|JSHandle ...$args)
 * @method void waitForTimeout(float $milliseconds)
 * @method ElementHandle|null waitForSelector(string $selector, array $options = [])
 * @method ElementHandle|null waitForXPath(string $xpath, array $options = [])
 * @method JSHandle waitForFunction(\Nesk\Rialto\Data\JsFunction|string $pageFunction, array $options = [], int|float|string|bool|null|array|JSHandle ...$args)
 */
class Page extends EventEmitter
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
