<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @method \Nesk\Puphpeteer\Resources\HTTPResponse|null goto(string $url, array $options = [])
 * @method-extended \Nesk\Puphpeteer\Resources\HTTPResponse|null goto(string $url, array{ referer: string, timeout: float, waitUntil: string|string[] } $options = null)
 * @method \Nesk\Puphpeteer\Resources\HTTPResponse|null waitForNavigation(array $options = [])
 * @method-extended \Nesk\Puphpeteer\Resources\HTTPResponse|null waitForNavigation(array{ timeout: float, waitUntil: string|string[] } $options = null)
 * @method \Nesk\Puphpeteer\Resources\ExecutionContext executionContext()
 * @method-extended \Nesk\Puphpeteer\Resources\ExecutionContext executionContext()
 * @method mixed evaluateHandle(\Nesk\Rialto\Data\JsFunction|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method-extended mixed evaluateHandle(\Nesk\Rialto\Data\JsFunction|callable|string $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method mixed evaluate(\Nesk\Rialto\Data\JsFunction $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method-extended mixed evaluate(callable|\Nesk\Rialto\Data\JsFunction $pageFunction, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method string content()
 * @method-extended string content()
 * @method void setContent(string $html, array $options = [])
 * @method-extended void setContent(string $html, array{ timeout: float, waitUntil: string|string[] } $options = null)
 * @method string name()
 * @method-extended string name()
 * @method string url()
 * @method-extended string url()
 * @method \Nesk\Puphpeteer\Resources\Frame|null parentFrame()
 * @method-extended \Nesk\Puphpeteer\Resources\Frame|null parentFrame()
 * @method \Nesk\Puphpeteer\Resources\Frame[] childFrames()
 * @method-extended \Nesk\Puphpeteer\Resources\Frame[] childFrames()
 * @method bool isDetached()
 * @method-extended bool isDetached()
 * @method \Nesk\Puphpeteer\Resources\ElementHandle addScriptTag(array $options)
 * @method-extended \Nesk\Puphpeteer\Resources\ElementHandle addScriptTag(array<string, mixed> $options)
 * @method \Nesk\Puphpeteer\Resources\ElementHandle addStyleTag(array $options)
 * @method-extended \Nesk\Puphpeteer\Resources\ElementHandle addStyleTag(array<string, mixed> $options)
 * @method void click(string $selector, array $options = [])
 * @method-extended void click(string $selector, array{ delay: float, button: mixed, clickCount: float } $options = null)
 * @method void focus(string $selector)
 * @method-extended void focus(string $selector)
 * @method void hover(string $selector)
 * @method-extended void hover(string $selector)
 * @method string[] select(string $selector, string ...$values)
 * @method-extended string[] select(string $selector, string ...$values)
 * @method void tap(string $selector)
 * @method-extended void tap(string $selector)
 * @method void type(string $selector, string $text, array $options = [])
 * @method-extended void type(string $selector, string $text, array{ delay: float } $options = null)
 * @method \Nesk\Puphpeteer\Resources\JSHandle|null waitFor(string|float|\Nesk\Rialto\Data\JsFunction $selectorOrFunctionOrTimeout, array|string[]|mixed[] $options = null, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method-extended \Nesk\Puphpeteer\Resources\JSHandle|null waitFor(string|float|callable|\Nesk\Rialto\Data\JsFunction $selectorOrFunctionOrTimeout, array|string[]|mixed[] $options = null, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method void waitForTimeout(float $milliseconds)
 * @method-extended void waitForTimeout(float $milliseconds)
 * @method \Nesk\Puphpeteer\Resources\ElementHandle|null waitForSelector(string $selector, array $options = [])
 * @method-extended \Nesk\Puphpeteer\Resources\ElementHandle|null waitForSelector(string $selector, array<string, mixed> $options = null)
 * @method \Nesk\Puphpeteer\Resources\ElementHandle|null waitForXPath(string $xpath, array $options = [])
 * @method-extended \Nesk\Puphpeteer\Resources\ElementHandle|null waitForXPath(string $xpath, array<string, mixed> $options = null)
 * @method \Nesk\Puphpeteer\Resources\JSHandle waitForFunction(\Nesk\Rialto\Data\JsFunction|string $pageFunction, array $options = [], int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method-extended \Nesk\Puphpeteer\Resources\JSHandle waitForFunction(callable|\Nesk\Rialto\Data\JsFunction|string $pageFunction, array<string, mixed> $options = null, int|float|string|bool|null|array|\Nesk\Puphpeteer\Resources\JSHandle ...$args)
 * @method string title()
 * @method-extended string title()
 */
class Frame extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
