<?php

namespace Nesk\Puphpeteer\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Process;
use Nesk\Puphpeteer\Support\DocumentationFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDocumentationCommand extends Command
{
    /**
     * The default command name.
     *
     * @var string
     */
    protected static $defaultName = 'generate:documentation';

    /** @var InputInterface */
    protected $input;

    /** @var LoggerInterface */
    protected $logger;

    /** @var array */
    protected $classdefs;

    /** @var DocumentationFormatter */
    protected $formatter;

    /**
     * Configure the command.
     */
    protected function configure(): void
    {
        $this->addOption(
            'puppeteerPath',
            null,
            InputOption::VALUE_OPTIONAL,
            'The path where puppeteer is installed.',
            __DIR__.'/../../node_modules/puppeteer'
        );
    }

    /**
     * Get the documentation from the JavaScript source.
     */
    protected function getDocumentation(): ?array
    {
        $path = $this->input->getOption('puppeteerPath');

        $process = new Process([__DIR__.'/../../node_modules/.bin/jsdoc', '-X', "$path/lib"]);
        $process->run();

        return json_decode($process->getOutput(), true);
    }

    /**
     * Get the ReflectionClass for the given resource name.
     */
    protected function getReflectionClass(string $className): ?\ReflectionClass
    {
        try {
            return new \ReflectionClass('Nesk\\Puphpeteer\\Resources\\'.$className);
        } catch (\ReflectionException $e) {
            $this->logger->warning("Cannot find Resource class for {$className}.");
            return null;
        }
    }

    /**
     * Get the class definitions from the docs.
     */
    protected function getClasses(array $docs): array
    {
        $classdefs = array_filter($docs, function ($doclet) {
            return $doclet['kind'] === 'class';
        });

        return array_map(function ($doclet) {
            return $doclet['longname'];
        }, $classdefs);
    }

    /**
     * Get the function and member doclets from the docs.
     */
    protected function getDoclets(array $docs): array
    {
        $doclets = array_filter($docs, function ($item) {
            if (! in_array($item['memberof'] ?? null, $this->classdefs)) {
                return false;
            }

            if (strpos($item['longname'], '<anonymous>') !== false) {
                return false;
            }

            if (($item['isEnum'] ?? false)) {
                return false;
            }

            if (! in_array($item['kind'], ['function', 'member'])) {
                return false;
            }

            if ($item['scope'] === 'static') {
                return false;
            }

            if ($item['name'][0] === '_') {
                return false;
            }

            if ($item['name'] === 'toString') {
                return false;
            }

            return true;
        });

        $doclets = array_map(function ($item) {
            $item['name'] = preg_replace_callback('/^(\${1,2})(?:(\w)(.*)|$)/', function ($matches) {
                $invalidCharsReplacement = $matches[1] === '$' ? 'querySelector' : 'querySelectorAll';
                $firstAlphaLetter = strtoupper($matches[2] ?? '');
                $nameEnd = empty($matches[3]) && $firstAlphaLetter === 'X' ? 'Path' : $matches[3] ?? '';

                return "{$invalidCharsReplacement}{$firstAlphaLetter}{$nameEnd}";
            }, $item['name']);

            return $item;
        }, $doclets);

        return $doclets;
    }

    /**
     * Put the doc comment in the PHP class.
     */
    protected function putDocComment(string $className, string $docComment): void
    {
        $class = $this->getReflectionClass($className);

        if (! $class) {
            return;
        }

        $fileName = $class->getFileName();

        $contents = file_get_contents($fileName);

        // If there already is a doc comment, replace it.
        if ($doc = $class->getDocComment()) {
            $newContents = str_replace($doc, $docComment, $contents);
        } else {
            $startLine = $class->getStartLine();

            $lines = explode("\n", $contents);

            $before = array_slice($lines, 0, $startLine - 1);
            $after = array_slice($lines, $startLine - 1);

            $newContents = implode("\n", array_merge($before, explode("\n", $docComment), $after));
        }

        file_put_contents($fileName, $newContents);
    }

    /**
     * Executes the current command.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->logger = new ConsoleLogger($output);

        $docs = $this->getDocumentation();

        $this->classdefs = $this->getClasses($docs);
        $this->formatter = new DocumentationFormatter($this->classdefs);

        $classes = static::group($this->getDoclets($docs), 'memberof');

        foreach ($classes as $class => $doclets) {
            $doclets = array_map(function ($doclet) {
                return $this->formatter->format($doclet);
            }, static::sort($doclets, 'name'));

            $this->putDocComment($class, $this->formatter->formatDocblock($doclets));
        }

        return 0;
    }

    /**
     * Sort the array using the given column.
     */
    protected static function sort(array $array, string $column, bool $descending = false): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            $results[$key] = $column ? $value[$column] : $value;
        }

        $descending ? arsort($results)
            : asort($results);

        foreach (array_keys($results) as $key) {
            $results[$key] = $array[$key];
        }

        return $results;
    }

    /**
     * Group the array by the given column.
     */
    protected static function group(array $array, string $column): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            $groupKey = $value[$column];

            if (! array_key_exists($groupKey, $results)) {
                $results[$groupKey] = [];
            }

            $results[$groupKey][] = $value;
        }

        return $results;
    }
}
