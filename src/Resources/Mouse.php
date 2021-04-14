<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method void move(float $x, float $y, array $options = [])
 * @method-extended void move(float $x, float $y, array{ steps: float } $options = null)
 * @method void click(float $x, float $y, array $options = [])
 * @method-extended void click(float $x, float $y, array<string, mixed>&array{ delay: float } $options = null)
 * @method void down(array $options = [])
 * @method-extended void down(array<string, mixed> $options = null)
 * @method void up(array $options = [])
 * @method-extended void up(array<string, mixed> $options = null)
 * @method void wheel(array $options = [])
 * @method-extended void wheel(array<string, mixed> $options = null)
 */
class Mouse extends BasicResource
{
    //
}
