<?php

namespace Nesk\Puphpeteer\Tests;

use Nesk\Puphpeteer\Support\JsDocFormatter;

class JsDocFormatterTest extends TestCase
{
    /** @test */
    public function can_format_function_type()
    {
        $type = [
            'names' => ['function']
        ];

        $this->assertEquals('\Nesk\Rialto\Data\JsFunction', JsDocFormatter::formatType($type));
    }

    /** @test */
    public function can_format_primitive_type()
    {
        $type = [
            'names' => ['string']
        ];

        $this->assertEquals('string', JsDocFormatter::formatType($type));
    }
    
    /** @test */
    public function can_format_named_type()
    {
        $type = [
            'names' => ['ChromeArgs']
        ];

        $this->assertEquals('array', JsDocFormatter::formatType($type));
    }

    /** @test */
    public function can_format_puppeteer_namespaced_type()
    {
        $type = [
            'names' => ['Puppeteer.Browser']
        ];

        JsDocFormatter::setClassdefs(['Browser']);

        $this->assertEquals('Browser', JsDocFormatter::formatType($type));
    }

    /** @test */
    public function can_format_promise_wrapped_type()
    {
        $type = [
            'names' => ['Promise.<string>']
        ];

        $this->assertEquals('string', JsDocFormatter::formatType($type));
    }

    /** @test */
    public function can_format_array_wrapped_type()
    {
        $type = [
            'names' => ['Array.<string>']
        ];

        $this->assertEquals('string[]', JsDocFormatter::formatType($type));
    }

    /** @test */
    public function can_format_set_wrapped_type()
    {
        $type = [
            'names' => ['Set.<string>']
        ];

        $this->assertEquals('string[]', JsDocFormatter::formatType($type));
    }

    /** @test */
    public function can_format_map_wrapped_type()
    {
        $type = [
            'names' => ['Map.<string, boolean>']
        ];

        $this->assertEquals('array', JsDocFormatter::formatType($type));
    }

    /** @test */
    public function can_format_deeply_wrapped_type()
    {
        $type = [
            'names' => ['Promise.<Array.<string>>']
        ];

        $this->assertEquals('string[]', JsDocFormatter::formatType($type));
    }

    /** @test */
    public function can_format_function()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
        ];

        $this->assertEquals('@method void foo()', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_static_function()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'scope' => 'static',
        ];

        $this->assertEquals('@method static void foo()', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_function_with_return()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'returns' => [
                [
                    'type' => [
                        'names' => ['boolean'],
                    ],
                ],
            ],
        ];

        $this->assertEquals('@method bool foo()', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_function_with_parameter()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'params' => [
                [
                    'name' => 'bar',
                ],
            ],
        ];

        $this->assertEquals('@method void foo(mixed $bar)', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_function_with_typed_parameter()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'params' => [
                [
                    'name' => 'bar',
                    'type' => [
                        'names' => ['string']
                    ]
                ],
            ],
        ];

        $this->assertEquals('@method void foo(string $bar)', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_function_with_multiple_parameters()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'params' => [
                [
                    'name' => 'bar',
                ],
                [
                    'name' => 'baz',
                ],
            ],
        ];

        $this->assertEquals('@method void foo(mixed $bar, mixed $baz)', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_function_with_optional_parameter()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'params' => [
                [
                    'name' => 'bar',
                    'optional' => true,
                ],
            ],
        ];

        $this->assertEquals('@method void foo(mixed $bar = null)', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_function_with_variable_parameters()
    {
        $doclet = [
            'kind' => 'function',
            'name' => 'foo',
            'params' => [
                [
                    'name' => 'args',
                    'variable' => true,
                ],
            ],
        ];

        $this->assertEquals('@method void foo(mixed ...$args)', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_member()
    {
        $doclet = [
            'kind' => 'member',
            'name' => 'foo'
        ];

        $this->assertEquals('@property mixed $foo', JsDocFormatter::format($doclet));
    }

    /** @test */
    public function can_format_typed_member()
    {
        $doclet = [
            'kind' => 'doclet',
            'name' => 'foo',
            'returns' => [
                [
                    'type' => [
                        'names' => ['string']
                    ],
                ],
            ],
        ];

        $this->assertEquals('@property string $foo', JsDocFormatter::formatMember($doclet));
    }
    
    /** @test @expectedException \LogicException */
    public function throws_exception_when_format_method_not_implemented()
    {
        $doclet = [
            'kind' => 'foobar',
        ];

        JsDocFormatter::format($doclet);
    }
}
