<?php

namespace Nesk\Puphpeteer\Console;

use LogicException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDocumentationCommand extends Command
{
    /**
     * The default command name.
     *
     * @var string
     */
    protected static $defaultName = 'generate';

    protected $typeMap = [
        'function' => '\Nesk\Rialto\Data\JsFunction',
        'Promise' => 'void',
        'Object' => 'array',
        'boolean' => 'bool',
        'number' => 'int',
        'any' => 'mixed',
    ];

    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->addOption('pretend', 'p', InputOption::VALUE_OPTIONAL, 'Dump the diff that would be written.');
        $this->addOption('puppeteerPath', null, InputOption::VALUE_OPTIONAL, 'The path where puppeteer is installed.', './node_modules/puppeteer');
    }

    /**
     * Get the documentation from the JavaScript source.
     *
     * @param string $path
     * @return array
     */
    protected function getDocumentation(string $path): array
    {
        return json_decode(shell_exec("./node_modules/.bin/jsdoc {$path}/lib -X 2> /dev/null"), true);
    }

    /**
     * Filter the documentation items.
     *
     * @param array $data
     * @return array
     */
    protected function filter(array $data): array
    {
        return array_filter($data, function ($value) {
            if (array_get($value, 'undocumented')) {
                return false;
            }

            if (strpos(array_get($value, 'longname'), '<anonymous>') !== false) {
                return false;
            }

            switch ($value['kind']) {
                case 'function':
                case 'member':
                    return ! str_startswith($value['name'], '_') && $value['scope'] !== 'inner' && ! array_key_exists('isEnum', $value);
                default:
                    return false;
            }
        });
    }

    /**
     * Transform the type string.
     *
     * @param string $type
     * @return string
     */
    protected function formatType(?string $type): string
    {
        if (is_null($type)) {
            return 'mixed';
        }

        // Unwrap Promise
        if (preg_match('/Promise\.<[\!\?]?(.+)>/', $type, $matches)) {
            $type = $matches[1];
        }

        // Unwrap Array
        $array = false;
        if (preg_match('/Array\.<[\!\?]?(.+)>/', $type, $matches)) {
            $type = $matches[1];
            $array = true;
        }

        // Normalize Puppeteer namespace
        if (preg_match('/Puppeteer\.(.+)/', $type, $matches)) {
            $type = $matches[1];
        }

        return array_get($this->typeMap, $type, $type).($array ? '[]' : '');
    }

    /**
     * Format a value in a parameter string.
     *
     * @param array $value
     * @return string
     */
    protected function formatParam(array $value): string
    {
        $name = $value['name'];
        $optional = $value['optional'] ?? false;
        $default = $value['defaultvalue'] ?? 'null';

        $type = $this->formatType($value['type']['names'][0] ?? null);

        $isArray = $type === 'array' || str_endswith($type, '[]');
        $isString = $type === 'string';

        $default = $isString ? "'{$default}'" : $default;

        $suffix = $optional ? (' = '.($isArray ? '[]' : $default)) : '';

        return "{$type} \${$name}".$suffix;
    }

    /**
     * Format a value in a method string.
     *
     * @param array $value
     * @return string
     */
    protected function formatMethod(array $value): string
    {
        $name = $value['name'];

        $static = array_get($value, 'scope') === 'static';

        // Format the return type.
        $return = $this->formatType($value['returns'][0]['type']['names'][0] ?? 'void');

        // Format the parameters.
        $params = implode(', ', array_map(function ($param) {
            return $this->formatParam($param);
        }, $value['params']));

        if ($static) {
            return "@method static {$return} {$name}({$params})";
        }

        return "@method {$return} {$name}({$params})";
    }

    /**
     * Format a value in a property string.
     *
     * @param array $value
     * @return string
     */
    protected function formatProperty(array $value): string
    {
        $name = $value['name'];

        // Format the return type.
        $return = $this->formatType($value['returns'][0]['type']['names'][0] ?? null);

        return "@property {$return} \${$name}";
    }

    /**
     * Format an array of comments in a doc comment.
     *
     * @param string $class
     * @param array $comments
     * @return string
     */
    protected function formatDocComment(string $class, array $comments)
    {
        $comments = array_map(function ($line) {
            return ' * '.$line;
        }, array_merge([$class, ''], $comments));

        return implode("\n", array_merge(['/**'], $comments, [' */']));
    }

    /**
     * Put the doc comment
     *
     * @param string $className
     * @param string $docComment
     * @return void
     */
    protected function putDocComment(string $className, string $docComment)
    {
        try {
            $class = new \ReflectionClass('Nesk\\Puphpeteer\\Resources\\'.$className);

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
        } catch (\ReflectionException $e) {
            $this->output->writeln("Cannot find Resource class for {$className}.");
        }
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
        $this->output = $output;

        $puppeteerPath = $input->getOption('puppeteerPath');

        $data = $this->getDocumentation($puppeteerPath);
        $data = $this->filter($data);
        $data = array_group_by($data, 'memberof');

        $data = array_map_with_keys($data, function ($items, $member) {
            $comments = array_map(function ($value) {
                switch ($value['kind']) {
                    case 'function':
                        return $this->formatMethod($value);
                    case 'member':
                        return $this->formatProperty($value);
                    default:
                        throw new LogicException("Missing format implementation for {$value['kind']}");
                }
            }, array_sort_by($items, 'name'));

            return [$member => $comments];
        });

        foreach ($data as $class => $comments) {
            $this->putDocComment($class, $this->formatDocComment($class, $comments));
        }

        return null;
    }
}
