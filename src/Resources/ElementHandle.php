<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @method ElementHandle asElement()
 * @method array|null boundingBox()
 * @method array|null boxModel()
 * @method void click(array $options = [])
 * @method Frame|null contentFrame()
 * @method void focus()
 * @method void hover()
 * @method bool isIntersectingViewport()
 * @method void press(string $key, array $options = [])
 * @method string|mixed screenshot(array $options = [])
 * @method void tap()
 * @method string toString()
 * @method void type(string $text, array $options = [])
 * @method void uploadFile(string ...$filePaths)
 */
class ElementHandle extends JSHandle
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
