<?php

namespace Nesk\Puphpeteer\Support;

class JsDocFormatter
{
    /**
     * The types that should be kept as-is.
     *
     * @var array
     */
    static protected $primitives = [
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
    static protected $typeMap = [
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
    static protected $classdefs = [];

    /**
     * Format a doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public static function format(array $doclet)
    {
        $kind = $doclet['kind'];
        $method = "format{$kind}";

        if (! method_exists(static::class, $method)) {
            throw new \LogicException("Missing format implementation for {$kind}");
        }

        return static::{$method}($doclet);
    }

    /**
     * Format a function doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public static function formatFunction(array $doclet): string
    {
        $name = $doclet['name'];
        $static = $doclet['scope'] ?? null === 'static';

        // Format the return type.
        $return = array_key_exists('returns', $doclet) ? static::formatType($doclet['returns'][0]['type']) : 'void';

        // Format the parameters.
        $params = implode(', ', array_map(function ($param) {
            return static::formatParam($param);
        }, $doclet['params'] ?? []));

        if ($static) {
            return "@method static {$return} {$name}({$params})";
        }

        return "@method {$return} {$name}({$params})";
    }

    /**
     * Format a member doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public static function formatMember(array $doclet): string
    {
        $name = $doclet['name'];

        // Format the return type.
        $return = array_key_exists('returns', $doclet) ? static::formatType($doclet['returns'][0]['type']) : 'mixed';

        return "@property {$return} \${$name}";
    }

    /**
     * Format a param doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public static function formatParam(array $doclet): string
    {
        $name = $doclet['name'];
        $isOptional = $doclet['optional'] ?? false;
        $isVariable = $doclet['variable'] ?? false;
        $default = $doclet['defaultvalue'] ?? 'null';

        $type = array_key_exists('type', $doclet) ? static::formatType($doclet['type']) : 'mixed';

        if ($isVariable) {
            $type = explode('[]', $type)[0];
            return "{$type} ...\${$name}";
        }

        $isArray = $type === 'array' || substr($type, -strlen('[]')) === '[]';
        $isString = $type === 'string';

        $default = $isString ? "'{$default}'" : $default;

        $suffix = $isOptional ? (' = '.($isArray ? '[]' : $default)) : '';

        return "{$type} \${$name}".$suffix;
    }

    /**
     * Format a type doclet as a string.
     *
     * @param array $doclet
     * @return string
     */
    public static function formatType(array $doclet): string
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

        // Normalize Puppeteer namespace
        if (preg_match('/Puppeteer\.(.+)/', $name, $matches)) {
            $name = $matches[1];
        }

        $name = static::$typeMap[$name] ?? $name;

        if (in_array($name, static::$classdefs) || in_array($name, static::$primitives)) {
            return $name.$suffix;
        }

        // Everything is an object (array) in JavaScript.
        return 'array'.$suffix;
    }

    /**
     * Format an array of doclet strings as a docblock.
     *
     * @param string[] $doclets
     * @return string
     */
    public static function formatDocblock($doclets)
    {
        return implode(PHP_EOL, array_merge(['/**'], array_map(function ($doclet) {
            return ' * '.$doclet;
        }, $doclets), [' */']));
    }

    /**
     * Set the array of class definitions.
     *
     * @param array $classdefs
     */
    public static function setClassdefs(array $classdefs)
    {
        static::$classdefs = $classdefs;
    }
}
