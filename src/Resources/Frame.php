<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method Frame[] childFrames()
 * @method void click(string $selector, array $options)
 * @method \Nesk\Rialto\Data\BasicResource content()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method JSHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method ExecutionContext executionContext()
 * @method void focus(string $selector)
 * @method Response goto(string $url, array $options)
 * @method void hover(string $selector)
 * @method bool isDetached()
 * @method string name()
 * @method Frame|null parentFrame()
 * @method ElementHandle querySelector(string $selector)
 * @method ElementHandle[] querySelectorAll(string $selector)
 * @method \Nesk\Rialto\Data\BasicResource querySelectorAllEval(string $selector, \Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method \Nesk\Rialto\Data\BasicResource querySelectorEval(string $selector, \Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method ElementHandle[] querySelectorXPath(string $expression)
 * @method string[] select(string $selector, string ...$values)
 * @method void setContent(string $html, array $options)
 * @method void tap(string $selector)
 * @method string title()
 * @method void type(string $selector, string $text, array $options = [])
 * @method string url()
 * @method JSHandle waitFor(string $selectorOrFunctionOrTimeout, array $options = [], mixed ...$args)
 * @method JSHandle waitForFunction(\Nesk\Rialto\Data\JsFunction $pageFunction, array $options)
 * @method Response waitForNavigation(array $options)
 * @method ElementHandle waitForSelector(string $selector, array $options)
 * @method ElementHandle waitForXPath(string $xpath, array $options)
 */
class Frame extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
