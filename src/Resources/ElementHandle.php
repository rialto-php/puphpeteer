<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @method ElementHandle|mixed[]|null asElement()
 * @method Frame|null contentFrame()
 * @method void hover()
 * @method void click(array $options = [])
 * @method string[] select(string ...$values)
 * @method void uploadFile(string ...$filePaths)
 * @method void tap()
 * @method void focus()
 * @method void type(string $text, array $options = [])
 * @method void press(mixed $key, array $options = [])
 * @method mixed|null boundingBox()
 * @method mixed|null boxModel()
 * @method string|mixed|null screenshot(array $options = [])
 * @method bool isIntersectingViewport()
 */
class ElementHandle extends JSHandle
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
