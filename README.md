# PuPHPeteer

A [Puppeteer](https://github.com/GoogleChrome/puppeteer/) bridge for PHP, supporting the full API. Based on [Rialto](https://github.com/extractr-io/rialto/), a package to manage Node resources from PHP.

Here are some examples [borrowed from Puppeteer's documentation](https://github.com/GoogleChrome/puppeteer/blob/master/README.md#usage) and adapted to PHP's syntax:

**Example** - navigating to https://example.com and saving a screenshot as *example.png*:

```php
use ExtractrIo\Puphpeteer\Puppeteer;

$puppeteer = new Puppeteer;
$browser = $puppeteer->launch();

$page = $browser->newPage();
$page->goto('https://example.com');
$page->screenshot(['path' => 'example.png']);

$browser->close();
```

**Example** - evaluate a script in the context of the page:

```php
use ExtractrIo\Puphpeteer\Puppeteer;
use ExtractrIo\Rialto\Data\JsFunction;

$puppeteer = new Puppeteer;

$browser = $puppeteer->launch();
$page = $browser->newPage();
$page->goto('https://example.com');

// Get the "viewport" of the page, as reported by the page.
$dimensions = $page->evaluate(JsFunction::create("
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

This package requires PHP >= 7.1 and Node >= 8.

Install it with these two command lines:

```shell
composer require extractr-io/puphpeteer
npm install @extractr-io/puphpeteer
```

## Notable differences between PuPHPeteer and Puppeteer

### Puppeteer's class must be instanciated

Instead of requiring Puppeteer:

```js
const puppeteer = require('puppeteer');
```

You have to instanciate the `Puppeteer` class:

```php
$puppeteer = new Puppeteer;
```

This will create a new Node process controlled by PHP.

You can also pass some options to the constructor, see [Rialto's documentation](https://github.com/extractr-io/rialto/blob/master/docs/api.md#options).

**Note:** If you use some timeouts higher than 30 seconds in Puppeteer's API, you will have to set a higher value for the `read_timeout` option (default: `35`):

```php
$puppeteer = new Puppeteer([
    'read_timeout' => 65, // In seconds
]);

$puppeteer->launch()->newPage()->goto($url, [
    'timeout' => 60000, // In milliseconds
]);
```

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

Functions evaluated in the context of the page must be written [with the `JsFunction` class](https://github.com/extractr-io/rialto/blob/master/docs/api.md#javascript-functions), the body of these functions must be written in JavaScript instead of PHP.

```php
use ExtractrIo\Rialto\Data\JsFunction;

$pageFunction = JsFunction::create(['element'], "
    return element.textContent;
");
```

### Exceptions must be catched with `->tryCatch`

If an error occurs in Node, a `Node\FatalException` will be thrown and the process closed, you will have to create a new instance of `Puppeteer`.

To avoid that, you can ask Node to catch these errors by prepending your instruction with `->tryCatch`:

```php
use ExtractrIo\Rialto\Exceptions\Node;

try {
    $page->tryCatch->goto('invalid_url');
} catch (Node\Exception $exception) {
    // Handle the exception...
}
```

Instead, a `Node\Exception` will be thrown, the Node process will stay alive and usable.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
