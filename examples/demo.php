<?php

require __DIR__.'/../vendor/autoload.php';

$phpPuppeteer = new Nesk\Puphpeteer\Puppeteer();
try {
	$options = [
		'headless' => false,
		'ignoreHTTPSErrors' => true,
		'ignoreDefaultArgs' => false,
		'args' => [
			'--incognito',
			'--0',// disable timing information for chrome://profiler
			'--window-size=800,600',
		],
	];
	$browser = $phpPuppeteer->launch($options);
	$browser->pages()[0]->close();
	$page = $browser->newPage();
	$page->goto('https://example.com', [
		'waitUntil' => 'networkidle0',
	]);
	$page->waitForTimeout(5000);
	$browser->close();

} catch (\Throwable $throwable) {
	echo '[!] ERROR: '.$throwable->getMessage().' in '.$throwable->getFile().':'.$throwable->getLine().PHP_EOL;
}
