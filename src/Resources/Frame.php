<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * Frame
 * 
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method Frame[] childFrames()
 * @method void click(string $selector, array $options = [])
 * @method array content()
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method JSHandle evaluateHandle(\Nesk\Rialto\Data\JsFunction $pageFunction, mixed ...$args)
 * @method ExecutionContext executionContext()
 * @method void focus(string $selector)
 * @method Response goto(string $url, array $options = [])
 * @method void hover(string $selector)
 * @method bool isDetached()
 * @method string name()
 * @method Frame parentFrame()
 * @method string[] select(string $selector, string ...$values)
 * @method void setContent(string $html)
 * @method void tap(string $selector)
 * @method string title()
 * @method void type(string $selector, string $text, array $options = [])
 * @method string url()
 * @method void waitFor(string $selectorOrFunctionOrTimeout, array $options = [], mixed ...$args)
 * @method void waitForFunction(\Nesk\Rialto\Data\JsFunction $pageFunction, array $options = [])
 * @method Response waitForNavigation(array $options = [])
 * @method void waitForSelector(string $selector, array $options = [])
 * @method void waitForXPath(string $xpath, array $options = [])
 */
class Frame extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
