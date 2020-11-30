<?php

namespace Nesk\Puphpeteer\Tests;

use Nesk\Rialto\Data\JsFunction;

class ResourceInstantiator
{
    protected $resources = [];

    public function __construct(array $browserOptions, string $url) {
        $this->browserOptions = $browserOptions;
        $this->url = $url;

        $this->resources = [
            'Accessibility' => function ($puppeteer) {
                return $this->Page($puppeteer)->accessibility;
            },
            'Browser' => function ($puppeteer) {
                return $puppeteer->launch($this->browserOptions);
            },
            'BrowserContext' => function ($puppeteer) {
                return $this->Browser($puppeteer)->createIncognitoBrowserContext();
            },
            'BrowserFetcher' => function ($puppeteer) {
                return $puppeteer->createBrowserFetcher();
            },
            'CDPSession' => function ($puppeteer) {
                return $this->Target($puppeteer)->createCDPSession();
            },
            'ConsoleMessage' => function () {
                return new UntestableResource;
            },
            'Coverage' => function ($puppeteer) {
                return $this->Page($puppeteer)->coverage;
            },
            'Dialog' => function () {
                return new UntestableResource;
            },
            'ElementHandle' => function ($puppeteer) {
                return $this->Page($puppeteer)->querySelector('body');
            },
            'EventEmitter' => function ($puppeteer) {
                return $puppeteer->launch($this->browserOptions);
            },
            'ExecutionContext' => function ($puppeteer) {
                return $this->Frame($puppeteer)->executionContext();
            },
            'FileChooser' => function () {
                return new UntestableResource;
            },
            'Frame' => function ($puppeteer) {
                return $this->Page($puppeteer)->mainFrame();
            },
            'HTTPRequest' => function ($puppeteer) {
                return $this->HTTPResponse($puppeteer)->request();
            },
            'HTTPResponse' => function ($puppeteer) {
                return $this->Page($puppeteer)->goto($this->url);
            },
            'JSHandle' => function ($puppeteer) {
                return $this->Page($puppeteer)->evaluateHandle(JsFunction::createWithBody('window'));
            },
            'Keyboard' => function ($puppeteer) {
                return $this->Page($puppeteer)->keyboard;
            },
            'Mouse' => function ($puppeteer) {
                return $this->Page($puppeteer)->mouse;
            },
            'Page' => function ($puppeteer) {
                return $this->Browser($puppeteer)->newPage();
            },
            'SecurityDetails' => function ($puppeteer) {
                return new RiskyResource(function () use ($puppeteer) {
                    return $this->Page($puppeteer)->goto('https://example.com')->securityDetails();
                });
            },
            'Target' => function ($puppeteer) {
                return $this->Page($puppeteer)->target();
            },
            'TimeoutError' => function () {
                return new UntestableResource;
            },
            'Touchscreen' => function ($puppeteer) {
                return $this->Page($puppeteer)->touchscreen;
            },
            'Tracing' => function ($puppeteer) {
                return $this->Page($puppeteer)->tracing;
            },
            'WebWorker' => function ($puppeteer) {
                $page = $this->Page($puppeteer);
                $page->goto($this->url, ['waitUntil' => 'networkidle0']);
                return $page->workers()[0];
            },
        ];
    }

    public function getResourceNames(): array
    {
        return array_keys($this->resources);
    }

    public function __call(string $name, array $arguments)
    {
        if (!isset($this->resources[$name])) {
            throw new \InvalidArgumentException("The $name resource is not supported.");
        }

        return $this->resources[$name](...$arguments);
    }
}
