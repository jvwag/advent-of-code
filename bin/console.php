#!/usr/bin/php
<?php

use jvwag\AdventOfCode\DIContainer;

require(__DIR__."/../vendor/autoload.php");

$container = DIContainer::buildContainer(__DIR__."/../");
$application = $container->get("application");
$application->run();
