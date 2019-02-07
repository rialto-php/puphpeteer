<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method Frame[] childFrames()
 * @method void click(string $selector, array $options = [])
 * @method string content()
 * @method mixed evaluate(string|\Nesk\Rialto\Data\JsFunction $pageFunction, ...$args)
 * @method JSHandle evaluateHandle(string|\Nesk\Rialto\Data\JsFunction $pageFunction, ...$args)
 * @method ExecutionContext executionContext()
 * @method void focus(string $selector)
 * @method Response|null goto(string $url, array $options = [])
 * @method void hover(string $selector)
 * @method bool isDetached()
 * @method string name()
 * @method Frame|null parentFrame()
 * @method string[] select(string $selector, string ...$values)
 * @method void setContent(string $html, array $options = [])
 * @method void tap(string $selector)
 * @method string title()
 * @method void type(string $selector, string $text, array $options = [])
 * @method string url()
 * @method JSHandle waitFor(string|int|\Nesk\Rialto\Data\JsFunction $selectorOrFunctionOrTimeout, array $options = [], ...$args)
 * @method JSHandle waitForFunction(\Nesk\Rialto\Data\JsFunction $pageFunction, array $options = [], ...$args)
 * @method Response|null waitForNavigation(array $options = [])
 * @method ElementHandle|null waitForSelector(string $selector, array $options = [])
 * @method ElementHandle|null waitForXPath(string $xpath, array $options = [])
 */
class Frame extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
