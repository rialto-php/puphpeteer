<?php

namespace Nesk\Puphpeteer\Tests;

use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use PHPUnit\Framework\ExpectationFailedException;
use Nesk\Puphpeteer\Resources\ElementHandle;
use Psr\Log\LoggerInterface;

class PuphpeteerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Serve the content of the "/resources"-folder to test these.
        $this->serveResources();

        // Launch the browser to run tests on.
        $this->launchBrowser();
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
     * @dataProvider resourceProvider
     * @dontPopulateProperties browser
     */
    public function check_all_resources_are_supported(string $name)
    {
        $incompleteTest = false;
        $resourceInstantiator = new ResourceInstantiator($this->browserOptions, $this->url);
        $resource = $resourceInstantiator->{$name}(new Puppeteer, $this->browserOptions);

        if ($resource instanceof UntestableResource) {
            $incompleteTest = true;
        } else if ($resource instanceof RiskyResource) {
            if (!empty($resource->exception())) {
                $incompleteTest = true;
            } else {
                try {
                    $this->assertInstanceOf("Nesk\\Puphpeteer\\Resources\\$name", $resource->value());
                } catch (ExpectationFailedException $exception) {
                    $incompleteTest = true;
                }
            }
        } else {
            $this->assertInstanceOf("Nesk\\Puphpeteer\\Resources\\$name", $resource);
        }

        if (!$incompleteTest) return;

        $reason = "The \"$name\" resource has not been tested properly, probably"
            ." for a good reason but you might want to have a look: \n\n    ";

        if ($resource instanceof UntestableResource) {
            $reason .= "\e[33mMarked as untestable.\e[0m";
        } else {
            if (!empty($exception = $resource->exception())) {
                $reason .= "\e[31mMarked as risky because of a Node error: {$exception->getMessage()}\e[0m";
            } else {
                $value = print_r($resource->value(), true);
                $reason .= "\e[31mMarked as risky because of an unexpected value: $value\e[0m";
            }
        }

        $this->markTestIncomplete($reason);
    }

    public function resourceProvider(): \Generator
    {
        $resourceNames = (new ResourceInstantiator([], ''))->getResourceNames();

        foreach ($resourceNames as $name) {
            yield [$name];
        }
    }

    private function createBrowserLogger(callable $onBrowserLog): LoggerInterface
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::atLeastOnce())
            ->method('log')
            ->willReturn(self::returnCallback(function (string $level, string $message) use ($onBrowserLog) {
                if (\strpos($message, "Received a Browser log:") === 0) {
                    $onBrowserLog();
                }

                return null;
            }));

        return $logger;
    }

    /**
     * @test
     * @dontPopulateProperties browser
     */
    public function browser_console_calls_are_logged_if_enabled()
    {
        $browserLogOccured = false;
        $logger = $this->createBrowserLogger(function () use (&$browserLogOccured) {
            $browserLogOccured = true;
        });

        $puppeteer = new Puppeteer([
            'log_browser_console' => true,
            'logger' => $logger,
        ]);

        $this->browser = $puppeteer->launch($this->browserOptions);
        $this->browser->pages()[0]->goto($this->url);

        static::assertTrue($browserLogOccured);
    }

    /**
     * @test
     * @dontPopulateProperties browser
     */
    public function browser_console_calls_are_not_logged_if_disabled()
    {
        $browserLogOccured = false;
        $logger = $this->createBrowserLogger(function () use (&$browserLogOccured) {
            $browserLogOccured = true;
        });

        $puppeteer = new Puppeteer([
            'log_browser_console' => false,
            'logger' => $logger,
        ]);

        $this->browser = $puppeteer->launch($this->browserOptions);
        $this->browser->pages()[0]->goto($this->url);

        static::assertFalse($browserLogOccured);
    }
}
