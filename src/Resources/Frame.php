<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * Class Frame
 * @package Nesk\Puphpeteer\Resources
 *
 * @method Frame[] childFrames()
 * @method void click(string $selector, array $options = [])
 * @method string content()
 * @method ExecutionContext executionContext()
 * @method void focus()
 * @method Response|null goto(string $url, array $options = [])
 * @method void hover(string $selector)
 * @method bool isDetached()
 * @method string name()
 * @method Frame|null parentFrame()
 * @method array select(string $selector, ...$values)
 * @method void setContent(string $content, array $options = [])
 * @method void tap(string $selector)
 * @method string title()
 * @method void type(string $selector, string $text, array $options = [])
 * @method string url()
 * @method JSHandle waitForFunction(JSHandle $pageFunction, array $options = [], ...$args)
 * @method Response waitForNavigation(array $options = [])
 * @method ElementHandle waitForSelector(string $selector, array $options = [])
 * @method ElementHandle waitForXPath(string $xPath, array $options = [])
 * @method ElementHandle addScriptTag(array $options)
 * @method ElementHandle addStyleTag(array $options)
 */
class Frame extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
