<?php

namespace Nesk\Puphpeteer\Tests;

use Monolog\Logger;
use ReflectionClass;
use Psr\Log\LogLevel;
use PHPUnit\Framework\Constraint\Callback;
use PHPUnit\Framework\TestCase as BaseTestCase;
use PHPUnit\Framework\MockObject\Matcher\Invocation;

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

    public function loggerMock($expectations) {
        $loggerMock = $this->getMockBuilder(Logger::class)
            ->setConstructorArgs(['rialto'])
            ->setMethods(['log'])
            ->getMock();

        if ($expectations instanceof Invocation) {
            $expectations = [func_get_args()];
        }

        foreach ($expectations as $expectation) {
            [$matcher] = $expectation;
            $with = array_slice($expectation, 1);

            $loggerMock->expects($matcher)
                ->method('log')
                ->with(...$with);
        }

        return $loggerMock;
    }

    public function isLogLevel(): Callback {
        $psrLogLevels = (new ReflectionClass(LogLevel::class))->getConstants();
        $monologLevels = (new ReflectionClass(Logger::class))->getConstants();
        $monologLevels = array_intersect_key($monologLevels, $psrLogLevels);

        return $this->callback(function ($level) use ($psrLogLevels, $monologLevels) {
            if (is_string($level)) {
                return in_array($level, $psrLogLevels, true);
            } else if (is_int($level)) {
                return in_array($level, $monologLevels, true);
            }

            return false;
        });
    }
}
