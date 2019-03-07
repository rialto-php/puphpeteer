<?php

namespace Nesk\Puphpeteer\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Process;
use Nesk\Puphpeteer\Support\JsDocFormatter;
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
    protected static $defaultName = 'generate';

    /** @var InputInterface */
    protected $input;

    /** @var LoggerInterface */
    protected $logger;

    /** @var array */
    protected $classdefs;

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->addOption('puppeteerPath', null, InputOption::VALUE_OPTIONAL, 'The path where puppeteer is installed.', './node_modules/puppeteer');
    }

    /**
     * Get the documentation from the JavaScript source.
     *
     * @return array
     */
    protected function getDocumentation(): ?array
    {
        $path = $this->input->getOption('puppeteerPath');

        $process = new Process(['./node_modules/.bin/jsdoc', '-X', "{$path}/lib"]);
        $process->run();

        return json_decode($process->getOutput(), true);
    }

    /**
     * Get the ReflectionClass for the given resource name.
     *
     * @param string $className
     * @return \ReflectionClass
     */
    protected function getReflectionClass(string $className)
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
     *
     * @param array $docs
     * @return array
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
     *
     * @param array $docs
     * @return array
     */
    protected function getDoclets(array $docs): array
    {
        return array_filter($docs, function ($item) {
            if (! in_array($item['memberof'] ?? null, $this->classdefs)) {
                return false;
            }

            if (strpos($item['longname'], '<anonymous>') !== false) {
                return false;
            }

            if (($item['undocumented'] ?? false) || ($item['isEnum'] ?? false)) {
                return false;
            }

            if (! in_array($item['kind'], ['function', 'member'])) {
                return false;
            }

            if ($item['name'][0] === '_' || $item['name'][0] === '$') {
                return false;
            }

            if ($item['name'] === 'toString') {
                return false;
            }

            return true;
        });
    }

    /**
     * Put the doc comment in the PHP class.
     *
     * @param string $className
     * @param string $docComment
     * @return void
     */
    protected function putDocComment(string $className, string $docComment)
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
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|mixed|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->logger = new ConsoleLogger($output);

        $docs = $this->getDocumentation();

        $this->classdefs = $this->getClasses($docs);
        JsDocFormatter::setClassdefs($this->classdefs);

        $classes = static::group($this->getDoclets($docs), 'memberof');

        foreach ($classes as $class => $doclets) {
            $doclets = array_map(function ($doclet) {
                return JsDocFormatter::format($doclet);
            }, static::sort($doclets, 'name'));

            $this->putDocComment($class, JsDocFormatter::formatDocblock($doclets));
        }

        return null;
    }

    /**
     * Sort the array using the given column.
     *
     * @param array $array
     * @param string $column
     * @param bool|null $descending
     * @return array
     */
    protected static function sort(array $array, string $column, $descending = false)
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
     *
     * @param array $array
     * @param string $column
     * @return array
     */
    protected static function group(array $array, string $column)
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
