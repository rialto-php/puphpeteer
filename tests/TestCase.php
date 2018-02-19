<?php

namespace ExtractrIo\Puphpeteer\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    private $dontPopulateProperties = [];

    public function setUp(): void
    {
        parent::setUp();

        $testMethod = new \ReflectionMethod($this, $this->getName());
        $docComment = $testMethod->getDocComment();

        if (preg_match('/@dontPopulateProperties (.*)/', $docComment, $matches)) {
            $this->dontPopulateProperties = array_values(array_filter(explode(' ', $matches[1])));
        }
    }

    public function canPopulateProperty(string $propertyName): bool
    {
        return !in_array($propertyName, $this->dontPopulateProperties);
    }
}
