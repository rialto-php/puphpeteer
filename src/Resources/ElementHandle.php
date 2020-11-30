<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Puphpeteer\Traits\AliasesSelectionMethods;
use Nesk\Puphpeteer\Traits\AliasesEvaluationMethods;

/**
 * @method \Nesk\Puphpeteer\Resources\ElementHandle<mixed>|null asElement()
 * @method \Nesk\Puphpeteer\Resources\Frame|null contentFrame()
 * @method void hover()
 * @method void click(array<string, mixed> $options = null)
 * @method string[] select(string ...$values)
 * @method void uploadFile(string ...$filePaths)
 * @method void tap()
 * @method void focus()
 * @method void type(string $text, array{ delay: float } $options = null)
 * @method void press(mixed $key, array<string, mixed> $options = null)
 * @method mixed|null boundingBox()
 * @method mixed|null boxModel()
 * @method string|mixed|null screenshot(array{  } $options = null)
 * @method bool isIntersectingViewport()
 */
class ElementHandle extends JSHandle
{
    use AliasesSelectionMethods, AliasesEvaluationMethods;
}
