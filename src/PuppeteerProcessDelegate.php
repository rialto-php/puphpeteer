<?php

namespace ExtractrIo\Puphpeteer;

use Nesk\Rialto\Traits\UsesBasicResourceAsDefault;
use Nesk\Rialto\Interfaces\ShouldHandleProcessDelegation;

class PuppeteerProcessDelegate implements ShouldHandleProcessDelegation
{
    use UsesBasicResourceAsDefault;

    /**
     * {@inheritDoc}
     */
    public function resourceFromOriginalClassName(string $className): ?string
    {
        $class = "ExtractrIo\\Puphpeteer\\Resources\\$className";

        return class_exists($class) ? $class : null;
    }
}
