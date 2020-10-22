<?php

namespace Nesk\Puphpeteer;

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
		if ($className === 'HTTPResponse') {
			$className = 'Response';
		} elseif ($className === 'HTTPRequest') {
			$className = 'Request';
		}

        $class = "Nesk\\Puphpeteer\\Resources\\$className";

        return class_exists($class) ? $class : null;
    }
}
