<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method void down(mixed $key, array{ text: string } $options = null)
 * @method void up(mixed $key)
 * @method void sendCharacter(string $char)
 * @method void type(string $text, array{ delay: float } $options = null)
 * @method void press(mixed $key, array{ delay: float, text: string } $options = null)
 */
class Keyboard extends BasicResource
{
    //
}
