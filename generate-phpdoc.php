#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Nesk\Puphpeteer\Command\GenerateDocumentationCommand;

(new Application())
    ->add(new GenerateDocumentationCommand)
    ->getApplication()
    ->setDefaultCommand('generate', true)
    ->run();
