<?php

namespace Nesk\Puphpeteer\Tests;

use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use Symfony\Component\Process\Process;
use PHPUnit\Framework\ExpectationFailedException;
use Nesk\Puphpeteer\Resources\ElementHandle;

class PuphpeteerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->host = '127.0.0.1:8089';
        $this->url = "http://{$this->host}";
        $this->serverDir = __DIR__.'/resources';

        $this->servingProcess = new Process("php -S {$this->host} -t {$this->serverDir}");
        $this->servingProcess->start();

        // Chrome doesn't support Linux sandbox on many CI environments
        // See: https://github.com/GoogleChrome/puppeteer/blob/master/docs/troubleshooting.md#chrome-headless-fails-due-to-sandbox-issues
        $this->browserOptions = ['args' => ['--no-sandbox', '--disable-setuid-sandbox']];

        if ($this->canPopulateProperty('browser')) {
            $this->browser = (new Puppeteer)->launch($this->browserOptions);
        }
    }

    public function tearDown(): void
    {
        if (isset($this->browser)) {
            $this->browser->close();
        }

        $this->servingProcess->stop(0);
    }

    /** @test */
    public function can_browse_website()
    {
        $response = $this->browser->newPage()->goto($this->url);

        $this->assertTrue($response->ok(), 'Failed asserting that the response is successful.');
    }

    /**
     * @test
     */
    public function can_use_method_aliases()
    {
        $page = $this->browser->newPage();

        $page->goto($this->url);

        $select = function($resource) {
            $elements = [
                $resource->querySelector('h1'),
                $resource->querySelectorAll('h1')[0],
                $resource->querySelectorXPath('/html/body/h1')[0],
            ];

            $this->assertContainsOnlyInstancesOf(ElementHandle::class, $elements);
        };

        $evaluate = function($resource) {
            $strings = [
                $resource->querySelectorEval('h1', JsFunction::createWithBody('return "Hello World!";')),
                $resource->querySelectorAllEval('h1', JsFunction::createWithBody('return "Hello World!";')),
            ];

            foreach ($strings as $string) {
                $this->assertEquals('Hello World!', $string);
            }
        };

        // Test method aliases for Page, Frame and ElementHandle classes
        $resources = [$page, $page->mainFrame(), $page->querySelector('body')];
        foreach ($resources as $resource) {
            $select($resource);
            $evaluate($resource);
        }
    }

    /** @test */
    public function can_evaluate_a_selection()
    {
        $page = $this->browser->newPage();

        $page->goto($this->url);

        $title = $page->querySelectorEval('h1', JsFunction::createWithParameters(['node'])
            ->body('return node.textContent;'));

        $titleCount = $page->querySelectorAllEval('h1', JsFunction::createWithParameters(['nodes'])
            ->body('return nodes.length;'));

        $this->assertEquals('Example Page', $title);
        $this->assertEquals(1, $titleCount);
    }

    /** @test */
    public function can_intercept_requests()
    {
        $page = $this->browser->newPage();

        $page->setRequestInterception(true);

        $page->on('request', JsFunction::createWithParameters(['request'])
            ->body('request.resourceType() === "stylesheet" ? request.abort() : request.continue()'));

        $page->goto($this->url);

        $backgroundColor = $page->querySelectorEval('h1', JsFunction::createWithParameters(['node'])
            ->body('return getComputedStyle(node).textTransform'));

        $this->assertNotEquals('lowercase', $backgroundColor);
    }

    /**
     * @test
     * @dontPopulateProperties browser
     */
    public function check_all_resources_are_supported()
    {
        $incompleteResources = [];
        $resourceInstanciator = new ResourceInstanciator($this->browserOptions, $this->url);

        foreach ($resourceInstanciator->getResourceNames() as $name) {
            $resource = $resourceInstanciator->{$name}(new Puppeteer, $this->browserOptions);

            if ($resource instanceof UntestableResource) {
                $incompleteResources[$name] = $resource;
            } else if ($resource instanceof RiskyResource) {
                if (!empty($resource->exception())) {
                    $incompleteResources[$name] = $resource;
                } else {
                    try {
                        $this->assertInstanceOf("Nesk\\Puphpeteer\\Resources\\$name", $resource->value());
                    } catch (ExpectationFailedException $exception) {
                        $incompleteResources[$name] = $resource;
                    }
                }
            } else {
                $this->assertInstanceOf("Nesk\\Puphpeteer\\Resources\\$name", $resource);
            }
        }

        if (empty($incompleteResources)) return;

        $incompleteText = "The following resources have not been tested properly, probably"
            ." for good reasons but you might want to have a look:";

        foreach ($incompleteResources as $name => $resource) {
            if ($resource instanceof UntestableResource) {
                $reason = "Marked as untestable";
            } else if ($resource instanceof RiskyResource) {
                if (!empty($exception = $resource->exception())) {
                    $reason = "Marked as risky because of a Node error: {$exception->getMessage()}";
                } else {
                    $value = print_r($resource->value(), true);
                    $reason = "Marked as risky because of an unexpected value: $value";
                }
            } else {
                $reason = "Unknow reason";
            }

            $incompleteText .= "\n  • $name - $reason";
        }

        $this->markTestIncomplete($incompleteText);
    }

    /**
     * @test
     * @dontPopulateProperties browser
     */
    public function browser_console_calls_are_logged()
    {
        $setups = [
            [false, function ($browser) { return $browser->newPage(); }, 'Received data from the port'],
            [true, function ($browser) { return $browser->newPage(); }, 'Received a Browser log:'],
            [true, function ($browser) { return $browser->pages()[0]; }, 'Received a Browser log:'],
        ];

        foreach ($setups as [$shoulLogBrowserConsole, $pageFactory, $startsWith]) {
            $puppeteer = new Puppeteer([
                'log_browser_console' => $shoulLogBrowserConsole,
                'logger' => $this->loggerMock(
                    $this->at(9),
                    $this->isLogLevel(),
                    $this->stringStartsWith($startsWith)
                ),
            ]);

            $this->browser = $puppeteer->launch($this->browserOptions);
            $pageFactory($this->browser)->goto($this->url);
        }
    }
}
