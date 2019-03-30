<?php

namespace Nesk\Puphpeteer\Support;

class DocumentationFormatter
{
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

    /**
     * The defined classes.
     *
     * @var array
     */
    protected $classdefs = [];

    /**
     * JsDocFormatter constructor.
     *
     * @param array $classdefs
     */
    public function __construct(array $classdefs)
    {
        $this->classdefs = $classdefs;
    }

    /**
     * Format a doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public function format(array $doclet)
    {
        $kind = $doclet['kind'];
        $method = "format{$kind}";

        if (! method_exists($this, $method)) {
            throw new \LogicException("Missing format implementation for {$kind}");
        }

        return $this->{$method}($doclet);
    }

    /**
     * Format a function doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public function formatFunction(array $doclet): string
    {
        $name = $doclet['name'];
        $isStatic = $doclet['scope'] === 'static';

        $return = $doclet['returns'][0] ?? null;
        $isNullable = $return['nullable'] ?? false;

        // Format the return type.
        $type = $return && array_key_exists('type', $return) ? $this->formatType($return['type']) : 'void';

        $type = $isNullable ? $type.'|null' : $type;

        // Format the parameters.
        $params = implode(', ', array_map(function ($param) {
            return $this->formatParam($param);
        }, $doclet['params'] ?? []));

        if ($isStatic) {
            return "@method static {$type} {$name}({$params})";
        }

        return "@method {$type} {$name}({$params})";
    }

    /**
     * Format a member doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public function formatMember(array $doclet): string
    {
        $name = $doclet['name'];

        // Format the return type.
        $return = array_key_exists('returns', $doclet) ? $this->formatType($doclet['returns'][0]['type']) : 'mixed';

        return "@property {$return} \${$name}";
    }

    /**
     * Format a param doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public function formatParam(array $doclet): string
    {
        $name = $doclet['name'];
        $isOptional = $doclet['optional'] ?? false;
        $isVariable = $doclet['variable'] ?? false;
        $isNullable = $doclet['nullable'] ?? false;
        $default = $doclet['defaultvalue'] ?? null;

        $type = array_key_exists('type', $doclet) ? $this->formatType($doclet['type']) : 'array';

        if ($isVariable) {
            $type = explode('[]', $type)[0];
            return "{$type} ...\${$name}";
        }

        $isArray = $type === 'array' || substr($type, -strlen('[]')) === '[]';
        $isString = $type === 'string';

        $type = $isNullable ? $type.'|null' : $type;

        $default = is_null($default) ? 'null' : ($isString ? "'{$default}'" : $default);

        $suffix = $isOptional ? (' = '.($isArray ? '[]' : $default)) : '';

        return "{$type} \${$name}{$suffix}";
    }

    /**
     * Format a type doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public function formatType(array $doclet): string
    {
        $name = $doclet['names'][0];

        // Unwrap Promise
        if (preg_match('/Promise\.<[\!\?]?(.+)>/', $name, $matches)) {
            $name = $matches[1];
        }

        // Unwrap Array and Sets
        $suffix = null;
        if (preg_match('/(?:Array|Set)\.<[\!\?]?(.+)>/', $name, $matches)) {
            $name = $matches[1];
            $suffix = '[]';
        }

        // Maps Are Arrays
        if (preg_match('/(?:Map)\.<[\!\?]?(.+)>/', $name)) {
            $name = 'array';
        }

        // Normalize Puppeteer namespace
        if (preg_match('/Puppeteer\.(.+)/', $name, $matches)) {
            $name = $matches[1];
        }

        $name = $this->typeMap[$name] ?? $name;

        if (in_array($name, $this->classdefs) || in_array($name, $this->primitives)) {
            return $name.$suffix;
        }

        // Everything is an object (array) in JavaScript.
        return '\Nesk\Rialto\Data\BasicResource'.$suffix;
    }

    /**
     * Format an array of doclet strings as a docblock.
     *
     * @param string[] $doclets
     * @return string
     */
    public function formatDocblock($doclets)
    {
        return implode(PHP_EOL, array_merge(['/**'], array_map(function ($doclet) {
            return ' * '.$doclet;
        }, $doclets), [' */']));
    }
}
