<?php

namespace Nesk\Puphpeteer;

use Nesk\Puphpeteer\Support\Version;
use Nesk\Rialto\AbstractEntryPoint;
use Psr\Log\LoggerInterface;

class Puppeteer extends AbstractEntryPoint
{
    /**
     * Default options.
     *
     * @var array
     */
    protected $options = [
        'read_timeout' => 30,

        // Logs the output of Browser's console methods (console.log, console.debug, etc...) to the PHP logger
        'log_browser_console' => false,
    ];

    /**
     * Instanciate Puppeteer's entry point.
     */
    public function __construct(array $userOptions = [])
    {
        if (!empty($userOptions['logger']) && $userOptions['logger'] instanceof LoggerInterface) {
            $version = new Version(__DIR__.'/../package.json');
            $version->logUnexpectedPuppeteerVersion($userOptions['logger']);
        }

        parent::__construct(
            __DIR__.'/PuppeteerConnectionDelegate.js',
            new PuppeteerProcessDelegate,
            $this->options,
            $userOptions
        );
    }
}
