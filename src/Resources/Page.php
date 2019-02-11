<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * Page
 * 
 * @property Accessibility $accessibility
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method void authenticate(array $credentials)
 * @method Browser browser()
 * @method void click(string $selector, array $options = [])
 * @method void close(array $options = [])
 * @method array content()
 * @method array[] cookies(string ...$urls)
 * @property Coverage $coverage
 * @method static Page create(CDPSession $client, Target $target, bool $ignoreHTTPSErrors, array $defaultViewport, TaskQueue $screenshotTaskQueue)
 * @method void deleteCookie(array ...$cookies)
 * @method void emulate(array $options)
 * @method void emulateMedia(string $mediaType)
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method JSHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method void evaluateOnNewDocument(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method void exposeFunction(string $name, \Nesk\Rialto\Data\JsFunction $puppeteerFunction)
 * @method void focus(string $selector)
 * @method Frame[] frames()
 * @method Response goBack(array $options = [])
 * @method Response goForward(array $options = [])
 * @method Response goto(string $url, array $options = [])
 * @method void hover(string $selector)
 * @method bool isClosed()
 * @property Keyboard $keyboard
 * @method Frame mainFrame()
 * @method array metrics()
 * @property Mouse $mouse
 * @method array pdf(array $options = [])
 * @method JSHandle queryObjects(JSHandle $prototypeHandle)
 * @method Response reload(array $options = [])
 * @method array screenshot(array $options = [])
 * @method string[] select(string $selector, string ...$values)
 * @method void setBypassCSP(bool $enabled)
 * @method void setCacheEnabled(array $enabled)
 * @method void setContent(string $html)
 * @method void setCookie(array ...$cookies)
 * @method void setDefaultNavigationTimeout(int $timeout)
 * @method void setExtraHTTPHeaders(array $headers)
 * @method void setGeolocation(array $options)
 * @method void setJavaScriptEnabled(bool $enabled)
 * @method void setOfflineMode(bool $enabled)
 * @method void setRequestInterception(bool $value)
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
 * @method void waitFor(string $selectorOrFunctionOrTimeout, array $options = [], mixed ...$args)
 * @method void waitForFunction(\Nesk\Rialto\Data\JsFunction $pageFunction, array $options = [], mixed ...$args)
 * @method Response waitForNavigation(array $options = [])
 * @method Request waitForRequest(string $urlOrPredicate, array $options = [])
 * @method Response waitForResponse(string $urlOrPredicate, array $options = [])
 * @method void waitForSelector(string $selector, array $options = [])
 * @method void waitForXPath(string $xpath, array $options = [])
 * @method Worker[] workers()
 */
class Page extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
