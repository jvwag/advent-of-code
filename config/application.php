<?php

namespace jvwag\AdventOfCode;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use function DI\autowire;
use function DI\factory;

return [
    "application.name" => "advent-of-code",
    "application.version" => factory(static function () {
        return shell_exec("git describe --long 2>/dev/null") ?? "unknown-version";
    }),

    Application::class => factory(static function (ContainerInterface $c) {
        $app = new Application($c->get("application.name"), $c->get("application.version"));

        $command_loader = new FactoryCommandLoader([
            AssignmentRunCommand::COMMAND_NAME => static function () use ($c) {
                return $c->get(AssignmentRunCommand::class);
            }
        ]);

        $app->setCommandLoader($command_loader);

        return $app;
    }),

    AssignmentFactory::class => autowire(),
    AssignmentRunCommand::class => autowire(),
    AssignmentDownloader::class => autowire(),
];