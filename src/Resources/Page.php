<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;
use Nesk\Rialto\Data\JsFunction;

/**
 * Class Page
 * @package Nesk\Puphpeteer\Resources
 *
 * @property-read Accessibility accessibility
 * @property-read Coverage coverage
 * @property-read Keyboard keyboard
 * @property-read Mouse mouse
 * @property-read TouchScreen touchscreen
 * @property-read Tracing tracing
 * @property-read Page tryCatch
 *
 * @method void bringToFront()
 * @method Browser browser()
 * @method BrowserContext browserContext()
 * @method void click(string $selector, array $options = [])
 * @method string content()
 * @method array cookies(...$urls)
 * @method array close()
 * @method Coverage coverage()
 * @method void deleteCookie(...$cookies)
 * @method void evaluateOnNewDocument(JsFunction $pageFunction, ...$args)
 * @method void exposeFunction(string $name, JsFunction $puppeteerFunction)
 * @method void focus(string $selector)
 * @method Frame[] frames()
 * @method Response|null goto(string $url, array $options)
 * @method Response|null goBack(array $options = [])
 * @method Response|null goForward(array $options = [])
 * @method void hover(string $selector)
 * @method bool isClosed()
 * @method Frame mainFrame()
 * @method array metrics()
 * @method BasicResource pdf(array $options = [])
 * @method JSHandle queryObjects(JSHandle $prototypeHandle)
 * @method Response reload(array $options = [])
 * @method BasicResource|string screenshot(array $options)
 * @method array select(string $selector, ...$values)
 * @method void setBypassCSP(bool $enabled)
 * @method void setCacheEnabled(bool $enabled)
 * @method void setContent(string $content, array $options = [])
 * @method void setCookie(...$cookies)
 * @method void setDefaultNavigationTimeout(int $timeoutInMilliseconds)
 * @method void setDefaultTimeout(int $timeoutInMilliseconds)
 * @method void setExtraHTTPHeaders(array $headers)
 * @method void setJavaScriptEnabled(bool $enabled)
 * @method void setOfflineMode(bool $enabled)
 * @method void setRequestInterception(bool $value)
 * @method void setUserAgent(string $userAgent)
 * @method void setViewport(array $options)
 * @method void tap(string $selector)
 * @method Target target()
 * @method string title()
 * @method void type(string $selector, string $text, array $options = [])
 * @method string url()
 * @method array viewport()
 * @method Worker[] workers()
 * @method Page on(string $event, JsFunction $callback)
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method JSHandle waitFor($selectorOrFunctionOrTimeout, array $options = [], ...$args)
 * @method JSHandle waitForTimeout(int $timeout)
 * @method Request waitForRequest($urlOrPredicate, array $options = [])
 * @method Response waitForResponse($urlOrPredicate, array $options = [])
 * @method ElementHandle waitForSelector(string $selector, array $options = [])
 * @method ElementHandle waitForXPath($xpath, array $options = [])
 * @method Response waitForNavigation(array $options = [])
 * @method evaluate(JsFunction $function)
 * @method emulate(array $options = [])
 */
class Page extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
