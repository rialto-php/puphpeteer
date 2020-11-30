<?php

namespace Nesk\Puphpeteer\Command;

use Nesk\Puphpeteer\Puppeteer;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GenerateDocumentationCommand extends Command
{
    private const DOC_FILE_NAME = 'doc-generator';
    private const BUILD_DIR = __DIR__.'/../../.build';
    private const NODE_MODULES_DIR = __DIR__.'/../../node_modules';
    private const RESOURCES_DIR = __DIR__.'/../Resources';
    private const RESOURCES_NAMESPACE = 'Nesk\\Puphpeteer\\Resources';

    protected static $defaultName = 'doc:generate';

    protected function configure(): void
    {
        $this->addOption(
            'puppeteerPath',
            null,
            InputOption::VALUE_OPTIONAL,
            'The path where Puppeteer is installed.',
            self::NODE_MODULES_DIR.'/puppeteer'
        );
    }

    /**
     * Builds the documentation generator from TypeScript to JavaScript.
     */
    private static function buildDocumentationGenerator(): void
    {
        $process = new Process([
            self::NODE_MODULES_DIR.'/.bin/tsc',
            '--outDir',
            self::BUILD_DIR,
            __DIR__.'/../../src/'.self::DOC_FILE_NAME.'.ts',
        ]);
        $process->run();
    }

    /**
     * Gets the documentation from the TypeScript documentation generator.
     */
    private static function getDocumentation(string $puppeteerPath, array $resourceNames): array
    {
        self::buildDocumentationGenerator();

        $commonFiles = \glob("$puppeteerPath/lib/esm/puppeteer/common/*.d.ts");
        $nodeFiles = \glob("$puppeteerPath/lib/esm/puppeteer/node/*.d.ts");

        $process = new Process(
            \array_merge(
                ['node', self::BUILD_DIR.'/'.self::DOC_FILE_NAME.'.js', 'php'],
                $commonFiles,
                $nodeFiles,
                ['--resources-namespace', self::RESOURCES_NAMESPACE, '--resources'],
                $resourceNames
            )
        );
        $process->mustRun();

        return \json_decode($process->getOutput(), true);
    }

    private static function getResourceNames(): array
    {
        return array_map(function (string $filePath): string {
            return explode('.', \basename($filePath))[0];
        }, \glob(self::RESOURCES_DIR.'/*'));
    }

    private static function generatePhpDocWithDocumentation(array $classDocumentation): ?string
    {
        $properties = array_map(function (string $property): string {
            return "\n * @property $property";
        }, $classDocumentation['properties']);
        $properties = \implode('', $properties);

        $getters = array_map(function (string $getter): string {
            return "\n * @property-read $getter";
        }, $classDocumentation['getters']);
        $getters = \implode('', $getters);

        $methods = array_map(function (string $method): string {
            return "\n * @method $method";
        }, $classDocumentation['methods']);
        $methods = \implode('', $methods);

        if (\strlen($properties) > 0 || \strlen($getters) > 0 || \strlen($methods) > 0) {
            return "/**$properties$getters$methods\n */";
        }

        return null;
    }

    /**
     * Writes the doc comment in the PHP class.
     */
    private static function writePhpDoc(string $className, string $phpDoc): void
    {
        $reflectionClass = new \ReflectionClass($className);

        if (! $reflectionClass) {
            return;
        }

        $fileName = $reflectionClass->getFileName();

        $contents = file_get_contents($fileName);

        // If there already is a doc comment, replace it.
        if ($doc = $reflectionClass->getDocComment()) {
            $newContents = str_replace($doc, $phpDoc, $contents);
        } else {
            $startLine = $reflectionClass->getStartLine();

            $lines = explode("\n", $contents);

            $before = array_slice($lines, 0, $startLine - 1);
            $after = array_slice($lines, $startLine - 1);

            $newContents = implode("\n", array_merge($before, explode("\n", $phpDoc), $after));
        }

        file_put_contents($fileName, $newContents);
    }

    /**
     * Executes the current command.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $resourceNames = self::getResourceNames();
        $documentation = self::getDocumentation($input->getOption('puppeteerPath'), $resourceNames);

        foreach ($resourceNames as $resourceName) {
            $classDocumentation = $documentation[$resourceName] ?? null;

            if ($classDocumentation !== null) {
                $phpDoc = self::generatePhpDocWithDocumentation($classDocumentation);
                if ($phpDoc !== null) {
                    $resourceClass = self::RESOURCES_NAMESPACE.'\\'.$resourceName;
                    self::writePhpDoc($resourceClass, $phpDoc);
                }
            }
        }

        // Handle the specific Puppeteer class
        $classDocumentation = $documentation['Puppeteer'] ?? null;
        if ($classDocumentation !== null) {
            $phpDoc = self::generatePhpDocWithDocumentation($classDocumentation);
            if ($phpDoc !== null) {
                self::writePhpDoc(Puppeteer::class, $phpDoc);
            }
        }

        $missingResources = \array_diff(\array_keys($documentation), $resourceNames);
        foreach ($missingResources as $resource) {
            $io->warning("The $resource class in Puppeteer doesn't have any equivalent in PuPHPeteer.");
        }

        $inexistantResources = \array_diff($resourceNames, \array_keys($documentation));
        foreach ($inexistantResources as $resource) {
            $io->error("The $resource resource doesn't have any equivalent in Puppeteer.");
        }

        return 0;
    }
}
