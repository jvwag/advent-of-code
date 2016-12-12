<?php

use jvwag\AdventOfCode\AssignmentDownloader;
use jvwag\AdventOfCode\AssignmentFactory;
use jvwag\AdventOfCode\AssignmentRunCommand;
use jvwag\AdventOfCode\DIContainer;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Reference;

$config = json_decode(file_get_contents(__DIR__."/config.json"), true);

/** @var $container DIContainer */
$container->setParameter('year', $config["year"]);
$container->setParameter('session', $config["session"]);
$container->setParameter('application.name', 'advent-of-code');

$container
    ->register('application', Application::class)
    ->addArgument('%application.name%')
    ->addMethodCall("add", [new Reference("run_command")]);

$container
    ->register("run_command", AssignmentRunCommand::class)
    ->addMethodCall("setContainer", [$container]);

$container
    ->register('logger', Monolog\Logger::class)
    ->addArgument('%application.name%');

$container
    ->register("assignment_factory", AssignmentFactory::class)
    ->setAutowired(true);

$container
    ->register('http_client', GuzzleHttp\Client::class);

$container
    ->register("assignment_downloader", AssignmentDownloader::class)
    ->addArgument('%year%')
    ->addArgument('%session%')
    ->addArgument(new Reference('logger'))
    ->addArgument(new Reference('http_client'));
