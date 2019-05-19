<?php

namespace Nesk\Puphpeteer\Tests\Support;

use Nesk\Puphpeteer\Support\Version;
use Nesk\Puphpeteer\Tests\TestCase;
use org\bovigo\vfs\vfsStream;

class DocumentationFormatterTest extends TestCase
{
    private const STREAM_NAME = 'puphpeteer';
    private const PACKAGE_PATH = self::STREAM_NAME.'/node_modules/puppeteer/package.json';
    private const NESTED_PATH = self::STREAM_NAME.'/node_modules/nested/directory';
    private const MANIFEST_PATH = self::STREAM_NAME.'/package.json';
    private const VERSION = '1.2.3';

    public function setUp(): void
    {
        vfsStream::setup(self::STREAM_NAME);

        mkdir(vfsStream::url(dirname(self::PACKAGE_PATH)), 0777, true);
        file_put_contents(vfsStream::url(self::PACKAGE_PATH), json_encode(['version' => self::VERSION]));

        mkdir(vfsStream::url(dirname(self::NESTED_PATH)), 0777, true);
    }

    /** @test */
    public function retrieve_puppeteer_version(): void
    {
        $version = new Version('', vfsStream::url(self::STREAM_NAME));

        static::assertSame(self::VERSION, $version->currentPuppeteerVersion());
    }

    /** @test */
    public function retrieve_puppeteer_version_from_nested_directory(): void
    {
        $version = new Version('', vfsStream::url(self::NESTED_PATH));

        static::assertSame(self::VERSION, $version->currentPuppeteerVersion());
    }
}
