# PuPHPeteer

<img src="https://user-images.githubusercontent.com/817508/100672192-dd258500-3361-11eb-845f-e8b5109752e4.png" style="max-width:100%;" width="190px" align="right">

[![PHP Version](https://img.shields.io/packagist/php-v/nesk/puphpeteer.svg?style=flat-square)](http://php.net/)
[![Composer Version](https://img.shields.io/packagist/v/nesk/puphpeteer.svg?style=flat-square&label=Composer)](https://packagist.org/packages/nesk/puphpeteer)
[![Node Version](https://img.shields.io/node/v/@nesk/puphpeteer.svg?style=flat-square&label=Node)](https://nodejs.org/)
[![NPM Version](https://img.shields.io/npm/v/@nesk/puphpeteer.svg?style=flat-square&label=NPM)](https://www.npmjs.com/package/@nesk/puphpeteer)
[![Build Status](https://img.shields.io/travis/nesk/puphpeteer.svg?style=flat-square&label=Build%20Status)](https://travis-ci.org/nesk/puphpeteer)

A [Puppeteer](https://github.com/GoogleChrome/puppeteer/) bridge for PHP, supporting the entire API. Based on [Rialto](https://github.com/nesk/rialto/), a package to manage Node resources from PHP.

Here are some examples [borrowed from Puppeteer's documentation](https://github.com/GoogleChrome/puppeteer/blob/master/README.md#usage) and adapted to PHP's syntax:

**Example** - navigating to https://example.com and saving a screenshot as *example.png*:

```php
use Nesk\Puphpeteer\Puppeteer;

$puppeteer = new Puppeteer;
$browser = $puppeteer->launch();

$page = $browser->newPage();
$page->goto('https://example.com');
$page->screenshot(['path' => 'example.png']);

$browser->close();
```

**Example** - evaluate a script in the context of the page:

```php
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

$puppeteer = new Puppeteer;

$browser = $puppeteer->launch();
$page = $browser->newPage();
$page->goto('https://example.com');

// Get the "viewport" of the page, as reported by the page.
$dimensions = $page->evaluate(JsFunction::createWithBody("
    return {
        width: document.documentElement.clientWidth,
        height: document.documentElement.clientHeight,
        deviceScaleFactor: window.devicePixelRatio
    };
"));

printf('Dimensions: %s', print_r($dimensions, true));

$browser->close();
```

## Requirements and installation

This package requires PHP >= 7.3 and Node >= 8.

Install it with these two command lines:

```shell
composer require nesk/puphpeteer
npm install @nesk/puphpeteer
```

## Notable differences between PuPHPeteer and Puppeteer

### Puppeteer's class must be instantiated

Instead of requiring Puppeteer:

```js
const puppeteer = require('puppeteer');
```

You have to instantiate the `Puppeteer` class:

```php
$puppeteer = new Puppeteer;
```

This will create a new Node process controlled by PHP.

You can also pass some options to the constructor, see [Rialto's documentation](https://github.com/nesk/rialto/blob/master/docs/api.md#options). PuPHPeteer also extends these options:

```php
[
    // Logs the output of Browser's console methods (console.log, console.debug, etc...) to the PHP logger
    'log_browser_console' => false,
]
```

<details>
<summary><strong>⏱ Want to use some timeouts higher than 30 seconds in Puppeteer's API?</strong></summary> <br>

If you use some timeouts higher than 30 seconds, you will have to set a higher value for the `read_timeout` option (default: `35`):

```php
$puppeteer = new Puppeteer([
    'read_timeout' => 65, // In seconds
]);

$puppeteer->launch()->newPage()->goto($url, [
    'timeout' => 60000, // In milliseconds
]);
```
</details>

### No need to use the `await` keyword

With PuPHPeteer, every method call or property getting/setting is synchronous.

### Some methods have been aliased

The following methods have been aliased because PHP doesn't support the `$` character in method names:

- `$` => `querySelector`
- `$$` => `querySelectorAll`
- `$x` => `querySelectorXPath`
- `$eval` => `querySelectorEval`
- `$$eval` => `querySelectorAllEval`

Use these aliases just like you would have used the original methods:

```php
$divs = $page->querySelectorAll('div');
```

### Evaluated functions must be created with `JsFunction`

Functions evaluated in the context of the page must be written [with the `JsFunction` class](https://github.com/nesk/rialto/blob/master/docs/api.md#javascript-functions), the body of these functions must be written in JavaScript instead of PHP.

```php
use Nesk\Rialto\Data\JsFunction;

$pageFunction = JsFunction::createWithParameters(['element'])
    ->body("return element.textContent");
```

### Exceptions must be caught with `->tryCatch`

If an error occurs in Node, a `Node\FatalException` will be thrown and the process closed, you will have to create a new instance of `Puppeteer`.

To avoid that, you can ask Node to catch these errors by prepending your instruction with `->tryCatch`:

```php
use Nesk\Rialto\Exceptions\Node;

try {
    $page->tryCatch->goto('invalid_url');
} catch (Node\Exception $exception) {
    // Handle the exception...
}
```

Instead, a `Node\Exception` will be thrown, the Node process will stay alive and usable.

### Puppeteer plugins

To use puppeteer-extra plugins add them to your project:
```shell
npm install puppeteer puppeteer-extra puppeteer-extra-plugin-stealth
```

Then override js inclusion with js_extra option
```php
    $puppeteer = new Puppeteer([
        'js_extra' => /** @lang JavaScript */ "
            const puppeteer = require('puppeteer-extra');
            const StealthPlugin = require('puppeteer-extra-plugin-stealth');
            puppeteer.use(StealthPlugin());
            instruction.setDefaultResource(puppeteer);
        "
    ]);
```



## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Logo attribution

PuPHPeteer's logo is composed of:

- [Puppet](https://thenounproject.com/search/?q=puppet&i=52120) by Luis Prado from [the Noun Project](http://thenounproject.com/).
- [Elephant](https://thenounproject.com/search/?q=elephant&i=954119) by Lluisa Iborra from [the Noun Project](http://thenounproject.com/).

Thanks to [Laravel News](https://laravel-news.com/) for picking the icons and colors of the logo.
