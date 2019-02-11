<?php

namespace Nesk\Puphpeteer\Console;

use LogicException;
use Tightenco\Collect\Support\Collection;
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

    /**
     * The types that should be kept as-is.
     *
     * @var array
     */
    protected $primitives = [
        '\Nesk\Rialto\Data\JsFunction',
        'string',
        'int',
        'float',
        'bool',
        'array',
        'resource',
        'callable',
        'null',
        'mixed',
        'void',
    ];

    /**
     * The mapping of JavaScript to PHP types.
     *
     * @var array
     */
    protected $typeMap = [
        'function' => '\Nesk\Rialto\Data\JsFunction',
        'Promise' => 'void',
        'Object' => 'array',
        'boolean' => 'bool',
        'number' => 'int',
        'any' => 'mixed',
        '*' => 'mixed',
    ];

    /** @var InputInterface */
    protected $input;

    /** @var OutputInterface */
    protected $output;

    /** @var Collection */
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
     * @param string $path
     * @return array
     */
    protected function getDocumentation(string $path): array
    {
        return json_decode(shell_exec("./node_modules/.bin/jsdoc {$path}/lib -X 2> /dev/null"), true);
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

        // Unwrap Array and Sets
        $suffix = null;
        if (preg_match('/(?:Array|Set)\.<[\!\?]?(.+)>/', $type, $matches)) {
            $type = $matches[1];
            $suffix = '[]';
        }

        // Normalize Puppeteer namespace
        if (preg_match('/Puppeteer\.(.+)/', $type, $matches)) {
            $type = $matches[1];
        }

        $type = array_get($this->typeMap, $type, $type);

        if ($this->classdefs->contains($type) || collect($this->primitives)->contains($type)) {
            return $type.$suffix;
        }

        // Everything is an object (array) in JavaScript.
        return 'array'.$suffix;
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
        $spread = $value['variable'] ?? false;

        $type = $this->formatType($value['type']['names'][0] ?? null);

        if ($spread) {
            return "{$type} ...\${$name}";
        }

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
     * @param Collection $comments
     * @return string
     */
    protected function formatDocComment(string $class, Collection $comments)
    {
        $comments = collect([$class, ''])->merge($comments)->map(function ($comment) {
            return ' * '.$comment;
        });

        return collect('/**')->merge($comments)->push(' */')->implode("\n");
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
            $this->output->writeln("Cannot find Resource class for {$className}.");
            return null;
        }
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
        $this->output = $output;

        $puppeteerPath = $input->getOption('puppeteerPath');

        $data = collect($this->getDocumentation($puppeteerPath));

        $this->classdefs = $data->where('kind', 'class')->map->name->unique();

        $data->whereIn('memberof', $this->classdefs)
            ->filter($this->getMemberFilter())
            ->groupBy('memberof')->mapWithKeys(function ($items, $member) {
                $comments = collect($items)->sortBy('name')->map(function ($item) {
                    switch ($item['kind']) {
                        case 'function':
                            return $this->formatMethod($item);
                        case 'member':
                            return $this->formatProperty($item);
                        default:
                            throw new LogicException("Missing format implementation for {$item['kind']}");
                    }
                });

                return [$member => $comments];
            })->each(function ($comments, $class) {
                $docComment = $this->formatDocComment($class, $comments);
                $this->putDocComment($class, $docComment);
            });

        return null;
    }

    /**
     * Get the filter method.
     *
     * @return \Closure
     */
    protected function getMemberFilter()
    {
        return function ($item) {
            if (str_contains(array_get($item, 'longname'), '<anonymous>')) {
                return false;
            }

            if (array_get($item, 'undocumented') || array_get($item, 'isEnum')) {
                return false;
            }

            if (! in_array(array_get($item, 'kind'), ['function', 'member'])) {
                return false;
            }

            if (str_startswith(array_get($item, 'name'), ['_', '$'])) {
                return false;
            }

            return true;
        };
    }
}
