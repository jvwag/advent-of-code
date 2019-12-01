<?php

use DI\ContainerBuilder;

require_once __DIR__ . "/vendor/autoload.php";

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . "/config/advent-settings.php");
$containerBuilder->addDefinitions(__DIR__ . "/config/application.php");
$containerBuilder->addDefinitions(__DIR__ . "/config/http-client.php");
$containerBuilder->addDefinitions(__DIR__ . "/config/logger.php");

if (file_exists(__DIR__ . "/config/overrides.php")) {
    $containerBuilder->addDefinitions(__DIR__ . "/config/overrides.php");
}

/** @noinspection PhpUnhandledExceptionInspection */
return $containerBuilder->build();
