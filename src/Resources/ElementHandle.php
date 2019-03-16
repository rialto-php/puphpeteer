<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * Class ElementHandle
 * @package Nesk\Puphpeteer\Resources
 *
 * @method ElementHandle asElement()
 * @method array|null boundingBox()
 * @method array|null boxModel()
 * @method void click(array $options = [])
 * @method Frame|null contentFrame()
 * @method void dispose()
 * @method ExecutionContext executionContext()
 * @method void focus()
 * @method array getProperties()
 * @method JSHandle getProperty(string $name)
 * @method void hover()
 * @method bool isIntersectingViewport()
 * @method array jsonValue()
 * @method void press(string $key, array $options = [])
 * @method BasicResource screenshot(array $options = [])
 * @method void tap()
 * @method string toString()
 * @method void type(string $type, array $options = [])
 * @method void uploadFile(...$paths)
 */
class ElementHandle extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
