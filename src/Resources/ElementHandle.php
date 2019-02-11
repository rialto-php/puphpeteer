<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;
use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * ElementHandle
 * 
 * @method ElementHandle asElement()
 * @method array boundingBox()
 * @method array boxModel()
 * @method void click(array $options = [])
 * @method Frame contentFrame()
 * @method bool isIntersectingViewport()
 * @method void press(string $key, array $options = [])
 * @method array screenshot(array $options = [])
 * @method void type(string $text, array $options = [])
 * @method void uploadFile(string ...$filePaths)
 */
class ElementHandle extends BasicResource
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
