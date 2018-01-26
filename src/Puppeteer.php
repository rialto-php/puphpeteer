<?php

namespace ExtractrIo\Puphpeteer;

use ExtractrIo\Rialto\AbstractEntryPoint;

class Puppeteer extends AbstractEntryPoint
{
    /**
     * Instanciate Puppeteer's entry point.
     */
    public function __construct(array $userOptions = [])
    {
        parent::__construct(
            new PuppeteerProcessDelegate,
            __DIR__.'/PuppeteerConnectionDelegate.js',
            ['read_timeout' => 35],
            $userOptions
        );
    }
}
