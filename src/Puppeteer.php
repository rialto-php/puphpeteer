<?php

namespace ExtractrIo\Puphpeteer;

use ExtractrIo\Rialto\AbstractEntryPoint;

class Puppeteer extends AbstractEntryPoint
{
    /**
     * Constructor.
     */
    public function __construct(array $options = [])
    {
        // Reject the "stop_timeout" option
        $options = array_diff_key($options, array_flip(['stop_timeout']));

        // Merge the user options with our own defaults
        $options = array_merge(['read_timeout' => 35], $options);

        $this->createProcess(new PuppeteerProcessDelegate, __DIR__.'/PuppeteerConnectionDelegate.js', $options);
    }
}
