<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @method HTTPResponse|null goto(string $url, array $options = [])
 * @method HTTPResponse|null waitForNavigation(array $options = [])
 * @method ExecutionContext executionContext()
 * @method mixed evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|JSHandle ...$args)
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, int|float|string|bool|null|array|JSHandle ...$args)
 * @method string content()
 * @method void setContent(string $html, array $options = [])
 * @method string name()
 * @method string url()
 * @method Frame|null parentFrame()
 * @method Frame[] childFrames()
 * @method bool isDetached()
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 * @method void click(string $selector, array $options = [])
 * @method void focus(string $selector)
 * @method void hover(string $selector)
 * @method string[] select(string $selector, string ...$values)
 * @method void tap(string $selector)
 * @method void type(string $selector, string $text, array $options = [])
 * @method JSHandle|null waitFor(string|float|\Nesk\Rialto\Data\JsFunction $selectorOrFunctionOrTimeout, array|string[]|mixed[] $options = null, int|float|string|bool|null|array|JSHandle ...$args)
 * @method void waitForTimeout(float $milliseconds)
 * @method ElementHandle|null waitForSelector(string $selector, array $options = [])
 * @method ElementHandle|null waitForXPath(string $xpath, array $options = [])
 * @method JSHandle waitForFunction(\Nesk\Rialto\Data\JsFunction|string $pageFunction, array $options = [], int|float|string|bool|null|array|JSHandle ...$args)
 * @method string title()
 */
class Frame extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
