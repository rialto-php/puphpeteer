<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @method ElementHandle|null asElement()
 * @method \Nesk\Rialto\Data\BasicResource boundingBox()
 * @method \Nesk\Rialto\Data\BasicResource boxModel()
 * @method void click(array $options)
 * @method Frame contentFrame()
 * @method void focus()
 * @method void hover()
 * @method bool isIntersectingViewport()
 * @method void press(string $key, array $options)
 * @method \Nesk\Rialto\Data\BasicResource screenshot(array $options = [])
 * @method void tap()
 * @method void type(string $text, array $options = [])
 * @method void uploadFile(string ...$filePaths)
 */
class ElementHandle extends JSHandle
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
