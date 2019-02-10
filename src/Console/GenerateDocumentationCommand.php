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
        'Object' => 'array',
        'boolean' => 'bool',
        'function' => 'JSFunction',
        'any' => 'mixed',
        '*' => 'mixed',
    ];

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
        return json_decode(shell_exec("./node_modules/.bin/jsdoc {$path}/lib -X"), true);
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
    protected function transformType(?string $type): string
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
     * Format a value in a method string.
     *
     * @param array $value
     * @return string
     */
    protected function formatMethod(array $value): string
    {
        $name = $value['name'];

        // Transform the parameters.
        $params = implode(', ', array_map(function ($param) {
            $name = $param['name'];
            $optional = $param['optional'] ?? false;
            $default = $param['defaultvalue'] ?? 'null';

            $type = $this->transformType($param['type']['names'][0] ?? null);

            return "{$type} \${$name}".($optional ? ' = '.$default : '');
        }, $value['params']));

        // Transform the return type.
        $return = $this->transformType($value['returns'][0]['type']['names'][0] ?? 'void');

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

        // Transform the return type.
        $return = $this->transformType($value['returns'][0]['type']['names'][0] ?? null);

        return "@property {$return} \${$name}";
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
        $puppeteerPath = $input->getOption('puppeteerPath');

        $data = $this->getDocumentation($puppeteerPath);
        $data = $this->filter($data);
        $data = array_group_by($data, 'memberof');

        $members = array_reduce(array_keys($data), function ($previous, $member) use ($data) {
            $values = $data[$member];

            $values = array_sort_by($values, 'name');

            $values = array_map(function ($value) {
                switch ($value['kind']) {
                    case 'function':
                        return $this->formatMethod($value);
                    case 'member':
                        return $this->formatProperty($value);
                    default:
                        throw new LogicException("Missing implementation for {$value['kind']}");
                }
            }, $values);

            $previous[$member] = $values;

            return $previous;
        }, []);

        $output->writeln('found '.sizeof($members).' classes.');

        // TODO: implement writing to php classes

        return null;
    }
}
