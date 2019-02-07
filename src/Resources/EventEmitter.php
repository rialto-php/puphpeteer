<?php

namespace Nesk\Puphpeteer\Resources;

use Nesk\Rialto\Data\BasicResource;

/**
 * @method void addListener(string $eventName, \Nesk\Rialto\Data\JsFunction $listener)
 * @method bool emit(string $eventName, ...$args)
 * @method string[] eventNames()
 * @method int getMaxListeners()
 * @method int listenerCount(string $eventName)
 * @method $this off(string $eventName, \Nesk\Rialto\Data\JsFunction $listener)
 * @method $this on(string $eventName, \Nesk\Rialto\Data\JsFunction $listener)
 * @method $this once(string $eventName, \Nesk\Rialto\Data\JsFunction $listener)
 * @method $this prependListener(string $eventNAme, \Nesk\Rialto\Data\JsFunction $listener)
 * @method $this prependOnceListener(string $eventName, \Nesk\Rialto\Data\JsFunction $listener)
 * @method $this removeAllListeners(string $eventName = null)
 * @method $this removeListener(string $eventName, \Nesk\Rialto\Data\JsFunction $listener)
 * @method $this setMaxListeners(int $n)
 */
class EventEmitter extends BasicResource
{
    //
}
