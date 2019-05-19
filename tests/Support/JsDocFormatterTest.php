<?php

namespace Nesk\Puphpeteer\Tests\Support;

use Nesk\Puphpeteer\Support\DocumentationFormatter;
use Nesk\Puphpeteer\Tests\TestCase;

class DocumentationFormatterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->formatter = new DocumentationFormatter([]);
    }

    /** @test */
    public function can_format_function_type()
    {
        $type = [
            'names' => ['function']
        ];

        $this->assertEquals('\Nesk\Rialto\Data\JsFunction', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_primitive_type()
    {
        $type = [
            'names' => ['string']
        ];

        $this->assertEquals('string', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_named_type()
    {
        $type = [
            'names' => ['ChromeArgs']
        ];

        $this->assertEquals('\Nesk\Rialto\Data\BasicResource', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_puppeteer_namespaced_type()
    {
        $this->formatter = new DocumentationFormatter(['Browser']);

        $type = [
            'names' => ['Puppeteer.Browser']
        ];

        $this->assertEquals('Browser', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_promise_wrapped_type()
    {
        $type = [
            'names' => ['Promise.<string>']
        ];

        $this->assertEquals('string', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_array_wrapped_type()
    {
        $type = [
            'names' => ['Array.<string>']
        ];

        $this->assertEquals('string[]', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_set_wrapped_type()
    {
        $type = [
            'names' => ['Set.<string>']
        ];

        $this->assertEquals('string[]', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_map_wrapped_type()
    {
        $type = [
            'names' => ['Map.<string, boolean>']
        ];

        $this->assertEquals('array', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_deeply_wrapped_type()
    {
        $type = [
            'names' => ['Promise.<Array.<string>>']
        ];

        $this->assertEquals('string[]', $this->formatter->formatType($type));
    }

    /** @test */
    public function can_format_function()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
        ];

        $this->assertEquals('@method void foo()', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_static_function()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'static',
        ];

        $this->assertEquals('@method static void foo()', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_return()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'returns' => [
                [
                    'type' => [
                        'names' => ['boolean'],
                    ],
                ],
            ],
        ];

        $this->assertEquals('@method bool foo()', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_nullable_return()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'returns' => [
                [
                    'type' => [
                        'names' => ['boolean'],
                    ],
                    'nullable' => true,
                ],
            ],
        ];

        $this->assertEquals('@method bool|null foo()', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_parameter()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'params' => [
                [
                    'name' => 'bar',
                ],
            ],
        ];

        $this->assertEquals('@method void foo(array $bar)', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_typed_parameter()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'params' => [
                [
                    'name' => 'bar',
                    'type' => [
                        'names' => ['string']
                    ]
                ],
            ],
        ];

        $this->assertEquals('@method void foo(string $bar)', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_multiple_parameters()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'params' => [
                [
                    'name' => 'bar',
                ],
                [
                    'name' => 'baz',
                ],
            ],
        ];

        $this->assertEquals('@method void foo(array $bar, array $baz)', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_optional_parameter()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'params' => [
                [
                    'name' => 'bar',
                    'optional' => true,
                ],
            ],
        ];

        $this->assertEquals('@method void foo(array $bar = [])', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_nullable_parameter()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'params' => [
                [
                    'name' => 'bar',
                    'nullable' => true,
                ],
            ],
        ];

        $this->assertEquals('@method void foo(array|null $bar)', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_optional_typed_parameter()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'params' => [
                [
                    'name' => 'bar',
                    'optional' => true,
                    'type' => [
                        'names' => ['string'],
                    ],
                ],
            ],
        ];

        $this->assertEquals('@method void foo(string $bar = null)', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_optional_string_parameter_with_default()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'params' => [
                [
                    'name' => 'bar',
                    'optional' => true,
                    'defaultvalue' => 'baz',
                    'type' => [
                        'names' => ['string'],
                    ],
                ],
            ],
        ];

        $this->assertEquals('@method void foo(string $bar = \'baz\')', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_function_with_variable_parameters()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'instance',
            'params' => [
                [
                    'name' => 'args',
                    'variable' => true,
                ],
            ],
        ];

        $this->assertEquals('@method void foo(array ...$args)', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_member()
    {
        $doclet = [
            'kind' => 'member',
            'name' => 'foo'
        ];

        $this->assertEquals('@property mixed $foo', $this->formatter->format($doclet));
    }

    /** @test */
    public function can_format_typed_member()
    {
        $doclet = [
            'kind' => 'member',
            'name' => 'foo',
            'returns' => [
                [
                    'type' => [
                        'names' => ['string']
                    ],
                ],
            ],
        ];

        $this->assertEquals('@property string $foo', $this->formatter->format($doclet));
    }

    /** @test @expectedException \LogicException */
    public function throws_exception_when_format_method_not_implemented()
    {
        $doclet = [
            'kind' => 'foobar',
        ];

        $this->formatter->format($doclet);
    }
}
