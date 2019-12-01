#!/bin/env php
<?php

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

try {
    /** @var ContainerInterface $container */
    $container = require __DIR__ . "/../bootstrap.php";

    $app = $container->get(Application::class);
    $app->run();
} catch (Exception | ContainerExceptionInterface $e) {
    echo $e . PHP_EOL;
}

