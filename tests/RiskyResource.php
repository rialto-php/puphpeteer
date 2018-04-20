<?php

namespace ExtractrIo\Puphpeteer\Tests;

use ExtractrIo\Rialto\Exceptions\Node\FatalException as NodeFatalException;

class RiskyResource
{
    protected $value = null;
    protected $exception = null;

    public function __construct(callable $resourceRetriever) {
        try {
            $this->value = $resourceRetriever();
        } catch (NodeFatalException $exception) {
            $this->exception = $exception;
        }
    }

    public function value() {
        return $this->value;
    }

    public function exception(): ?NodeFatalException {
        return $this->exception;
    }
}
